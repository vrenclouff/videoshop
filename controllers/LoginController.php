<?php
class LoginController extends AbsController
{

    public function make($param){

        $login = @$_POST['login'];
        $login = $this->validParam($login);

        $this->check_login($login);
    }

    private function validParam($login){

        if(empty($login['email']) || empty($login['pass'])){
            session_destroy();
            $this->set_url('');
        }

        $mail = $login['email'];
        $pass = $login['pass'];
        $pass = md5($pass);

        return array('email' => $mail, 'pass' => $pass);
    }

    public function check_login($login){
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

       if($profil){
            $_SESSION['user_profil'] = $profil;
            $_SESSION["user_islogin"] = true;
            $_SESSION["basket"] = array();
       }else{
            echo "<script type='text/javascript'>alert('Spatne heslo nebo email');</script>";
            session_destroy();
       }

       $this->view();
       $this->set_url('');
    }

}

?>