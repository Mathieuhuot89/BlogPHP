<?php

use App\Connection;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\PostTable;
use App\Validators\PostValidator;
use App\Auth;
use App\Table\CategoryTable;

Auth::check();

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$post = $postTable->find($params['id']);
$categoryTable->hydratePosts([$post]);
$success = false;

$errors = [];

if(!empty($_POST)) {
    $v = new PostValidator($_POST, $postTable, array_keys($categories), $post->getID(),);
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
   
    if ($v->validate()) {
        $pdo->beginTransaction();
        $postTable->updatePost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryTable->hydratePosts([$post]);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
?>

<?php if($success): ?>
    <div class="alert alert-success">
        L'article à bien été modifier
    </div>
<?php endif ?>

<?php if(isset($_GET['created'])): ?>
    <div class="alert alert-success">
        L'article à bien été créé
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être mofifié , merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Editer l'article  <?= htmlentities($post->getName()) ?></h1>

<?php require('_form.php') ?>