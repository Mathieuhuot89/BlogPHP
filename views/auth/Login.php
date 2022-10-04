<h1>Se connecter</h1>

<?php if(isset($_GET['forbidden'])): ?>
<div class="alert alert-danger">
    Vous ne pouvez pas accéder à la page
</div>
<?php endif ?>

<form action="<?= $router->url('login') ?>" method="POST">
    <?php echo $viewVariables['form']->input('username', 'Nom d\'utilisateur'); ?>
    <?php echo $viewVariables['form']->input('password', 'Mot de passe'); ?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>