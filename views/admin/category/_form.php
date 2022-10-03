<form action="" method="POST">
    <?php echo $viewVariables['form']->input('name', 'Titre'); ?>
    <?php echo $viewVariables['form']->input('slug', 'URL'); ?>
    <button class="btn btn-primary">
        <?php if ($viewVariables['item']->getID() !== null) : ?>
            Modifier
        <?php else : ?>
            Créer<?php endif ?>
    </button>
</form>