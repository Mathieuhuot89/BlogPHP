<?php

namespace App\Controller;

use App\Connection;
use App\Table\PostTable;

class PostVisitorController {

    public function indexAction(): array 
    {   
        $pdo = Connection::getPDO();

        $table = new PostTable($pdo);
        [$posts, $pagination] = $table->findPaginated();
        return [
            'posts' => $posts,
            'pagination' => $pagination,
        ];
    }
    


}