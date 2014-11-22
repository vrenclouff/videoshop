<?php


abstract class AbsController
{

    protected $data = array();
    protected $temp = "";
    protected $db = "";
    private $twig = "";

    abstract function make($param);

    function __construct(){
         $this->db = Stat::getConnect();
         $this->twig = Stat::getTwig();
    }

    public function view()
    {
        if ($this->temp)
        {
             $html = $this->twig->loadTemp($this->temp);
             echo $html->render($this->data);
        }
    }

    public function set_url($url)
    {
        @header("Location: /$url");
        @header("Connection: close");
        exit;
    }

    public function homepage(){

        $this->data = array('title' => 'Půjčovna filmů');
        $this->temp = 'login';
        $this->view();

        $this->data = array('text' => 'neco', 'button' => 'Registrace »');
        $this->temp = 'singup';
        $this->view();
    }

}
?>