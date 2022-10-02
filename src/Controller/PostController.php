<?php 

namespace App\Controller;

use App\Connection;
use App\HTML\Form;
use App\Model\Post;
use App\ObjectHelper;
use App\Table\PostTable;
use App\Validators\PostValidator;
use App\Auth;
use App\Router;
use App\Table\CategoryTable;

class PostController {

    public function __construct(private Router $router)
    {   
        Auth::check();
    }

    public function createAction (): array
    {
        $errors = [];
        $post = new Post();
        $pdo = Connection::getPDO();
        $categoryTable = new CategoryTable($pdo);
        $categories = $categoryTable->list();
        $post->setCreatedAt(date('Y-m-d H:i:s'));

        if(!empty($_POST)) {
            
            $postTable = new PostTable($pdo);
            $v = new PostValidator($_POST, $postTable, array_keys($categories), $post->getID());
            ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
            if ($v->validate()) {
                $pdo->beginTransaction();
                $postTable->createPost($post);
                $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
                $pdo->commit();
                header('Location: ' . $this->router->url('admin_post', ['id' => $post->getID()]) . '?created=1');
                exit();
            } else {
                $errors = $v->errors();
            }
        }
        $form = new Form($post, $errors);
        return [
            'form' => $form,
            'categories' => $categories,
            'post' => $post
        ];
    }

    public function editAction(int $id): array
    {
        $pdo = Connection::getPDO();
        $postTable = new PostTable($pdo);
        $categoryTable = new CategoryTable($pdo);
        $categories = $categoryTable->list();
        $post = $postTable->find($id);
        $categoryTable->hydratePosts([$post]);
        $success = false;

        $errors = [];

        if(!empty($_POST)) {
            $v = new PostValidator($_POST, $postTable, array_keys($categories), $post->getID(),);
            ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
        
            if ($v->validate()) {
                $pdo->beginTransaction();
                $postTable->updatePost($post);
                $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
                $pdo->commit();
                $categoryTable->hydratePosts([$post]);
                $success = true;
            } else {
                $errors = $v->errors();
            }
        }
        $form = new Form($post, $errors);
        return [
            'form' => $form,
            'categories' => $categories,
            'post' => $post,
            'success' => $success,
            'errors' => $errors,
        ];
    }

    public function deleteAction(int $id):void
    {
        $pdo = Connection::getPDO();
        $table = new PostTable($pdo);
        $table->delete($id);
        header('Location: ' . $this->router->url('admin_posts') . '?delete=1');
    }

    public function indexAction (): array
    {
        $pdo = Connection::getPDO();
        $link  = $this->router->url('admin_posts');
        $postTable = new PostTable($pdo);
        $data = $postTable->findPaginated();
        $posts = $data[0];
        $paginatedQuery = $data[1];
        return[
            'posts' => $posts, 
            'pagination' => $paginatedQuery,
            'link' => $link,
        ];
    }

}