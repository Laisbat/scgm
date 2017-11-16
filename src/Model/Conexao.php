<?php

namespace src\Model;


class Conexao {
    private static $dbh = null;
    
    public function getConnection(): PDO {
        if (!self::$dbh) {
            self::$dbh = new PDO('mysql:host=localhost;dbname=sgm', 'root', '');
        }
        return self::$dbh;
    }
}
