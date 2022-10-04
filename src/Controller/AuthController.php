<?php

namespace App\Controller;

use App\Connection;
use App\HTML\Form;
use App\Model\User;
use App\Router;
use App\Table\Exception\NotFoundException;
use App\Table\USerTable;

class AuthController
{

    public function __construct(private Router $router)
    {
    }

    public function logoutAction(): void
    {
        session_start();
        session_destroy();
        header('Location: ' . $this->router->url('login'));
        exit();
    }

    public function loginAction(): array
    {
        $user = new User();
        $errors = [];

        if (!empty($_POST)) {
            $user->setUsername($_POST['username']);
            $errors['password'] = 'Identifiant ou mot de passe incorrect';

            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                $table = new USerTable(Connection::getPDO());
                try {
                    $utilisateur = $table->findByUsername($_POST['username']);
                    if (password_verify($_POST['password'], $utilisateur->getPassword()) === true) {
                        session_start();
                        $_SESSION['auth'] = $utilisateur->getID();
                        header('Location: ' . $this->router->url('admin_posts'));
                        exit();
                    }
                } catch (NotFoundException $e) {
                }
            }
        }
        $form = new Form($user, $errors);
        return [
            'form' => $form,
        ];
        /* si Name n'existe pas dans post OU Password n'exsiste pas
if (!isset($_POST['name']) || !isset($_POST['password'])) {
    $errors['password'] = ['Identifiant ou mot de passe incorrect'];
} */
    }
}
