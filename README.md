# M2i CDA 05/21 PHP Framework

> ⚠️ This is a PHP MVC micro-framework created for educational purposes.

## Installation

### Prérequis

- Une installation de PHP: https://www.php.net/downloads.
- Une installation de Composer: https://getcomposer.org/download/.
- Une installation d'un système de base de données (MySQL, PostgreSQL…).

### Lancer une application exemple

- Depuis le dossier d'une application exemple (par exemple: `examples/quiz-mvc`), installer les dépendances:

> `composer install`

- Puis, lancer le serveur local de PHP:

> `php -S localhost:8000`

- Ajouter un fichier `database.json` dans ce dossier (sur le modèle de `database.example.json`) afin de spécifier l'adresse de votre serveur de base de données, le nom de la base de données, ainsi que les identifiants permettant de s'y connecter.

L'application est alors accessible à partir de http://localhost:8000.
