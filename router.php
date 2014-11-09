<?php

    // trida pro pouziti sablon
    require 'core/twig.class.php';

    // instance twigu
    $twig = new twig();

    // nacti sablonu
    $head = $twig->loadTemp('head');
    $singUp = $twig->loadTemp('singUp');

    // vrati naplnenou sablonu
    $htmlHead = $head->render(array('title' => 'Půjčovna filmů'));
    $htmlSingUp = $singUp->render(array());

    echo $htmlHead;
    echo $htmlSingUp;
//    $("#head").append( $htmlHead );
//    $("#sing_up").append( $htmlSingUp );

?>