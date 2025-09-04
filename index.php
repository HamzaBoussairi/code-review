<?php
session_start();

// Configuration de base
$site_title = "Mon Site de Test";
$current_page = "accueil";

// Données d'exemple pour les articles
$articles = [
    [
        'id' => 1,
        'title' => 'Premier Article',
        'content' => 'Ceci est le contenu du premier article. Il contient du texte d\'exemple pour tester notre site.',
        'author' => 'John Doe',
        'date' => '2024-01-15',
        'category' => 'Technologie'
    ],
    [
        'id' => 2,
        'title' => 'Deuxième Article',
        'content' => 'Un autre article avec du contenu intéressant pour notre site de démonstration.',
        'author' => 'Jane Smith',
        'date' => '2024-01-10',
        'category' => 'Design'
    ],
    [
        'id' => 3,
        'title' => 'Troisième Article',
        'content' => 'Le dernier article de notre série d\'exemples pour tester les fonctionnalités.',
        'author' => 'Bob Wilson',
        'date' => '2024-01-05',
        'category' => 'Développement'
    ]
];

// Fonction pour formater la date
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?></title>
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
                <h2><?php echo $site_title; ?></h2>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?php echo $current_page === 'accueil' ? 'active' : ''; ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a href="articles.php" class="nav-link">Articles</a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link">À propos</a>
                </li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Bienvenue sur notre site de test</h1>
                <p class="hero-description">
                    Un site simple créé avec PHP, CSS et JavaScript pour tester les fonctionnalités de code review.
                    Explorez nos articles et découvrez nos fonctionnalités.
                </p>
                <div class="hero-buttons">
                    <a href="articles.php" class="btn btn-primary">Voir les articles</a>
                    <a href="contact.php" class="btn btn-secondary">Nous contacter</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <section class="articles-preview">
        <div class="container">
            <h2 class="section-title">Derniers Articles</h2>
            <div class="articles-grid">
                <?php foreach (array_slice($articles, 0, 3) as $article): ?>
                    <article class="article-card" data-article-id="<?php echo $article['id']; ?>">
                        <div class="article-header">
                            <span class="article-category"><?php echo htmlspecialchars($article['category']); ?></span>
                            <span class="article-date"><?php echo formatDate($article['date']); ?></span>
                        </div>
                        <h3 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p class="article-excerpt">
                            <?php echo substr(htmlspecialchars($article['content']), 0, 150) . '...'; ?>
                        </p>
                        <div class="article-footer">
                            <span class="article-author">Par <?php echo htmlspecialchars($article['author']); ?></span>
                            <a href="article.php?id=<?php echo $article['id']; ?>" class="read-more">Lire plus</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number" data-count="150">0</div>
                    <div class="stat-label">Articles publiés</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="1200">0</div>
                    <div class="stat-label">Visiteurs mensuels</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="50">0</div>
                    <div class="stat-label">Commentaires</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="5">0</div>
                    <div class="stat-label">Années d'expérience</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo $site_title; ?></h3>
                    <p>Un site de démonstration pour tester les fonctionnalités de code review et les pull requests.</p>
                </div>
                <div class="footer-section">
                    <h4>Liens rapides</h4>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="articles.php">Articles</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="about.php">À propos</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email: contact@monsite.com</p>
                    <p>Téléphone: +33 1 23 45 67 89</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $site_title; ?>. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html> 