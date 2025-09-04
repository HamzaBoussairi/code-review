<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class LoginTest extends TestCase
{
    private string $targetFile;

    protected function setUp(): void
    {
        parent::setUp();
        // Point to the login page under test:
        $this->targetFile = getcwd() . DIRECTORY_SEPARATOR . 'login.php';
        if (!file_exists($this->targetFile)) {
            // Fallback: try public/login.php if typical structure
            $alt = getcwd() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'login.php';
            if (file_exists($alt)) {
                $this->targetFile = $alt;
            }
        }
        if (!file_exists($this->targetFile)) {
            $this->markTestSkipped('login.php not found at repository root or public/login.php');
        }
        // Ensure a clean superglobal and session state
        $_GET = [];
        $_POST = [];
        $_SERVER = ['REQUEST_METHOD' => 'GET'];
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_write_close();
        }
        // Force a fresh session for each test
        @session_id('');
        @session_start();
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        // Cleanup buffers and session between tests
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_write_close();
        }
        parent::tearDown();
    }

    private function includePage(): string
    {
        ob_start();
        // Isolate header operations: use output buffering; headers can be inspected with headers_list()
        include $this->targetFile;
        return ob_get_clean();
    }

    public function testRendersFormOnGet(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $html = $this->includePage();

        $this->assertStringContainsString('<form class="login-form" method="POST"', $html, 'Login form should render on GET');
        $this->assertStringContainsString('id="username"', $html);
        $this->assertStringContainsString('id="password"', $html);
        $this->assertStringNotContainsString('alert alert-error', $html, 'No error on initial GET');
    }

    public function testShowsErrorWhenFieldsAreEmptyOnPost(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['username' => ' ', 'password' => '']; // both empty after trim

        $html = $this->includePage();

        $this->assertStringContainsString("Veuillez remplir tous les champs", $html);
        $this->assertStringContainsString('alert alert-error', $html);
        // Should not set logged_in nor headers
        $this->assertFalse(isset($_SESSION['logged_in']) && $_SESSION['logged_in'], 'Should not log in on empty fields');
        $this->assertEmpty($this->getHeader('Location'), 'Should not redirect on validation error');
    }

    public function testShowsErrorWhenCredentialsAreIncorrect(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['username' => 'admin', 'password' => 'wrong'];

        $html = $this->includePage();

        $this->assertStringContainsString("Nom d'utilisateur ou mot de passe incorrect", $html);
        $this->assertStringContainsString('alert alert-error', $html);
        $this->assertFalse(isset($_SESSION['logged_in']) && $_SESSION['logged_in'], 'Should not log in with wrong password');
        $this->assertEmpty($this->getHeader('Location'), 'Should not redirect on invalid credentials');
    }

    public function testPostedUsernameIsPreservedInFormValue(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['username' => 'john_doe', 'password' => 'wrong'];

        $html = $this->includePage();

        // Ensure username echoes back into value attribute
        $this->assertStringContainsString('value="john_doe"', $html);
    }

    public function testClientSideValidationStringsPresent(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $html = $this->includePage();

        $this->assertStringContainsString("Le nom d&#039;utilisateur doit faire au moins 2 caractères", $html);
        $this->assertStringContainsString("Le mot de passe doit faire au moins 3 caractères", $html);
    }

    public function testSuccessfulLoginSendsRedirectAndSetsSessionInSubprocess(): void
    {
        // Because login.php calls header('Location: ...') then exit(), we execute it in a separate PHP process
        // to avoid halting the PHPUnit process. We then assert on emitted headers and exit code.
        $php = escapeshellcmd(PHP_BINARY);
        $file = escapeshellarg($this->targetFile);

        // Build a small runner that simulates POST and prints headers + session state before exit
        $runner = <<<'PHT'
<?php
error_reporting(E_ALL);
ob_start();
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = ['username' => 'admin', 'password' => 'password123'];
session_start();
include $argv[1];
// If include didn't exit (unexpected), flush output
ob_end_clean();
$headers = function_exists('headers_list') ? headers_list() : [];
echo "HEADERS:\n";
foreach ($headers as $h) { echo $h, "\n"; }
echo "SESSION:\n";
echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ? "logged_in=1\n" : "logged_in=0\n";
echo isset($_SESSION['username']) ? "username=".$_SESSION['username']."\n" : "username=\n";
PHT;

        $tmpRunner = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'login_runner_' . uniqid() . '.php';
        file_put_contents($tmpRunner, $runner);

        // Execute runner and capture output + exit code
        $cmd = $php . ' ' . escapeshellarg($tmpRunner) . ' ' . $file . ' 2>&1';
        exec($cmd, $outLines, $code);

        // Basic assertions
        $out = implode("\n", $outLines);
        // Should have redirected to articles.php
        $this->assertStringContainsStringIgnoreCase('Location: articles.php', $out, "Should send Location header to articles.php");
        // Should have set session values before exit
        $this->assertStringContainsString("logged_in=1", $out);
        $this->assertStringContainsString("username=admin", $out);

        // Exit code likely 0 because script exits normally; we accept either 0 or 255 variations across environments.
        $this->assertContains($code, [0, 255], "Unexpected exit code: $code");

        // Cleanup
        @unlink($tmpRunner);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function testCurrentUserIsExposedWhenSessionAlreadyLoggedIn(): void
    {
        // The page echoes current_user within success message block when $success_message is non-empty.
        // We simulate a GET where the session is already logged in and inject a success message via scope.
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = 'test';

        // Wrap include in a closure to introduce $success_message in local scope
        $html = (function(string $file) {
            $success_message = 'Connexion réussie.'; // trigger the success block
            ob_start();
            include $file;
            return ob_get_clean();
        })($this->targetFile);

        $this->assertStringContainsString('Utilisateur connecté : test', $html);
        $this->assertStringContainsString('Aller au tableau de bord', $html);
    }

    // Helpers

    private function getHeader(string $prefix): ?string
    {
        if (!function_exists('headers_list')) {
            return null;
        }
        foreach (headers_list() as $h) {
            if (stripos($h, $prefix) === 0) {
                return $h;
            }
        }
        return null;
    }

    // Polyfill for PHPUnit < 10 environments lacking assertStringContainsStringIgnoreCase
    private function assertStringContainsStringIgnoreCase(string $needle, string $haystack, string $message = ''): void
    {
        if (method_exists($this, 'assertStringContainsStringIgnoringCase')) {
            $this->assertStringContainsStringIgnoringCase($needle, $haystack, $message);
            return;
        }
        $this->assertStringContainsString(strtolower($needle), strtolower($haystack), $message);
    }
}