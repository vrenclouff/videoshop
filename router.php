<?php

    echo "pred <br />";
    require 'config/functions.inc.php';
    echo "po <br />";

    $accept_pages = array("homepage", "register");

    if (!in_array($page, $accept_pages)) exit;

//    $page = $_GET();
    $page = "";

    if ($page == "") $page = "homepage";

    switch ($page) {
        case "homepage": createHomepage(); break;
        case "register": break;
        //..
    }

//    // dolu je to uz jinde
//
//    // trida pro pouziti sablon
//    require 'core/twig.class.php';
//
//    // instance twigu
//    $twig = new twig();
//
//    // nacti sablonu
//    $head = $twig->loadTemp('head');
//    $singUp = $twig->loadTemp('singUp');
//
//    // vrati naplnenou sablonu
//    $htmlHead = $head->render(array('title' => 'Půjčovna filmů'));
//    $htmlSingUp = $singUp->render(array());
//
//
//
//    $dom = new DOMdocument();
//
////    @$dom->loadHTML($html);
////    echo "dom <br />";
////    $xpath = new DOMXPath($dom);
////    echo "xpath <br />";
////    $body = $xpath->query('//body')->item(0);
////    echo "body <br />";
//
//    $html = file_get_contents('index_.php');
//    $dom = new DOMDocument();
//    $dom->loadHTML($html);
//    $divs = $dom->getElementById('head');
//    $before = new DOMText($htmlHead);
//    $divs->appendChild($before);


?>