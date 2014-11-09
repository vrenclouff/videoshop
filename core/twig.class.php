<?php

require_once 'Twig/lib/Twig/Autoloader.php';

class twig
{

    private $twigTem = null;

    public function twig()
	{
        Twig_Autoloader::register();

        $loader = new Twig_Loader_Filesystem('templates');
        $this->twigTem = new Twig_Environment($loader);
	}

	public function loadTemp($template)
	{
	    return $this->twigTem->loadTemplate("$template.htm");
	}
}

?>