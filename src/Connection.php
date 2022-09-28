<?php

namespace App;

use \PDO;

class Connection {

    public static function getPDO(): PDO 
    {
        return new PDO('mysql:host=localhost;dbname=pro;charset=utf8','root','Cambodge93250', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

}