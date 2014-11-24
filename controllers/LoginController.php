<?php
class LoginController extends AbsController
{

    public function make($param){

        print_r($param);

        $login = @$_POST['login'];
        $login = $this->validParam($login);

        $this->check_login($login);
    }

    private function validParam($login){

        if(empty($login['email']) || empty($login['pass'])){
//            session_destroy();
            $this->set_url('');
        }

        $mail = $login['email'];
        $pass = $login['pass'];
        $pass = md5($pass);

        return array('email' => $mail, 'pass' => $pass);
    }

    private function setData($info){
        if(isset($info)){
            $this->data = array(
                    'title' => 'Půjčovna filmů',
                    'FName' => $info['fname'],
                    'LName' => $info['lname']
            );
        }else{
            $this->data = array(
                    'title' => 'Půjčovna filmů',
                    'text' => 'neco',
                    'button' => 'Registrace »'
            );
        }

        $this->temp = 'login';
        $this->view();
        $this->set_url('');
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

//       if($profil){
//            $_SESSION['user_profil'] = $profil;
//            $_SESSION["user_islogin"] = true;
//            echo "set session <br />";
//            echo $_SESSION['user_islogin']."<br />";
//       }else{
//            session_destroy();
//       }

       $this->setData($profil);
    }

}

?>