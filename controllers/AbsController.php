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
//                echo $_SESSION['user_islogin']."<br />";
                $this->temp .= '_nlg';
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

        if(!isset($_SESSION["user_islogin"])){
            $this->data = array(
                'title' => 'Půjčovna filmů',
                'text' => 'Pri pujcovani filmu se musite prihlasit',
                'button' => 'Registrace »'
            );
        }else{
            $this->data = array(
                'title' => 'Půjčovna filmů',
                'FName' => $_SESSION['user_profil']['fjmeno'],
                'LName' => $_SESSION['user_profil']['ljmeno']
            );
        }
        $this->temp = 'login';
        $this->view();

        $movies =  $this->db->DBSelectAll('film', '*', array(), '');
//        print_r($movies);
        $this->data = array(
            'movies' => $movies
        );

        $this->temp = 'content';
        $this->view();

        $this->set_url('');
    }

}
?>