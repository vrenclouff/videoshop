<?php

class Db
{

    private static $connection;

    private static $settings = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_EMULATE_PREPARES => false,
    );

    public static function connect($host, $user, $pass, $database) {
            if (!isset(self::$connection)) {
                    self::$connection = @new PDO(
                            "mysql:host=$host;dbname=$database",
                            $user,
                            $pass,
                            self::$settings
                    );
            }
    }

    public static function querryOne($querry, $param = array()) {
            $tmp = self::$connection->prepare($querry);
            $tmp->execute($param);
            return $tmp->fetch();
    }

    public static function querryAll($querry, $param = array()) {
            $tmp = self::$connection->prepare($querry);
            $tmp->execute($param);
            return $tmp->fetchAll();
    }


}


?>