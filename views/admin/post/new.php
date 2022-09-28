<?php

use App\Connection;
use App\HTML\Form;
use App\Model\Post;
use App\ObjectHelper;
use App\Table\PostTable;
use App\Validators\PostValidator;
use App\Auth;
use App\Table\CategoryTable;

Auth::check();

$errors = [];
$post = new Post();
$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$post->setCreatedAt(date('Y-m-d H:i:s'));

if(!empty($_POST)) {
    
    $postTable = new PostTable($pdo);
    $v = new PostValidator($_POST, $postTable, array_keys($categories), $post->getID());
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    if ($v->validate()) {
        $pdo->beginTransaction();
        $postTable->createPost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        header('Location: ' . $router->url('admin_post', ['id' => $post->getID()]) . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être enregistré , merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Créer un article</h1>

<?php require('_form.php') ?>
