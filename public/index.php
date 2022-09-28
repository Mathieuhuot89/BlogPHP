<?php

require '../vendor/autoload.php';

if(isset($_GET['page']) && $_GET['page'] === '1') {
     
     $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
     $get = $_GET;
     unset($get['page']);
     $query = http_build_query($get);
    if (!empty($query)) {
        $uri = $uri . '?' . $query;
    }
    header('Location: ' . $uri);
    http_response_code(301);
    exit();
}

$router = new App\Router(dirname(__DIR__) . '/views');

$router->get('/', '/post/index', 'home');
$router->get('/blog/category/[*:slug]-[i:id]', '/category/show', 'category');
$router->get('/blog/[*:slug]-[i:id]', '/post/show', 'post');
$router->match('/login', 'auth/login', 'login');
$router->post('/logout', 'auth/logout', 'logout');
// Gestion des articles
$router->get('/admin', 'admin/post/index', 'admin_posts');
$router->match('/admin/post/[i:id]', 'admin/post/edit', 'admin_post');
$router->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'admin_post_delete');
$router->match('/admin/post/new', 'admin/post/new', 'admin_post_new');
// Gestion des catégories
$router->get('/admin/categories', 'admin/category/index', 'admin_categories');
$router->match('/admin/category/[i:id]', 'admin/category/edit', 'admin_category');
$router->post('/admin/category/[i:id]/delete', 'admin/category/delete', 'admin_category_delete');
$router->match('/admin/category/new', 'admin/category/new', 'admin_category_new');
$router->run();



