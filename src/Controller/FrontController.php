<?php

namespace App\Controller;

use App\Router;

class FrontController {
    
    private Router $router;

    public function __construct()
    {
        $this->router = new Router(dirname(dirname(__DIR__)) . '/views');
    }

    public function run()
    {   
        $this->adminCategory();
        $this->adminArticle();
        $this->visitor();
        $this->router->run();
    }
    
    private function adminCategory()
    {
        $this->router->get('/admin/categories', 'admin/category/index', 'admin_categories');
        $this->router->match('/admin/category/[i:id]', 'admin/category/edit', 'admin_category');
        $this->router->post('/admin/category/[i:id]/delete', 'admin/category/delete', 'admin_category_delete');
        $this->router->match('/admin/category/new', 'admin/category/new', 'admin_category_new');
    }

    private function adminArticle()
    {
        $this->router->get('/admin', 'admin/post/index', 'admin_posts');
        $this->router->match('/admin/post/[i:id]', 'admin/post/edit', 'admin_post');
        $this->router->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'admin_post_delete');
        $this->router->match('/admin/post/new', 'admin/post/new', 'admin_post_new');
    }

    private function visitor()
    {   
        $this->router->get('/', '/post/index', 'home');
        $this->router->get('/blog/category/[*:slug]-[i:id]', '/category/show', 'category');
        $this->router->get('/blog/[*:slug]-[i:id]', '/post/show', 'post');
        $this->router->match('/login', 'auth/login', 'login');
        $this->router->post('/logout', 'auth/logout', 'logout');      
    }

}