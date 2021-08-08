<?php

namespace Data;

require_once "../Utils/autoloader.php";

use PDO;
use PDOException;

define('HOST', '127.0.0.1');
define('DBNAME', 'rbm_test');
define('PORT', '3306');
define('CHARSET', 'utf8');
define('USER', 'ads');
define('PASSWORD', 'teste');

class Db {

    private static $pdo;

    private function __construct() {}

    public static function getConn() {
        if (!isset(self::$pdo)) {
            try {
                $dsn = "mysql:host=" . HOST . ";port=".PORT.";dbname=" . DBNAME . "; charset=" . CHARSET . ";";
                self::$pdo = new PDO($dsn, USER, PASSWORD);
            } catch (PDOException $e) {
                echo "Erro : " . $e->getMessage();
            }
        }
        return self::$pdo;
    }
}