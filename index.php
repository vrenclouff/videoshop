<?php


    function autoloadFnc($class)
    {
            if (preg_match('/Controller$/', $class)){
                    require_once("controllers/" . $class . ".php");
            }
            if (file_exists('models/' . $class . '.php')){
                    require_once("models/" . $class . ".php");
            }
            else{
                    require_once "Twig/lib/Twig/Autoloader.php";
            }
    }

    spl_autoload_register("autoloadFnc");

    $router = new RouterController();
    $router->make(array($_SERVER['REQUEST_URI']));

    Db::connect("127.0.0.1", "root", "root", "pujcovna_filmu");
    echo "Pripojeno k databazi <br />";

?>