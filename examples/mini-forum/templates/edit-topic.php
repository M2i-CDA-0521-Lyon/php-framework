<!-- home -->
<div class="container">
    <header>
        <nav>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/sign-in">Créer un compte</a></li>
                <!-- <li><a href="#">Modifier mon compte</a></li> -->
                <li><a href="/login">Se connecter</a></li>
                <!-- <li><a href="#">Se déconnecter</a></li> -->
            </ul>
        </nav>
    </header>

    <main>
        <h1>Modifier le sujet "<?= $topic->getTitle() ?>" posté par <?= $topic->getAuthor()->getUsername() ?></h1>

        <form action="/topic/edit/<?= $topic->getId() ?>" method="POST">
                <input type="text" name="title" placeholder="Titre" value="<?= $topic->getTitle() ?>">

                <button>Modifier le titre du sujet</button>
        </form>
    </main>
</div>
