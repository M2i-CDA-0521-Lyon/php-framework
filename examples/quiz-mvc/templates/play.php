<!-- play -->
<div class="container">
    <h1>Quizz</h1>

    <?php if (!is_null($rightlyAnswered)): ?>
    <!-- Affiche une alerte uniquement si l'utilisateur vient de répondre à une question -->
    <div id="answer-result"
        class="alert alert-<?php if ($rightlyAnswered) { echo 'success'; } else { echo 'danger'; } ?>">
        <i class="fas fa-thumbs-<?php if ($rightlyAnswered) { echo 'up'; } else { echo 'down'; } ?>"></i>
        <!-- Affiche un texte différent selon que l'utilisateur a bien répondu à la question ou non -->
        <?php if ($rightlyAnswered): ?>
        Bravo, c'était la bonne réponse!
        <?php else: ?>
        Hé non!
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <h2 class="mt-4">Question n°<span id="question-id"><?= $question->getRank() ?></span></h2>
    <form id="question-form" method="post">
        <p id="current-question-text" class="question-text"><?= $question->getText() ?></p>

        <div id="answers" class="d-flex flex-column">

            <?php foreach ($question->getAnswers() as $answer): ?>
            <div class="custom-control custom-radio mb-2">
                <input class="custom-control-input" type="radio" name="answer" id="answer<?= $answer->getId() ?>"
                    value="<?= $answer->getId() ?>">
                <label class="custom-control-label" for="answer<?= $answer->getId() ?>"
                    id="answer<?= $answer->getId() ?>-caption"><?= $answer->getText() ?></label>
            </div>
            <?php endforeach; ?>

        </div>

        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>