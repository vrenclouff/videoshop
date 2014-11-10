<?php

	// trida pro pouziti sablon
	echo getcwd();
    require '../core/twig.class.php';
    require '../core/db.class.php';
    require '../core/view.class.php';

    $twig = new twig();
    $db = new db();
    $view = new view();

    $db->connect();
    echo "foo";

	public function createHomepage()
	{
	    $head = $this->twig->loadTemp('head');
	    $htmlHead = $head->render(array('title' => 'Půjčovna filmů'));
        $this->view->viewHomepage($htmlHead);
	}

	function renderSortBy()
	{
	    // data z databaze a poslani sablone
	    // z sablony do view-> render
	}

?>