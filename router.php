<?php

    echo 'test';

    // trida pro pouziti sablon
    require 'core/twig.class.php';

    $twig = new twig_temp();

    // nacti sablonu
    $head = $twig->loadTemplate('head');
    $singUp = $twig->loadTemplate('singUp');

    // vrati naplnenou sablonu
    $htmlHead = $head->render(array('title' => 'Půjčovna filmů'));
    $htmlSingUp = $singUp->render(array());

    echo $htmlHead;
    // vykresli
    $("#head").append( $htmlHead );
    $("#sing_up").append( $htmlSingUp );


?>