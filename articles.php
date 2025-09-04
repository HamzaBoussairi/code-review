<?php
session_start();

// Configuration de base
$site_title = "Mon Site de Test";
$current_page = "articles";

// Données d'exemple pour les articles (plus complètes)
$articles = [
    [
        'id' => 1,
        'title' => 'Introduction au développement web moderne',
        'content' => 'Le développement web a considérablement évolué ces dernières années. Avec l\'émergence de nouvelles technologies comme React, Vue.js, et Angular, les développeurs ont désormais accès à des outils puissants pour créer des applications web interactives et performantes. Dans cet article, nous explorerons les tendances actuelles du développement web et les meilleures pratiques à adopter.',
        'author' => 'John Doe',
        'date' => '2024-01-15',
        'category' => 'Technologie',
        'image' => 'https://via.placeholder.com/400x250/3b82f6/ffffff?text=Web+Dev',
        'tags' => ['JavaScript', 'React', 'Web Development']
    ],
    [
        'id' => 2,
        'title' => 'Les principes du design UI/UX',
        'content' => 'Un bon design UI/UX est essentiel pour le succès de toute application web. Il ne s\'agit pas seulement de créer quelque chose de beau, mais aussi de s\'assurer que l\'interface est intuitive et accessible. Les principes de base incluent la hiérarchie visuelle, la cohérence, la simplicité et l\'accessibilité. Chaque élément doit avoir un but et contribuer à l\'expérience utilisateur globale.',
        'author' => 'Jane Smith',
        'date' => '2024-01-10',
        'category' => 'Design',
        'image' => 'https://via.placeholder.com/400x250/10b981/ffffff?text=UI+UX',
        'tags' => ['Design', 'UX', 'UI', 'Accessibilité']
    ],
    [
        'id' => 3,
        'title' => 'Optimisation des performances web',
        'content' => 'La performance web est cruciale pour l\'expérience utilisateur et le référencement. Des techniques comme la minification, la compression, le lazy loading et l\'optimisation des images peuvent considérablement améliorer les temps de chargement. Il est également important de mesurer régulièrement les performances avec des outils comme Lighthouse et WebPageTest.',
        'author' => 'Bob Wilson',
        'date' => '2024-01-05',
        'category' => 'Développement',
        'image' => 'https://via.placeholder.com/400x250/f59e0b/ffffff?text=Performance',
        'tags' => ['Performance', 'Optimisation', 'Web']
    ],
    [
        'id' => 4,
        'title' => 'Sécurité des applications web',
        'content' => 'La sécurité web est un aspect fondamental du développement moderne. Les vulnérabilités comme XSS, CSRF, et les injections SQL peuvent compromettre la sécurité des utilisateurs. Il est essentiel d\'implémenter des mesures de sécurité dès le début du développement, incluant la validation des données, l\'authentification sécurisée et le chiffrement des communications.',
        'author' => 'Alice Brown',
        'date' => '2024-01-02',
        'category' => 'Sécurité',
        'image' => 'https://via.placeholder.com/400x250/ef4444/ffffff?text=Security',
        'tags' => ['Sécurité', 'HTTPS', 'Authentication']
    ],
    [
        'id' => 5,
        'title' => 'L\'avenir du développement mobile',
        'content' => 'Le développement mobile continue d\'évoluer avec des technologies comme React Native, Flutter et les Progressive Web Apps (PWA). Ces solutions permettent de créer des applications multiplateformes efficaces tout en réduisant les coûts de développement. L\'avenir semble prometteur avec l\'émergence de nouvelles API natives et l\'amélioration constante des performances.',
        'author' => 'Charlie Davis',
        'date' => '2023-12-28',
        'category' => 'Mobile',
        'image' => 'https://via.placeholder.com/400x250/8b5cf6/ffffff?text=Mobile',
        'tags' => ['Mobile', 'React Native', 'Flutter', 'PWA']
    ],
    [
        'id' => 6,
        'title' => 'Intelligence artificielle et développement',
        'content' => 'L\'IA transforme la façon dont nous développons des applications. Des outils comme GitHub Copilot aident les développeurs à écrire du code plus rapidement, tandis que l\'IA générative ouvre de nouvelles possibilités pour créer du contenu dynamique. Cependant, il est important de comprendre les limites et les implications éthiques de ces technologies.',
        'author' => 'Eva Green',
        'date' => '2023-12-20',
        'category' => 'IA',
        'image' => 'https://via.placeholder.com/400x250/06b6d4/ffffff?text=AI+Dev',
        'tags' => ['IA', 'Machine Learning', 'Automation']
    ]
];

// Fonction pour formater la date
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

// Fonction pour générer un extrait
function getExcerpt($content, $length = 200) {
    return strlen($content) > $length ? substr($content, 0, $length) . '...' : $content;
}

