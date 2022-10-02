<form action="" method="POST">
    <?php echo $viewVariables['form']->input('name', 'Titre'); ?>
    <?php echo $viewVariables['form']->input('slug', 'URL'); ?>
    <?php echo $viewVariables['form']->select('categories_ids', 'Categories', $viewVariables['categories']); ?>
    <?php echo $viewVariables['form']->textarea('content', 'Contenu'); ?>
    <?php echo $viewVariables['form']->input('created_at', 'Date de création'); ?>
    <button class="btn btn-primary">
        <?php if($viewVariables['post']->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif ?>
    </button>
</form>