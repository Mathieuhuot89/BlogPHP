<?php

use App\Connection;
use App\Model\User;
use App\HTML\Form;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User();
$errors = [];

/* si Name n'existe pas dans post OU Password n'exsiste pas
if (!isset($_POST['name']) || !isset($_POST['password'])) {
    $errors['password'] = ['Identifiant ou mot de passe incorrect'];
} */



if (!empty($_POST)) {
    $user->setUsername($_POST['username']);
    $errors['password'] = 'Identifiant ou mot de passe incorrect';

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $table = new UserTable(Connection::getPDO());
        try {
            $utilisateur = $table->findByUsername($_POST['username']);
            if (password_verify($_POST['password'], $utilisateur->getPassword()) === true) {
                session_start();
                $_SESSION['auth'] = $utilisateur->getID();
                header('Location: ' . $router->url('admin_posts'));
                exit();
            }
        } catch (NotFoundException $e) {
        }
    }
   
} 

$form = new Form($user, $errors);

?>

<h1>Se connecter</h1>

<?php if(isset($_GET['forbidden'])): ?>
<div class="alert alert-danger">
    Vous ne pouvez pas accéder à la page
</div>
<?php endif ?>

<form action="<?= $router->url('login') ?>" method="POST">
    <?php echo $form->input('username', 'Nom d\'utilisateur'); ?>
    <?php echo $form->input('password', 'Mot de passe'); ?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>