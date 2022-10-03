<?php
$title = 'Gestion des catégories';
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
        <th>URL</th>
        <th>
            <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">Créer un article</a>
        </th>
    </thead>
    <tbody>
        <?php foreach($viewVariables['items'] as $item): ?>
        <tr>
            <td>#<?php echo $item->getID() ?></td>
            <td>
                <a href="<?php echo $router->url('admin_category', ['id' => $item->getID()]) ?>">
                <?php echo htmlentities($item->getName()) ?>
                </a>
            </td>
            <td><?= $item->getSlug() ?></td>
            <td>
                <a href="<?php echo $router->url('admin_category', ['id' => $item->getID()]) ?>" class="btn btn-primary">
                Editer
                </a>
                <form action="<?php echo $router->url('admin_category_delete', ['id' => $item->getID()]) ?>" method="POST"
                    onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display:inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
