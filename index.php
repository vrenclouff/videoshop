<?php


    function autoloadFnc($class)
    {
            if (preg_match('/Controller$/', $class)){
                    require_once("controllers/" . $class . ".php");
            }
            else{
                     require_once "Twig/lib/Twig/Autoloader.php";
            }
    }

    spl_autoload_register("autoloadFnc");

    $router = new RouterController();
    $router->make(array($_SERVER['REQUEST_URI']));

?>