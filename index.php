<?php


    function autoloadFnc($class)
    {
            if (preg_match('/Controller$/', $class)){
//                    echo $class."<br />";
                    require_once("controllers/" . $class . ".php");
            }
            if (file_exists('models/' . $class . '.php')){
//                    echo $class."<br />";
                    require_once("models/" . $class . ".php");
            }
            else{
                    require_once "Twig/lib/Twig/Autoloader.php";
            }
    }

    spl_autoload_register("autoloadFnc");

    session_start();
    $router = new RouterController();
    $router->make(array($_SERVER['REQUEST_URI']));
?>