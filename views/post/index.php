<?php

$title = 'Mon blog';

$link = $router->url('home');
?>

<H1> mon blog </H1>

<div class="row">
    <?php foreach($viewVariables['posts'] as $post): ?>
    <div class="col-md-3">
        <?php require 'card.php'; ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php echo $viewVariables['pagination']->previousLink($link) ?>
    <?php echo $viewVariables['pagination']->nextLink($link) ?>

</div>