<?php

class RegistrationController extends Controller
{

    public function make($param){

             $login = @$_POST['registration'];

             $this->data = array('title' => 'Půjčovna filmů');
             $this->temp = 'login';
             $this->view();

             $this->data = array('FName' => 'Křestní jméno', 'LName' => 'Příjmení', 'Email' => 'Email', 'Password' => 'Heslo');
             $this->temp = 'registration';
             $this->view();
             //print_r($login);

             if ($login)
                echo "<br /> registrovani <br /> ";
        }


}


?>