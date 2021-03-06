<?php

class RegistrationController extends AbsController
{

    public function make($param){

         $profil = @$_POST['registration'];

         if (isset($profil)){
             $profil = $this->validParam($profil);
             $id = $this->db->DBInsertExpanded('profil', $profil);
             if($id > 0){
                echo "<script type='text/javascript'>alert('Registrace dokoncena');</script>";
                $this->view();
             }
         }else{
            $this->temp = 'registration';
            $this->view();
         }
    }

    private function render_back($profil){

        $this->data = $profil;
        $this->temp = 'registration';
        $this->view();
        exit;
    }

    private function validParam($profil){

        extract($profil);

        if($pass != '' && $pass2 != ''){
            if($pass != $pass2){
                echo "<script type='text/javascript'>alert('Hesla se neshodují');</script>";
                $this->render_back($profil);
            }

        }

        $dat = array(array('column' => 'email', 'symbol' => '=', 'value_mysql' => $email));
        $error = $this->db->DBSelectOne('profil', 'email', $dat, '');
//        echo $error;
        if($error != ''){
            echo "<script type='text/javascript'>alert('Uzivatel jiz existuje');</script>";
            $this->render_back($profil);
        }

        if(empty($psc) || strlen($psc) != 5 || intval($psc) == 0){
            echo "<script type='text/javascript'>alert('Zadejte správné PSČ Správný tvar - např: 10093');</script>";
            $this->render_back($profil);
        }
        if(!empty($tel)){
             if(intval($tel) == 0 || strlen($tel) != 9){
//            if(!preg_match('/^[0-9]{3}[0-9]{3}[0-9]{4}$/', $tel)){
                echo "<script type='text/javascript'>alert('Žádejte správné telefonní číslo Správný tvar - např: 777011349');</script>";
                $this->render_back($profil);
            }
        }

        $profil['pass'] = md5($pass);
        unset($profil['pass2']);

        return $this->prepare_for_db($profil);
    }

    private function prepare_for_db($profil){
        extract($profil);
        if($tel){ $tel = "'".$tel."'"; } else { $tel = "NULL"; }
        $item = array(
            array('column' => 'idprofil', 'value_mysql' => "NULL"),
            array('column' => 'fjmeno', 'value_mysql' => "'".$FName."'"),
            array('column' => 'ljmeno', 'value_mysql' => "'".$LName."'"),
            array('column' => 'email', 'value_mysql' => "'".$email."'"),
            array('column' => 'heslo', 'value_mysql' => "'".$pass."'"),
            array('column' => 'mesto', 'value_mysql' => "'".$city."'"),
            array('column' => 'psc', 'value_mysql' => "'".$psc."'"),
            array('column' => 'ulice', 'value_mysql' => "'".$street."'"),
            array('column' => 'tel', 'value_mysql' => $tel),
            array('column' => 'opravneni', 'value_mysql' => "'"."user"."'")
        );
        return $item;
    }
}