<?php

class ErrorController extends Controller
{
    public function make($param);
    {
        // Hlavička požadavku
        header("HTTP/1.0 404 Not Found");
        // Hlavička stránky
        $this->set_url['titulek'] = 'Chyba 404';
        // Nastavení šablony
        $this->view = 'chyba';
    }
}

?>