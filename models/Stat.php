<?php

class Stat
{

    private static $db;
    private static $twig;

    public static function ConnectDB(){
        Stat::$db = new Database();
        Stat::$db->Connect();
    }

    public static function LoadTwig(){
        Stat::$twig = new TwigController();
    }

    public static function getConnect(){
        return Stat::$db;
    }

    public static function getTwig(){
        return Stat::$twig;
    }
}

?>