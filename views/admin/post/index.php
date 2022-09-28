<?php

use App\Connection;
use App\Table\PostTable;
use App\Auth;

Auth::check();

// $router->layout = "admin/layouts/default";
$title = 'Administration';
$pdo = Connection::getPDO();
$link  = $router->url('admin_posts');
[$posts, $pagination] =(new PostTable($pdo))->findPaginated();

?>

<?php if(isset($_GET['delete'])): ?>
<div class="alert alert-success">
    L'enregistrement à bien été supprimé
</div>
<?php endif ?>

<table class="table">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>
            <a href="<?= $router->url('admin_post_new') ?>" class="btn btn-primary">Créer un article</a>
        </th>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
        <tr>
            <td>#<?php echo $post->getID() ?> $</td>
            <td>
                <a href="<?php echo $router->url('admin_post', ['id' => $post->getID()]) ?>">
                <?php echo htmlentities($post->getName()) ?>
                </a>
            </td>
            <td>
                <a href="<?php echo $router->url('admin_post', ['id' => $post->getID()]) ?>" class="btn btn-primary">
                Editer
                </a>
                <form action="<?php echo $router->url('admin_post_delete', ['id' => $post->getID()]) ?>" method="POST"
                    onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display:inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?php echo $pagination->previousLink($link) ?>
    <?php echo $pagination->nextLink($link) ?>
</div>