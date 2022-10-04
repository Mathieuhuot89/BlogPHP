<?php

namespace App;

use App\Controller\AuthController;
use App\Controller\CategoryController;
use App\Controller\PostController;
use App\Security\ForbiddenException;
use App\Validators\CategoryValidator;

class Router {

    private $viewPath;

    /**
     * @var AltoRouter
     */
    private $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }  

    public function get(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);

        return $this;
    }

    public function post(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('POST', $url, $view, $name);

        return $this;
    }

    public function match(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('POST|GET', $url, $view, $name);

        return $this;
    }

    public function run(): self
    {   
        $match = $this->router->match();
        $view = $match['target'] ?: 'e404';
        $params = $match['params'];
        $router = $this;
        $isAdmin = strpos($view, 'admin/') !== false;
        $layout = $isAdmin ? 'admin/layouts/default' : 'layouts/default';
        try {
            ob_start();
            if ($match['target'] === "admin/post/new") {
                $postController = new PostController($router);
                $viewVariables = $postController->createAction();
            }
            if ($match['target'] === "admin/post/edit") {
                $postController = new PostController($router);
                $viewVariables = $postController->editAction((int) $params['id']);
            }
            if ($match['target'] === "admin/post/delete") {
                $postController = new PostController($router);
                $postController->deleteAction((int) $params['id']);
            }
            if ($match['target'] === "admin/post/index") {
                $postController = new PostController($router);
                $viewVariables = $postController->indexAction();
            }
            if ($match['target'] === "admin/category/new") {
                $categoryController = new CategoryController($router);
                $viewVariables = $categoryController->createAction();
            }
            if ($match['target'] === "admin/category/edit") {
                $categoryController = new CategoryController($router);
                $viewVariables = $categoryController->editAction((int) $params['id']);
            }
            if ($match['target'] === "admin/category/delete") {
                $categoryController = new CategoryController($router);
                $categoryController->deleteAction((int) $params['id']);
            }
            if ($match['target'] === "admin/category/index") {
                $categoryController = new CategoryController($router);
                $viewVariables = $categoryController->indexAction();
            }
            if ($match['target'] === "auth/logout") {
                $authController = new AuthController($router);
                $viewVariables = $authController->logoutAction();
            }
            require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
            $content = ob_get_clean();
            require $this->viewPath . DIRECTORY_SEPARATOR . $layout . '.php';
        } catch (ForbiddenException $e) {
            header('Location: ' . $this->url('login') . '?forbidden=1');
            exit();
        }
        return $this;

    }
}