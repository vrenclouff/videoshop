<?php


class TwigController
{

    private $twigTem = null;

    function __construct(){
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem("templates");
        $this->twigTem = new Twig_Environment($loader);
	}

	public function loadTemp($template)
	{
	    return $this->twigTem->loadTemplate($template . ".htm");
	}
}

?>