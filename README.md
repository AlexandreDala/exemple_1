# Codespace LAMP d'exemple

Ce codespace fournit un environnement de développement LAMP (Linux, Apache/PHP, MariaDB) prêt à l'emploi pour vos projets PHP. Il est configuré avec tous les outils modernes nécessaires au développement professionnel : débogage avec XDebug, tests unitaires avec PHPUnit, génération de documentation avec phpDocumentor, et intégration CI/CD avec GitHub Actions.

Ce dépôt contient un exemple basique de site php avec une classe et le fichier de test associé.


## Arborescence du dépôt

Voici l'arborescence du dépôt et le rôle des différents composants : 

```
.
├── .devcontainer/ : config du codespace
│   ├── devcontainer.json : Configuration du Dev Container pour VS Code
│   ├── setup-lamp.sh : Script de configuration de l'environnement LAMP (MariaDB, PhpMyAdmin)
│   └── Dockerfile : Dockerfile pour construire l'image du Dev Container serveur php avec mariadb
├── .github/ : config pour les actions GitHub 
│   ├── dependabot.yml : Configuration pour Dependabot, qui gère les mises à jour des dépendances
│   └── workflows/ : Workflows GitHub Actions pour CI/CD automatisés
│       ├── documentation.yml : Génération automatique de documentation avec phpDocumentor
│       ├── syntax.yml : Vérification de la qualité et syntaxe du code PHP
│       └── tests.yml : Exécution des tests unitaires avec PHPUnit
├── .vscode/ : config pour XDebug et parametres de vscode
├── database/ : scripts pour la BDD ⭐
│   ├── scripts/ : contient 3 scripts bash pour gérer la BDD métier
│   └── sources-sql/ : fichiers SQL pour contruire la BDD métier ⭐
├── documentation/ : Dossier pour la documentation du projet
│   ├── generated/ : Documentation générée automatiquement par phpDocumentor
│   └── tools/ : Outils de génération de documentation (phpDocumentor.phar, phpdoc.xml)
├── site/ : Dossier pour le code du site web (API, front-end, etc.) ⭐
├── tests/ : Dossier pour les tests unitaires (PHPUnit) ⭐
├── composer.json : Configuration des dépendances PHP et autoloader (utilisé pour PHPUnit)
├── composer.lock : Fichier de verrouillage des versions exactes des dépendances (utilisé pour PHPUnit)
├── start.sh : Script de lancement pour démarrer les services
└── stop.sh : Script pour arreter les services
```

### 📁 Dossiers principaux à modifier (⭐)

- **`site/`** : Votre code PHP (classes, API, pages web)
- **`tests/`** : Vos tests unitaires PHPUnit  
- **`database/sources-sql/`** : Vos fichiers SQL de base de données

### ⚙️ Fichiers de configuration (optionnels)

- **`devcontainer.json`** : Variables d'environnement du codespace à adapter
- **`workflows/`** : Actions GitHub pour CI/CD automatisés (tests, documentation, qualité)
- **`documentation/tools/phpdoc.xml`** : Configuration de génération de documentation
- **`composer.json`** : Gestion des dépendances PHP et autoloader


## Configuration du Codespace et lancement de l'application

Ce dépôt est configuré pour fonctionner avec les Codespaces de GitHub et les Dev Containers de Visual Studio Code. Suivez les étapes ci-dessous pour configurer votre environnement de développement.

### Utilisation avec GitHub Codespaces
1. **Créez un codespace pour ouvrir ce dépot** :
   - Cliquez sur le bouton "Code" dans GitHub et sélectionnez "Open with Codespaces".
   - Si vous n'avez pas encore de Codespace, cliquez sur "New Codespace".

   Le Codespace ainsi créé contient toutes les configurations nécessaires pour démarrer le développement.
   Au lancement, le fichier devcontainer.json 

### Serveur php et service mariadb (avec la base métier)

1. **Pour lancer les services** :
   - Dans le terminal, exécutez le script `start.sh` :
     ```bash
     ./start.sh
     ```
   Ce script démarre le serveur PHP intégré sur le port 8000, démarre mariadb et crée la base métier depuis le script renseigné (mettre à jour en fonction du projet).

2. **Ouvrir le service php dans un navigateur** :
   - Accédez à `http://localhost:8000` pour voir la page d'accueil de l'API.

3. **Accèder à la BDD** :
   - En mode commande depuis le client mysql en ligne de commande
   Exemple : 
      ```bash
      mysql -u mediateq-web -p
      ```
   - En client graphique avec l'extension Database dans le codespace (Host:127.0.0.1)

   - avec phpMyAdmin sur le port 8080

4. **initialiser la BDD** :
   - Au premier démarrage, créez la bdd métier avec le fichier sql 
      ```bash
      ./database/scripts/initBDD.sh 
      ```

5. **Sauver et mettre à jour la BDD** :
   - A chaque fois que vous avez fait des modifs significatives dans la BDD métier, lancer le script bash saveBDD pour écraser le fichier sql actuel de la bdd par votre sauvegarde (puis pensez à push sur le distant pour vos collaborateurs)
      ```bash
      ./database/scripts/saveBDD.sh 
      ```
   - Si des modifs ont été faites à la BDD et que vous avez récupéré du dépot distant (pull) une version mise à jour du script de la BDD métier, lancer le script bash reloadBDD pour écraser la bdd actuelle de votre codespace par celle du script récupéré.
      ```bash
      ./database/scripts/reloadBDD.sh 
      ```

