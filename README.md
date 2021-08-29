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

## Créer une nouvelle application

### Ajouter le *framework* comme dépendance

- Dans un nouveau dossier, créer un fichier **composer.json** avec la commande:

> `composer init`

- Si le *framework* a été publié sur Packagist, il suffit de l'ajouter comme dépendance avec la commande:

> `composer require m2i-cda-0521/framework`

- Sinon, cloner ce dépôt, puis ajouter le code suivant dans votre fichier composer.json:

```json
{
    ...
    // Ce code indique à Composer où trouver le code du framework
    "repositories": [
        {
            "type": "path",
            // Dans cet exemple, le code du framework se trouve 2 niveaux au-dessus de celui du projet
            "url": "../../",
            "options": {
                "symlink": true
            }
        }
    ],
    // Ajoute le framework comme dépendance en indiquant dans quelle branche git se trouve le code
    "require": {
        "m2i-cda-0521/framework": "dev-master"
    },
    ...
}
```

- Puis lier la dépendance avec la commande:

> `composer init`

### Rediriger les requêtes

- Afin de rediriger toutes les requêtes HTTP vers votre fichier **index.php**, ajouter un fichier **:htaccess** contenant le code suivant:

```htaccess
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule . index.php [L]
```

### Configurer l'accés à la base de données

- Ajouter un fichier `database.json` contenant le code suivant:

```json
{
    "host": "localhost",    // Remplacer par l'adresse de votre serveur de base de données
    "dbname": "quiz",       // Remplacer par le nom de la base de données associée à l'application
    "username": "root",     // Remplacer par le nom d'utilisateur permettant de se connecter à la base de données
    "password": "root"      // Remplacer par le mot de passe permettant de se connecter à la base de données
}
```

> ⚠️ Votre serveur de base de données **doit** tourner sur le port **3306**.

### Configurer le *front controller*

- Afin de lancer le processus principal qui permettra que le *framework* réponde à toutes les requêtes HTTP, créer un fichier **index.php** contenant le code suivant:

```php
<?php

use Cda0521Framework\Application;

// Active le chargement automatique des classes dans le projet
require_once __DIR__ . '/vendor/autoload.php';

// Passe la main au framework pour traiter la requête HTTP et générer une réponse
$application = new Application();
$application->run();
```

## Utiliser le *framework*

### Créer une vue

Les vues sont des classes qui sont responsables de générer du code HTML, et donc de la partie affichage de l'application.

- Chaque vue **doit** étendre la classe **AbstractView**.
- En conséquence, chaque vue **doit** implémenter la méthode **renderBody()**, qui décrit sa façon de générer un affichage. Il est possible d'inclure des modêles de pages (*templates*), d'écrire du code HTML en utilisant la commande `echo`, ou toute autre manière de générer du code HTML qui fera partie de la répone HTTP.
- Chaque vue **devrait** appeler le constructeur de la classe **AbstractView** afin de lui passer un nom de page que celle-ci écrira dans la balise `title` de la page générée.
- Si une vue a besoin de données pour s'afficher, elle **devrait** exiger la donnée nécessaire dans son constructeur, et la stocker sous forme d'une propriété. Puis, dans la méthode **renderBody()**, elle **devrait** stocker cette propriété dans une variable afin que la donnée soit dans la portée de la méthode.

#### Exemple

```php
// Cette vue construit une page qui dit bonjour à l'utilisateur dont le nom a été passé à la construction
class HelloView extends AbstractView
{
    private string $name;

    public function __construct(string $name)
    {
        parent::__construct('Hello, ' . $name . '!');
        
        $this->name = $name;
    }

    protected function renderBody(): void
    {
        echo 'Hello, ' . $this->name . '!';
    }
}
```

### Créer une route

Les routes permettent d'offrir des points d'entrée dans l'application. Une route **doit** contenir les informations suivantes:

