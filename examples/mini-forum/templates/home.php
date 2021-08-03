<!-- home -->
<div class="container">
    <header>
        <nav>
            <ul>
                <li class="active"><a href="/">Accueil</a></li>
                <li><a href="/sign-in">Créer un compte</a></li>
                <!-- <li><a href="#">Modifier mon compte</a></li> -->
                <li><a href="/login">Se connecter</a></li>
                <!-- <li><a href="#">Se déconnecter</a></li> -->
            </ul>
        </nav>
    </header>

    <main>
        <form method="POST" action="/new-topic">
            <input type="text" name="title" placeholder="Titre">

            <textarea name="message-content" placeholder="Message"></textarea>

            <input type="hidden" name="user-token" value="a557476b7360e49711b465e441f13062">

            <button>Ajouter un nouveau sujet</button>
        </form>

        <ul id="topic-list">
            <?php foreach($topics as $topic) { ?>
                <li>
                    <a href="/topic/<?= $topic->getId() ?>"><?= $topic->getTitle() ?></a>

                    <div class="action-btn-container">
                        <a href="/topic/edit/<?= $topic->getId() ?>" class="button">Modifier</a>
                        <a href="#" class="button delete-btn">Supprimer</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </main>
</div>
