<form action="" method="POST">
    <?php echo $form->input('name', 'Titre'); ?>
    <?php echo $form->input('slug', 'URL'); ?>
    <?php echo $form->select('categories_ids', 'Categories', $categories); ?>
    <?php echo $form->textarea('content', 'Contenu'); ?>
    <?php echo $form->input('created_at', 'Date de création'); ?>
    <button class="btn btn-primary">
        <?php if($post->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif ?>
    </button>
</form>