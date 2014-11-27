<?php

class RegistrationController extends AbsController
{

    public function make($param){

         $profil = @$_POST['registration'];

//         print_r($profil);

         if (isset($profil)){
             $profil = $this->validParam($profil);
             $id = $this->db->DBInsertExpanded('profil', $profil);
             if($id > 0){
                echo "<script type='text/javascript'>alert('Registrace dokoncena');</script>";
                $this->view();
//                $this->set_url('dokonceno');
//                prihlasit uzivatele a presmerovat na localhost

             }
         }else{
            $this->render();
         }
    }

    private function validParam($profil){

        extract($profil);

        if(empty($pass) && $pass != $pass2){
              $message = "Hesla se neshoduji";
              echo "<script type='text/javascript'>alert('$message');</script>";
              $this->set_url('registration');
//            echo "spatne heslo <br />";
//            $this->set_url('registration');
        }
        if(empty($FName)){
//            echo "Zadejte jmeno <br />";
            $message = "Zadejte jmeno";
            echo "<script type='text/javascript'>alert('$message');</script>";
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
        $error = $this->db->DBSelectOne('profil', 'email', $dat, '');
        echo $error;
        if(!empty($error['email'])){
            echo "zivatel s mailem je je v databazi <br />";
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
            }
        }

        $profil['pass'] = md5($pass);
        unset($profil['pass2']);

        return $this->prepare_for_db($profil);
    }

    private function prepare_for_db($profil){
        extract($profil);
        $item = array(
            array('column' => 'idprofil', 'value_mysql' => "NULL"),
            array('column' => 'fjmeno', 'value_mysql' => "'".$FName."'"),
            array('column' => 'ljmeno', 'value_mysql' => "'".$LName."'"),
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
               'FName' => 'Křestní jméno *',
               'LName' => 'Příjmení *',
               'Email' => 'Email *',
               'Password' => 'Heslo *',
               'PasswordAgain' => 'Heslo znovu *',
               'City' => 'Město *',
               'PSC' => 'PSC *',
               'Street' => 'Ulice *',
               'Tel' => 'Telefon'
        );

        $this->temp = 'registration';
        $this->view();
    }
}