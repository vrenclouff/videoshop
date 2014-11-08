<?php

class twig_temp
{

    private $twigTem = null;

    public function twig_temp()
	{
		require_once '../Twig/lib/Twig/Autoloader.php';
        Twig_Autoloader::register();

        $loader = new Twig_Loader_Filesystem('../templates');
        $twigTem = new Twig_Environment($loader); // takhle je to bez cache
	}

	public function loadTemplate($template)
	{
	    return $this->twigTem->loadTemplate($template+'.htm');
	}

//	echo $template->render(array('obsah' => 'Text do obsahu', 'nadpis1' => 'Nadpis 1'));
}

?>