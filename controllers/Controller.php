<?php


abstract class Controller
{

    protected $data = array();
    protected $temp = "";

    protected $db = "";
    private $twig = "";

    abstract function make($param);

    function __construct(){
         $this->twig = new TwigController();
//         $this->db = new DatabaseController();
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