- Une URI (l'adresse entrée par l'utilisateur). Voir [la documentation de Altorouter](https://altorouter.com/usage/mapping-routes.html) pour connaître la syntaxe des URI.
- Un nom de méthode HTTP (typiquement, GET ou POST).
- Un nom de contrôleur (voir section suivante).
- Un nom de route (utile pour débugger l'application).

Chaque route **doit** être écrite au format JSON dans un fichier appelé **routes.json**.

#### Exemple

```json
[
    {
        "uri": "/hello/[a:name]",
        "method": "GET",
        "controller": "HelloController",
        "name": "hello"
    }
]
```

### Créer un contrôleur

Les contrôleurs sont des classes qui sont responsables de traiter les requêtes du client et de renvoyer une réponse.

- Chaque contrôleur **doit** se trouver dans le namespace **App\Controller**.
- Chaque contrôleur **doit** implémenter l'interface **ControllerInterface**.
- En conséquence, chaque contrôleur **doit** implémenter la méthode **invoke()**, qui décrit le comportement que le contrôleur doit adopter lorsque l'application trouve une correspondance entre la requête du client et la route qui lui est associée. Typiquement, un contrôleur réalise les calculs et/ou les actions en base de données nécessaires à l'obtention des données qui lui permettent de créer une vue.
- Si un contrôleur répond à une route pour laquelle l'URI contient un ou plusieurs paramêtres (par exemple: `/resource/[i:id]`, où `[i:id]` correspond à une suite de chiffres représentant l'identifiant en base de données d'une ressource), ce contrôleur **doit** posséder un constructeur qui prend chacune de ces valeurs en paramêtres; en outre, les paramètres du constructeur **doivent** avoir le même nom que les paramêtres dans l'URI (dans cet exemple, il faudrait donc un paramêtre **$id**).
- Chaque contrôleur **doit** renvoyer une vue.

#### Exemple

```php
// Ce contrôleur répond à une route qui contient un paramètre "name", et affiche la vue qui dit bonjour au nom contenu dans ce paramètre
class HelloController implements ControllerInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function invoke(): AbstractView
    {
        return new HelloView($this->name);
    }
}
```

### Créer un modèle

Les modéles sont des classes qui représentent le contenu de la base de données.

- Chaque modèle **peut** étendre la class **AbstractModel**. Cela lui donne automatiquement accès à tout un ensemble d'opérations en base de données classiques.
- Si un modèle étend la classe **AbstractModel**, il **doit** posséder une annotation **Table** indiquant le nom de la table en base de données correspondante.
- Si un modèle étend la classe **AbstractModel**, il **doit** posséder une propriété **$id** correspondant à la clé primaire de la table associée en base de données. Cette clé primaire doit, elle aussi, s'appeler **id**.
- Si un modèle étend la classe **AbstractModel**, chacune de ses propriétés, hormis l'identifiant en base de données, **doit** posséder une annotation **Column** indiquant le nom de la colonne correspondante, dans la table en base de données.

Chaque modèle qui étend la classe **AbstractModel** hérite automatiquement des méthodes suivantes:

| Méthode | Description |
|---|---|
| findAll() | Renvoie tous les enregistrements de la table associée sous forme de modèles |
| findById(id) | Renvoie l'enregistrement correspondant à la clé primaire **id** sous forme de modèle |
| findWhere(columnName, value) | Renvoie tous les enregistrements de la table associée pour lesquels la colonne **columnName** contient la valeur **value** sous forme de modèles |
| save() | Répercute l'état actuel d'un modèle sur l'enregistrement correspondant en base de données; si aucun enregistrement n'existe, en crée un |
| delete() | Supprime l'enregistrement en base de données associé au modèle |

#### Exemple

Dans cet exemple, on crée un modèle "personne" correspondant à une table "people" en base de données.

```sql
CREATE TABLE `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);
```

```php
// src/Model/Person.php
#[Table('people')]
class Person extends AbstractModel
{
    protected int $id;
    #[Column('first_name')]
    protected string $firstName;
    #[Column('last_name')]
    protected string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
```

Puis on prépare une vue qui réclame un exemplaire de ce modèle dans son constructeur.

```php
// src/View/HelloPersonView.php
class HelloPersonView extends AbstractView
{
    private Person $person;

    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    protected function renderBody(): void
    {
        echo 'Hello, ' . $this->person->getFirstName() . '!';
    }
}
```

Enfin, on ajoute une route, et on crée un contrôleur qui prennent comme paramètre l'identifiant en base de données d'une personne. Si jamais aucune personne ne correspond à cet identifiant dans la base de données, on envoie une erreur qui déclenchera la création d'une page 404.

```json
// routes.json
[
    {
        "uri": "/hello/person/[i:id]",
        "method": "GET",
        "controller": "HelloPersonController",
        "name": "hello"
    }
]
```

```php
// src/Controller/HelloPersonController.php
class HelloPersonController implements ControllerInterface
{
    private Person $person;

    public function __construct(int $id)
    {
        $person = Person::findById($id);

        if (is_null($person)) {
            throw new NotFoundException('Person #' . $id . ' does not exist.');
        }

        $this->person = $person;
    }

    public function invoke(): AbstractView
    {
        return new HelloPersonView($this->person);
    }
}
```

### Générer des redirections

Parfois, un contrôleur n'a vocation à produire que des opérations (par exemple, des opérations en base de données), et pas un affiche. Dans ce cas, on pourra chercher à réaliser une redirection vers une autre route (et donc, un autre contrôleur). Le *framework* propose un moyen de générer ce type de réponse: il suffit de faire en sorte qu'un contrôleur renvoie une instance de la classe **RedirectResponse** au lieu d'une classe dérivée de **AbstractView**.

Ceci aura pour effet de relancer l'application au départ, comme si le client venait de demander l'URL passée en paramètre du constructeur de **RedirectResponse**.

#### Exemple

Dans cet exemple, on dispose de deux routes: l'une qui permet d'afficher un formulaire, et l'autre qui permet de traiter ce formulaire une fois que l'utilisateur l'a validé.

```json
// routes.json
[
    {
        "uri": "/form",
        "method": "GET",
        "controller": "DisplayFormController",
        "name": "display_form"
    },
    {
        "uri": "/form",
        "method": "POST",
        "controller": "ProcessFormController",
        "name": "display_form"
    }
]
```

Lorsque le formulaire est validé, le contrôleur **ProcessFormController** est appelé. Si le contenu du formulaire est valide, il crée une instance d'un modéle et lui demande de sauvegarder un enregistrement correspondant en base de données. Dans tous les cas, il n'a aucun affichage particulier à produire, hormis de renvoyer une nouvelle copie du formulaire. Au lieu de répéter le code du contrôleur **DisplayFormController** qui permet d'afficher ce formulaire, on peut demander à **ProcessFormController** de générer une redirection.

```php
// src/Controller/ProcessFormController.php
class ProcessFormController implements ControllerInterface
{
    public function invoke(): AbstractView
    {
        if (isset($_POST['text'])) {
            $todo = new Todo($_POST['text']);
            $todo->save();
        }

        return new RedirectResponse('/form');
    }
}
```

Ainsi, l'application redémarrera et appellera **DisplayFormController** à la place.

### Générer des réponses au format JSON

Dans le cas d'une application web traditionnelle, les vues génèrent du code HTML. Mais lorsque l'on souhaite coder une API, par exemple, il est possible qu'on cherche à obtenir des réponses HTTP encodées au format JSON à la place. Le *framework* propose un moyen de générer ce type de réponse: il suffit de faire en sorte qu'un contrôleur renvoie une instance de la classe **JsonResponse** au lieu d'une classe dérivée de **AbstractView**.

Ceci aura pour effet de renvoyer une réponse HTTP contenant la donnée passée en paramètre du constructeur de **JsonResponse**, sérialisée au format JSON.

#### Exemple

Dans cet exemple, un cherche à renvoyer un enregistrement en base de données au format JSON. Le contrôleur commence par aller chercher l'enregistrement demandé, et s'il n'a rien récupéré, renvoie une réponse contenant un message d'erreur à la place.

```php
class GetByIdController implements ControllerInterface
{
    private ?Todo $todo;

    public function __construct(int $id)
    {
        $this->todo = Todo::findById($id);
    }

    public function invoke(): HttpResponse
    {
        if (is_null($this->todo))  {
            return new JsonResponse([ "message" => "La tâche demandée n'existe pas." ], 404);
        }
        
        return new JsonResponse($this->todo);
    }
}
```
