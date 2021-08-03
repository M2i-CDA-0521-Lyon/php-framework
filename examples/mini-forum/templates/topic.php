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
        <h1><?= $topic->getTitle() ?></h1>

        <h2>Posté le <?= $topic->getDate()->format('d/m/y à H:i') ?></h2>

        <ul id="message-list">
            <?php foreach($topic->getMessages() as $message) { ?>
                <li>
                    <h3>Par <?= $message->getAuthor()->getUsername() ?>, le <?= $message->getDate()->format('d/m/y à H:i') ?></h3>

                    <p><?= $message->getContent() ?></p>
                </li>
            <?php } ?>
        </ul>

        <form action="/new-message/<?= $topic->getId() ?>" method="POST">
                <textarea name="content" placeholder="Message"></textarea>

                <input type="hidden" name="user-token" value="a557476b7360e49711b465e441f13062">

                <button>Répondre au sujet</button>
        </form>
    </main>
</div>
