<?php


abstract class Controller
{

    protected $data = array();
    protected $temp = "";

    private $twig = "";

    abstract function make($param);

    function __construct(){
         $this->twig = new TwigController();
    }

    public function view()
    {
        if ($this->temp)
        {
             $html = $this->twig->loadTemp($this->temp);
             echo $html->render($this->data);
        }
    }

    public function check_login(){
        //TODO podle loginu vypis hlavicku

    }

    public function set_url($url)
    {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

}
?>