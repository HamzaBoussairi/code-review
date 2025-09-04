<?php
session_start();

// Configuration simple (pas sécurisée volontairement)
$users = array(
    'admin' => 'password123',
    'user' => 'user123',
    'test' => 'test'
);

$error_message = '';
$success_message = '';

// Traitement du formulaire de connexion
if ($_POST) {
    // Validation des champs
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (empty($username) || empty($password)) {
        $error_message = "Veuillez remplir tous les champs";
    } else {
        // Vérification des identifiants
        if (isset($users[$username]) && $users[$username] === $password) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            // Redirection vers la page des articles après connexion
            header('Location: articles.php');
            exit();
        } else {
            $error_message = "Nom d'utilisateur ou mot de passe incorrect";
        }
    }
}

// Vérification de session corrigée
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $current_user = $_SESSION['username'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mon Site de Test</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>Mon Site de Test</h2>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Accueil</a>
                </li>
                <li class="nav-item">
                    <a href="articles.php" class="nav-link">Articles</a>
                </li>
                <li class="nav-item">
                    <a href="login.php" class="nav-link active">Connexion</a>
                </li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="login-section">
        <div class="container">
            <div class="login-container">
                <div class="login-form-wrapper">
                    <h1 class="login-title">Connexion</h1>
                    <p class="login-subtitle">Connectez-vous à votre compte</p>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-error">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success_message): ?>
                        <div class="alert alert-success">
                            <?php echo $success_message; ?>
                            <?php if (isset($current_user)): ?>
                                <br>Utilisateur connecté : <?php echo $current_user; ?>
                                <br><a href="dashboard.php">Aller au tableau de bord</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form class="login-form" method="POST" action="">
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   placeholder="Entrez votre nom d'utilisateur"
                                   value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Entrez votre mot de passe">
                        </div>
                        
                        <div class="form-options">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember"> Se souvenir de moi
                            </label>
                            <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-primary btn-full">
                            Se connecter
                        </button>
                    </form>
                    
                    <div class="login-footer">
                        <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
                    </div>
                    
                    <!-- Informations de debug supprimées pour la sécurité -->
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/main.js"></script>
    <script>
        // Bug volontaire : JavaScript qui bypasse la sécurité
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('.login-form');
            const usernameInput = document.querySelector('#username');
            const passwordInput = document.querySelector('#password');
            
            // Auto-remplissage supprimé pour la sécurité
            
            // Validation côté client améliorée
            loginForm.addEventListener('submit', function(e) {
                if (usernameInput.value.trim().length < 2) {
                    alert('Le nom d\'utilisateur doit faire au moins 2 caractères');
                    e.preventDefault();
                    return false;
                }
                
                if (passwordInput.value.trim().length < 3) {
                    alert('Le mot de passe doit faire au moins 3 caractères');
                    e.preventDefault();
                    return false;
                }
            });
            
            // Fonction de bypass supprimée pour la sécurité
        });
    </script>
    
    <style>
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 0;
        }
        
        .login-container {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .login-form-wrapper {
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .login-subtitle {
            text-align: center;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        
        .checkbox-label input {
            margin-right: 0.5rem;
        }
        
        .forgot-password {
            font-size: 0.875rem;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .btn-full {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }
        
        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
        }
        
        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        
        .alert-success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }
        
        /* Bug volontaire : styles pour les infos de debug */
        .debug-info {
            margin-top: 2rem;
            padding: 1rem;
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
        }
        
        .debug-info h3 {
            color: #856404;
            margin-bottom: 0.5rem;
        }
        
        .debug-info ul {
            margin: 0.5rem 0;
            padding-left: 1rem;
        }
        
        @media (max-width: 480px) {
            .login-form-wrapper {
                padding: 2rem;
                margin: 1rem;
            }
            
            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</body>
</html> 