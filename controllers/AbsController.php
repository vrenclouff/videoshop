<?php

abstract class AbsController
{

    protected $data = array();
    protected $temp = "";
    protected $db = "";
    private $twig = "";

    abstract function make($param);

    function __construct(){
         $this->twig = TwigController::getTwig();
         $this->db = Database::getDatabase();
    }

    public function view()
    {
        if($this->temp){
//            if(!isset($_SESSION["user_islogin"])){
////                echo $_SESSION['user_islogin']."<br />";
                $this->temp .= '_nlg';
//            }
//
//            echo "<br />".$this->temp."<br />";

            $html = $this->twig->loadTemp($this->temp);
            echo $html->render($this->data);
        }else{
             $this->homepage();
        }
    }

    public function set_url($url)
    {
        @header("Location: /$url");
        @header("Connection: close");
        exit;
    }

    public function homepage(){

        $this->data = array(
               'title' => 'Půjčovna filmů',
               'text' => 'Pro pujcovani filmu je potreba byt prihlaseny',
               'button' => 'Registrace »'
        );
        $this->temp = 'login';
        $this->view();

        $this->temp = 'content';
        $this->view();

        $this->set_url('');
    }

}
?>