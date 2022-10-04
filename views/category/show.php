<h1><?php echo htmlentities($viewVariables['title']) ?> </h1>

<div class="row">
    <?php foreach($viewVariables['posts'] as $post): ?>
    <div class="col-md-3">
        <?php require dirname(__DIR__) . '/post/card.php'; ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php echo $viewVariables['paginatedQuery']->previousLink($viewVariables['link']) ?>
    <?php echo $viewVariables['paginatedQuery']->nextLink($viewVariables['link']) ?>
</div>

