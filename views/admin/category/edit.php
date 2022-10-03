<?php if($viewVariables['success']): ?>
    <div class="alert alert-success">
        La catégorie à bien été modifier
    </div>
<?php endif ?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success">
        La catégorie à bien été créé
    </div>
<?php endif ?>

<?php if (!empty($viewVariables['errors'])): ?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu être mofifié , merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Editer la catégorie <?= htmlentities($viewVariables['item']->getName()) ?></h1>

<?php require('_form.php') ?>