<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;


require '../vendor/autoload.php';

$title = 'Mon blog';

$pdo = Connection::getPDO();

$paginatedQuery = new PaginatedQuery(
    "SELECT * FROM post ORDER BY created_at DESC",
    "SELECT COUNT(id) FROM post",  
);
$posts = $paginatedQuery->getItems(Post::class);
$postsByID = [];
foreach($posts as $post) {
    $postsByID[$post->getID()] = $post;
}

$categories = $pdo
    ->query('SELECT c.*, pc.post_id
             FROM post_category pc
             JOIN category c ON c.id = pc.category_id
             WHERE pc.post_id IN (' . implode(',', array_keys($postsByID)) . ')'
    )->fetchAll(PDO::FETCH_CLASS, category::class);

foreach($categories as $category) {
    $postsByID[$category->getPostID()]->addCategory($category);
}
/*
$table = new PostTable($pdo);
[$posts, $pagination] = $table->findPaginated();
*/
$link = $router->url('home');
?>

<H1> mon blog </H1>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require 'card.php'; ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php echo $paginatedQuery->previousLink($link) ?>
    <?php echo $paginatedQuery->nextLink($link) ?>

</div>