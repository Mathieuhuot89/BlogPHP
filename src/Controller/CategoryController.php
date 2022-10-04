<?php

namespace App\Controller;

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Model\Category;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;
use App\Router;
use App\Table\PostTable;

class CategoryController
{

    public function __construct(private Router $router)
    {
        Auth::check();
    }

    public function createAction(): array
    {
        $errors = [];
        $item = new Category();

        if (!empty($_POST)) {
            $pdo = Connection::getPDO();
            $table = new CategoryTable($pdo);
            $v = new CategoryValidator($_POST, $table);
            ObjectHelper::hydrate($item, $_POST, ['name', 'slug']);
            if ($v->validate()) {
                $table->create([
                    'name' => $item->getName(),
                    'slug' => $item->getSlug(),
                ]);
                header('Location: ' . $this->router->url('admin_categories') . '?created=1');
                exit();
            } else {
                $errors = $v->errors();
            }
        }
        $form = new Form($item, $errors);
        return [
            'form' => $form,
            'item' => $item,
        ];
    }

    public function editAction(int $id): array
    {
        $pdo = Connection::getPDO();
        $table = new CategoryTable($pdo);
        $item = $table->find($id);
        $success = false;
        $errors = [];
        $fields = ['name', 'slug'];

        if (!empty($_POST)) {
            $v = new CategoryValidator($_POST, $table, $item->getID());
            ObjectHelper::hydrate($item, $_POST, $fields);
            if ($v->validate()) {
                $table->update([
                    'name' => $item->getName(),
                    'slug' => $item->getSlug(),
                ], $item->getID());
                $success = true;
            } else {
                $errors = $v->errors();
            }
        }
        $form = new Form($item, $errors);
        return [
            'form' => $form,
            'success' => $success,
            'errors' => $errors,
            'item' => $item,
        ];
    }

    public function deleteAction(int $id): void
    {
        $pdo = Connection::getPDO();
        $table = new CategoryTable($pdo);
        $table->delete($id);
        header('Location: ' . $this->router->url('admin_categories') . '?delete=1');
    }

    public function indexAdminAction(): array
    {
        $pdo = Connection::getPDO();
        $items = (new CategoryTable($pdo))->all();
        return [
            'items' => $items,
        ];
    }

    public function indexVisitorAction(int $id, string $slug): array
    {
        $pdo = Connection::getPDO();
        $category = (new CategoryTable($pdo))->find($id);

        if ($category->getSlug() !== $slug) {
            $url = $this->router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
            http_response_code(301);
            header('Location: ' . $url);
        }
        $title = "Catégorie {$category->getName()}";
        [$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getID());
        $link = $this->router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);

        return [
            'title' => $title,
            'posts' => $posts,
            'link' => $link,
            'paginatedQuery' => $paginatedQuery,
        ];
    }   
}