// Filtrage par catégorie
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
$filtered_articles = $selected_category ? 
    array_filter($articles, function($article) use ($selected_category) {
        return $article['category'] === $selected_category;
    }) : $articles;

// Obtenir toutes les catégories uniques
$categories = array_unique(array_column($articles, 'category'));
sort($categories);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - <?php echo $site_title; ?></title>
    <meta name="description" content="Découvrez nos articles sur le développement web, le design, la sécurité et bien plus encore.">
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
                    <a href="index.php" class="nav-link">Accueil</a>
                </li>
                <li class="nav-item">
                    <a href="articles.php" class="nav-link <?php echo $current_page === 'articles' ? 'active' : ''; ?>">Articles</a>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Nos Articles</h1>
            <p class="page-description">
                Découvrez nos derniers articles sur le développement web, le design, la sécurité et les nouvelles technologies.
            </p>
        </div>
    </section>

    <!-- Filters -->
    <section class="filters-section">
        <div class="container">
            <div class="filters">
                <a href="articles.php" class="filter-btn <?php echo !$selected_category ? 'active' : ''; ?>">
                    Tous (<?php echo count($articles); ?>)
                </a>
                <?php foreach ($categories as $category): ?>
                    <?php $count = count(array_filter($articles, function($a) use ($category) { return $a['category'] === $category; })); ?>
                    <a href="articles.php?category=<?php echo urlencode($category); ?>" 
                       class="filter-btn <?php echo $selected_category === $category ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($category); ?> (<?php echo $count; ?>)
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="articles-section">
        <div class="container">
            <?php if (empty($filtered_articles)): ?>
                <div class="no-articles">
                    <h3>Aucun article trouvé</h3>
                    <p>Il n'y a pas d'articles dans cette catégorie pour le moment.</p>
                    <a href="articles.php" class="btn btn-primary">Voir tous les articles</a>
                </div>
            <?php else: ?>
                <div class="articles-grid">
                    <?php foreach ($filtered_articles as $article): ?>
                        <article class="article-card" data-article-id="<?php echo $article['id']; ?>">
                            <div class="article-image">
                                <img src="<?php echo $article['image']; ?>" 
                                     alt="<?php echo htmlspecialchars($article['title']); ?>"
                                     loading="lazy">
                                <div class="article-overlay">
                                    <span class="read-time">5 min de lecture</span>
                                </div>
                            </div>
                            <div class="article-content">
                                <div class="article-header">
                                    <span class="article-category"><?php echo htmlspecialchars($article['category']); ?></span>
                                    <span class="article-date"><?php echo formatDate($article['date']); ?></span>
                                </div>
                                <h3 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                                <p class="article-excerpt">
                                    <?php echo getExcerpt(htmlspecialchars($article['content'])); ?>
                                </p>
                                <div class="article-tags">
                                    <?php foreach ($article['tags'] as $tag): ?>
                                        <span class="tag">#<?php echo htmlspecialchars($tag); ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="article-footer">
                                    <span class="article-author">Par <?php echo htmlspecialchars($article['author']); ?></span>
                                    <a href="article.php?id=<?php echo $article['id']; ?>" class="read-more">Lire plus →</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2>Restez informé</h2>
                <p>Recevez nos derniers articles directement dans votre boîte mail.</p>
                <form class="newsletter-form" action="#" method="POST">
                    <input type="email" name="email" placeholder="Votre adresse email" required>
                    <button type="submit" class="btn btn-primary">S'abonner</button>
                </form>
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
    <style>
        /* Styles spécifiques pour la page articles */
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 8rem 0 4rem;
            margin-top: 4rem;
            text-align: center;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .page-description {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .filters-section {
            padding: 2rem 0;
            background-color: var(--surface-color);
            border-bottom: 1px solid var(--border-color);
        }

        .filters {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 25px;
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
            transition: var(--transition);
            background-color: white;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .articles-section {
            padding: 4rem 0;
        }

        .article-image {
            position: relative;
            height: 200px;
            overflow: hidden;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .article-card:hover .article-image img {
            transform: scale(1.05);
        }

        .article-overlay {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.75rem;
        }

        .article-content {
            padding: 1.5rem;
        }

        .article-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .tag {
            background-color: var(--surface-color);
            color: var(--text-secondary);
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .newsletter-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .newsletter-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .newsletter-content p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .newsletter-form {
            display: flex;
            gap: 1rem;
            max-width: 400px;
            margin: 0 auto;
        }

        .newsletter-form input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
        }

        .no-articles {
            text-align: center;
            padding: 4rem 0;
        }

        .no-articles h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .no-articles p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .filters {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }
        }
    </style>
</body>
</html> 