## Utilisation de XDebug

Ce Codespace contient XDebug pour le débogage PHP. 

1. **Exemple de déboguage avec Visual Studio Code** :
   - Ouvrez le panneau de débogage en cliquant sur l'icône de débogage dans la barre latérale ou en utilisant le raccourci clavier `Ctrl+Shift+D`.
   - Sélectionnez la configuration "Listen for XDebug" et cliquez sur le bouton de lancement (icône de lecture).
   - Ouvrez un fichier php
   - Ajouter un point d'arrêt.
   - Solicitez dans le navigateur une page qui appelle le traitement
   - Une fois le point d'arrêt atteint, essayez de survoler les variables, d'examiner les variables locales, etc.

[Tuto Grafikart : Xdebug, l'exécution pas à pas ](https://grafikart.fr/tutoriels/xdebug-breakpoint-834)


## Tests unitaires

Ce projet utilise **PHPUnit** pour les tests unitaires automatisés et executés manuellement.

🧪 **[Guide complet des tests →](tests/README.md)**

**Commandes rapides :**
```bash
# Installation des dépendances
composer install

# Exécution des tests
vendor/bin/phpunit --testdox tests/
```

Les tests sont également exécutés automatiquement via GitHub Actions à chaque modification du code.

## Documentation

Ce projet utilise **phpDocumentor** pour générer automatiquement la documentation technique du code PHP.

📖 **[Guide complet de la documentation →](documentation/README.md)**

**Génération rapide :**
```bash
php documentation/tools/phpDocumentor.phar run -c documentation/tools/phpdoc.xml
```

La documentation générée est disponible dans `documentation/generated/index.html`.

## GitHub Actions - Workflows automatisés

Ce projet utilise **GitHub Actions** pour automatiser les tâches de développement (CI/CD). Trois workflows sont configurés pour s'exécuter automatiquement lors des modifications du code.

### 🔧 Workflow "Code Quality & Syntax" (`syntax.yml`)

**Déclenchement :** À chaque push/pull request modifiant les fichiers PHP dans `site/` ou `tests/`

**Actions effectuées :**
- ✅ **Vérification syntaxe PHP** : Détecte les erreurs de syntaxe dans tous les fichiers .php
- 📋 **Analyse du style de code PSR-12** : Vérifie le respect des standards de codage PHP
- 📦 **Validation Composer** : S'assure que composer.json est valide

**Résultat :** Le workflow échoue si des erreurs de syntaxe sont trouvées, mais continue malgré les problèmes de style (informatifs).

### 🧪 Workflow "Tests" (`tests.yml`)

**Déclenchement :** À chaque push/pull request modifiant les fichiers PHP, composer.json ou composer.lock

**Actions effectuées :**
- 🔍 **Détection automatique des tests** : Vérifie la présence de tests dans le dossier `tests/`
- ⚙️ **Configuration PHPUnit** : Génère automatiquement la configuration PHPUnit
- 🧪 **Exécution des tests** : Lance tous les tests unitaires avec PHPUnit
- 📊 **Génération de coverage** : Crée un rapport de couverture de code
- 📤 **Upload des résultats** : Met à disposition les rapports en téléchargement

**Résultat :** Le workflow échoue si des tests échouent. Si aucun test n'est trouvé, affiche un avertissement mais réussit.

### 📚 Workflow "Documentation" (`documentation.yml`)

**Déclenchement :** À chaque push/pull request modifiant les fichiers PHP dans `site/` ou les outils de documentation

**Actions effectuées :**
- 📖 **Génération de documentation** : Utilise phpDocumentor pour créer la documentation HTML
- 📤 **Upload de la documentation** : Met à disposition la documentation générée en téléchargement
- ✅ **Vérification de réussite** : S'assure que index.html a bien été généré

**Résultat :** Génère une documentation HTML complète accessible via les artefacts GitHub Actions.

### 📥 Accès aux résultats des workflows

**Pour consulter les résultats :**
1. Allez dans l'onglet **"Actions"** de votre repository GitHub
2. Cliquez sur l'exécution du workflow qui vous intéresse
3. Dans la section **"Artifacts"**, téléchargez :
   - `phpdoc-documentation` : Documentation HTML générée
   - `test-coverage-php-8.3` : Rapports de tests et couverture de code

### ⚙️ Configuration des workflows

**Workflows configurés pour :**
- **PHP 8.3** : Version moderne et performante
- **Extensions** : mbstring, xml, ctype, iconv, intl, dom, simplexml, tokenizer
- **Standards** : PSR-12 pour le style de code
- **Outils** : phpDocumentor, PHPUnit, PHP CodeSniffer

**Personnalisation :**
- Modifiez les fichiers dans `.github/workflows/` pour adapter les workflows à vos besoins
- Ajustez les chemins de déclenchement dans la section `paths:` de chaque workflow
- Configurez `documentation/tools/phpdoc.xml` pour personnaliser la génération de documentation
