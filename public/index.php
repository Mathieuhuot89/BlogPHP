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

$frontController = new App\Controller\FrontController();
$frontController->run();


