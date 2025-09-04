# Site de Test pour Code Review 🔍

Ce projet est un site web simple créé spécialement pour tester les fonctionnalités de code review et les pull requests. Il contient **volontairement** des bugs et des problèmes de sécurité pour permettre de pratiquer la review de code.

## 📁 Structure du projet

```
AI-code-review/
├── index.php           # Page d'accueil
├── articles.php        # Page de liste des articles
├── login.php          # Page de connexion (avec bugs volontaires)
├── assets/
│   ├── css/
│   │   └── style.css  # Styles CSS
│   └── js/
│       └── main.js    # JavaScript principal
└── README.md          # Ce fichier
```

## 🚀 Installation

1. Clonez ce repository
2. Placez les fichiers dans un serveur web avec PHP (XAMPP, WAMP, MAMP, etc.)
3. Ouvrez `index.php` dans votre navigateur

## 🐛 Bugs volontaires inclus

### Page de connexion (`login.php`)

**Problèmes de sécurité :**
- ✅ Mots de passe stockés en clair
- ✅ Pas de protection contre les injections SQL
- ✅ Validation des champs insuffisante
- ✅ Logique d'authentification défaillante (accepte n'importe quel mot de passe)
- ✅ Informations sensibles affichées en debug
- ✅ Pas de protection CSRF
- ✅ Session mal gérée
- ✅ Bypass JavaScript possible

**Comment tester :**
- Cliquez sur "Se connecter" sans rien saisir → ça marche !
- Tapez n'importe quoi → ça marche aussi !
- Regardez les mots de passe affichés en bas de page
- Ouvrez la console et tapez `adminBypass()` pour un accès admin

### Code général

**Problèmes potentiels :**
- Variables non échappées (XSS)
- Pas de validation des données
- Code JavaScript non optimisé
- Styles CSS redondants
- Structure de fichiers non sécurisée

## 🔧 Utilisation pour les tests

### Créer des branches de test

```bash
# Créer une branche pour corriger l'authentification
git checkout -b fix/authentication-security

# Créer une branche pour améliorer le CSS
git checkout -b feature/improve-styles

# Créer une branche pour optimiser le JavaScript
git checkout -b refactor/optimize-javascript
```

### Scénarios de test suggérés

1. **Correction de sécurité** : Corrigez les problèmes de sécurité dans `login.php`
2. **Refactoring CSS** : Réorganisez et optimisez le CSS
3. **Amélioration JavaScript** : Ajoutez de la validation côté client
4. **Ajout de fonctionnalités** : Créez une vraie page de contact
5. **Optimisation** : Améliorez les performances du site

## 🎯 Objectifs pédagogiques

Ce projet permet de pratiquer :
- La détection de vulnérabilités de sécurité
- La review de code PHP, CSS et JavaScript
- L'utilisation des pull requests
- La collaboration via Git
- Les bonnes pratiques de développement web

## ⚠️ Avertissement

**Ce code contient volontairement des failles de sécurité !**
- Ne jamais utiliser en production
- Utilisé uniquement à des fins pédagogiques
- Les mots de passe sont visibles et non sécurisés

## 🔗 Pages disponibles

- `/` - Page d'accueil avec présentation
- `/articles.php` - Liste des articles avec filtres
- `/login.php` - Page de connexion (bugguée)

## 🛠️ Technologies utilisées

- **PHP** - Backend et templating
- **CSS3** - Styles avec variables CSS et responsive design
- **JavaScript** - Interactivité et animations
- **HTML5** - Structure sémantique

## 📝 Notes pour les reviewers

Lors de vos reviews, cherchez particulièrement :
1. **Sécurité** : Injections, XSS, authentification faible
2. **Performance** : Code non optimisé, requêtes inutiles
3. **Maintenabilité** : Code dupliqué, structure confuse
4. **Accessibilité** : Éléments non accessibles
5. **Bonnes pratiques** : Conventions de nommage, commentaires

Bon code review ! 🚀 