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
            if(!isset($_SESSION["user_islogin"])){
                $this->temp .= '_nlg';
            }

            if (!file_exists('templates/' . $this->temp . '.htm')){
                    $this->temp = 'error';
                    $this->view();
                    exit;
            }

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

        $home = new Homepage($this->db);
        $this->data = $home->prepareHomepage();
        $this->temp = 'content';
        $this->view();
        $this->set_url('');
    }

    public function checkForError(){
        if(!isset($_SESSION["user_islogin"])){
            $this->temp = 'error';
            $this->view();
            exit;
        }
    }

}
?>