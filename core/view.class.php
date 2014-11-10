<?php

class view
{

    private $dom = null;


    public function view()
    {
        $this->dom = new DOMDocument();
        $htmlInd = file_get_contents('index_.php');
        $this->dom->loadHTML($htmlInd);
    }

    public function viewHomepage($html)
    {
        $divs = $this->dom->getElementById('head');
        $rend = new DOMText($html);
        $divs->appendChild($rend);
    }

}

?>