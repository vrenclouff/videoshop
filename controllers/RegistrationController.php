<?php

class RegistrationController extends AbsController
{

    public function make($param){

         $profil = @$_POST['registration'];

         if (isset($profil)){
             $profil = $this->validParam($profil);
             $id = $this->db->DBInsertExpanded('uzivatele', $profil);
             if($id > 0){
                echo "<br /> registrace dokoncena <br />";
             }
         }else{
            $this->render();
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
        $dat = array(array('column' => 'email', 'symbol' => '=', 'value' => $email));
        $error = $this->db->DBSelectOne('uzivatele', 'email', $dat, '');
        if(!empty($error['email'])){
            echo "Uzivatel s mailem je je v databazi <br />";
            $this->set_url('registration');
        }
        if(empty($city)){
            echo "Zadejte mesto <br />";
            $this->set_url('registration');
        }
        if(empty($psc) || strlen($psc) != 5 || intval($psc) == 0){
            echo "Zadejte PSC <br />";
            $this->set_url('registration');
        }
        if(empty($street)){
            echo "Zadejte ulici <br />";
            $this->set_url('registration');
        }
        if(!empty($tel)){
            if(intval($tel) == 0 || strlen($tel) != 9){
                echo "Zadejte spravne cislo <br />";
                $this->set_url('registration');
            }
        }

        $profil['pass'] = md5($pass);
        unset($profil['pass2']);

        return $this->prepare_for_db($profil);
    }

    private function prepare_for_db($profil){
        extract($profil);
        $item = array(
            array('column' => 'fname', 'value_mysql' => "'".$FName."'"),
            array('column' => 'lname', 'value_mysql' => "'".$LName."'"),
            array('column' => 'email', 'value_mysql' => "'".$email."'"),
            array('column' => 'heslo', 'value_mysql' => "'".$pass."'"),
            array('column' => 'mesto', 'value_mysql' => "'".$city."'"),
            array('column' => 'psc', 'value_mysql' => "'".$psc."'"),
            array('column' => 'ulice', 'value_mysql' => "'".$street."'"),
            array('column' => 'tel', 'value_mysql' => "'".$tel."'"),
            array('column' => 'opravneni', 'value_mysql' => "'"."user"."'")
        );
        return $item;
    }


    private function render(){

        $this->data = array(
               'title' => 'Půjčovna filmů',
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