<?php

class LoginController extends Controller
{

    public function make($param){

         $login = @$_POST['login'];

         print_r($login);

         $this->data = array('title' => 'Půjčovna filmů');
         $this->temp = 'login';
         $this->view();

         echo "data <br />";
         $sql = $this->db->DBSelectAll('Persons', '*');
         echo $sql;

         if(!$login){
             $this->data = array('text' => 'neco', 'button' => 'Registrace »');
             $this->temp = 'singup';
             $this->view();
         }
    }


}


?>