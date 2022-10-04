<?php

$categories = [];
foreach($post->getCategories() as $category) {
    $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    $categories[] = <<<HTML
    <a href="{$url}">{$category->getName()}</a>
HTML;
}
?>


<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <p class="text-muted">
            <?= $post->getCreatedAt()->format('d F Y') ?> ::
            <?php if(!empty($post->getCategories())): ?>
            ::
            <?= implode(', ',  $categories) ?>
            <?php endif ?>
        </p>
        <p><?= $post->getExcerpt()  ?></p>
         <p>
            <a href="<?php echo $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary">Voir plus</a>
        </p>
    </div>
</div>