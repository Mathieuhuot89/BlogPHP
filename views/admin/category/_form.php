<form action="" method="POST">
    <?php echo $form->input('name', 'Titre'); ?>
    <?php echo $form->input('slug', 'URL'); ?>
    <button class="btn btn-primary">
        <?php if($item->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif ?>
    </button>
</form>