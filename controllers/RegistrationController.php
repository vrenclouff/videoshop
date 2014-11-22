<?php

class RegistrationController extends AbsController
{

    public function make($param){

         $profil = @$_POST['registration'];

         $this->render();

         if (isset($profil)){
             $profil = $this->validParam($profil);
//             print_r($profil);
             $this->db->DBInsertExpanded('profil', $profil);
         }
    }

    private function validParam($profil){

        extract($profil);

        if(empty($pass) && $pass != $pass2){
            echo "spatne heslo <br />";
            $this->set_url('registration');
        }
        if(empty($FName)){
            echo "Zadejte jmeno <br />";
            $this->set_url('registration');
        }
        if(empty($LName)){
            echo "Zadejte prijmeni <br />";
            $this->set_url('registration');
        }
        if(empty($email)){
            echo "Zadejte email <br />";
            $this->set_url('registration');
        }
        if(empty($city)){
            echo "Zadejte mesto <br />";
            $this->set_url('registration');
        }
        if(empty($psc)){
            echo "Zadejte PSC <br />";
            $this->set_url('registration');
        }
        if(empty($street)){
            echo "Zadejte ulici <br />";
            $this->set_url('registration');
        }


        $profil['pass'] = md5($pass);
        unset($profil['pass2']);

        return $this->prepare_for_db($profil);
    }

    private function prepare_for_db($profil){
        extract($profil);
        $item = array(
            array(
                'column' => 'fname',
                'column' => 'lname',
                'column' => 'email',
                'column' => 'heslo',
                'column' => 'mesto',
                'column' => 'psc',
                'column' => 'ulice',
                'column' => 'tel',
                'column' => 'opravneni'
            ),
            array(
                'value' => $FName,
                'value' => $LName,
                'value' => $email,
                'value' => $pass,
                'value' => $city,
                'value' => $psc,
                'value' => $street,
                'value' => $tel,
                'value' => 'user'
            )
        );
        return $item;
    }

    private function render(){

        $this->data = array('title' => 'Půjčovna filmů');
        $this->temp = 'login';
        $this->view();

        $this->data = array(
               'FName' => 'Křestní jméno',
               'LName' => 'Příjmení',
               'Email' => 'Email',
               'Password' => 'Heslo',
               'PasswordAgain' => 'Heslo znovu',
               'City' => 'Město',
               'PSC' => 'PSC',
               'Street' => 'Ulice',
               'Tel' => 'Telefon'
        );

        $this->temp = 'registration';
        $this->view();
    }
}