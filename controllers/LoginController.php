<?php
class LoginController extends AbsController
{

    public function make($param){

        if(@$param[0] == 'logout'){

            session_destroy();
            $this->set_url('');

        }else if(!isset($_SESSION["user_islogin"])){
            $login = @$_POST['login'];

            if($login){
                $profil = $this->profil_from_db($login);
                $this->login($profil);
            }
        }
        $this->set_url('');
    }


    public function login($profil){

        if($profil){
            $_SESSION['user_profil'] = $profil;
            $_SESSION["user_islogin"] = true;
            $_SESSION["basket"] = array();
       }

       $this->view();
       $this->set_url('');

    }

    public function profil_from_db($login){

        $login['pass'] = md5($login['pass']);

//        print_r($login);

        $dat = array(
            array(
                'column' => 'email',
                'symbol' => '=',
                'value_mysql' => $login['email']
            ),
            array(
                'column' => 'heslo',
                'symbol' => '=',
                'value_mysql' => $login['pass']
            )
        );
        $profil = $this->db->DBSelectOne('profil', '*', $dat, '');

        return $profil;
    }

}

?>