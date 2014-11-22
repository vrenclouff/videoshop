<?php


class TwigController
{

    private static $twigTem;
    private static $instance;

    public static function getTwig(){
        if(!isset(self::$instance)){
            self::$instance = new TwigController();
            self::$instance->conTwig();
        }
        return self::$instance;
    }

    public static function conTwig(){
        if(!isset(self::$twigTem)){
            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem("templates");
            self::$twigTem = new Twig_Environment($loader);
        }
    }

	public function loadTemp($template)
	{
	    return self::$twigTem->loadTemplate($template . ".htm");
	}
}

?>