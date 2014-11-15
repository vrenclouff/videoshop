<?php

class LoginController extends Controller
{

    public function make($param){

         $login = @$_POST['login'];

         print_r($login);

         $this->data = array('title' => 'Půjčovna filmů');
         $this->temp = 'login';
         $this->view();

         if(!$login){
             $this->data = array();
             $this->temp = 'singup';
             $this->view();
         }
    }


}


?>