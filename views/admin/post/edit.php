<?php if($viewVariables['success']): ?>
    <div class="alert alert-success">
        L'article à bien été modifier
    </div>
<?php endif ?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success">
        L'article à bien été créé
    </div>
<?php endif ?>

<?php if (!empty($viewVariables['errors'])): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être mofifié , merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Editer l'article  <?= htmlentities($viewVariables['post']->getName()) ?></h1>

<?php require('_form.php') ?>