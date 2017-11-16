<?php

namespace src\Model;

/**
 * Description of Db
 *
 * @author Lais
 */
class Db {
    public static $db;
   
    public static function init($db)
    {
        self::$db = $db;
    }
}
