<?php

use App\Connection;

require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');
/*
function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }
    */

$pdo = Connection::getPDO();

 // Entrée fausse donnée en suppimant tous les fichier existant
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

for($i = 1; $i <50; $i++) {
    $pdo->exec("INSERT INTO post SET name='Article #$i', slug='article-$i', created_at='2019-05-11 14:00:00', content='lorem ipsum'");
    $posts[] = $pdo->lastInsertId();
}
for($i = 1; $i <5; $i++) {
    // $name = RandomString();
    $pdo->exec("INSERT INTO category SET name='article-$i', slug='slug-$i'");
    $categories[] = $pdo->lastInsertId();
}


foreach($posts as $post) {
    foreach($categories as $category) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET username='admin', password='$password'");  
