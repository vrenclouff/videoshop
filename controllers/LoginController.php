<?php

class LoginController extends AbsController
{

    public function make($param){

        $login = @$_POST['login'];
        $login = $this->validParam($login);

        $this->check_login($login);
    }

    private function validParam($login){

        if(empty($login['email']) || empty($login['pass'])) $this->set_url('');

        $mail = $login['email'];
        $pass = $login['pass'];
        $pass = md5($pass);

        return array('email' => $mail, 'pass' => $pass);
    }

    private function lgn($info){

        $this->data = array(
                'title' => 'Půjčovna filmů',
                'FName' => $info['fname'],
                'LName' => $info['lname']
        );

        $this->temp = 'loginafter';
        $this->view();
    }

    private function nlgn(){


        $this->data = array('text' => 'neco', 'button' => 'Registrace »');
        $this->temp = 'singup';
        $this->view();
    }

    public function check_login($login){

        $dat = array(
            array(
                'column' => 'email',
                'symbol' => '=',
                'value' => $login['email']
            ),
            array(
                'column' => 'heslo',
                'symbol' => '=',
                'value' => $login['pass']
            )

        );

        $profil = $this->db->DBSelectOne('uzivatele', '*', $dat, '');

    //    print_r($profil);

       if($profil){
            $this->lgn($profil);
       }else{
    //        $this->nlgn();
            $this->homepage();
       }
    }

}

?>