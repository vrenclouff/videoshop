<?php

class AdminController extends LoginController
{

    public function make($param){

        $login = @$_POST['admin_login'];

        if(@$param[0] == 'logout'){

            session_destroy();
            $this->set_url('admin');

        }else if(isset($login)){

            $profil = $this->profil_from_db($login);
            $this->login($profil);

        }else if(!isset($_SESSION["user_isadmin"])){

            $this->temp = 'admin_login';
            $this->view();
            exit;

        }

        $this->route($param);
    }

    public function login($profil){

        if($profil['opravneni'] == 'admin'){
            $_SESSION['user_profil'] = $profil;
            $_SESSION["user_isadmin"] = true;
            $_SESSION["user_islogin"] = true;
            $_SESSION["basket"] = array();
       }else{
            $this->temp = 'admin_login';
            $this->view();
            exit;
       }
       $this->route('');
    }

    public function route($param){

        if(@$param[0] == 'movies'){
            if(@$param[1] == 'add'){
                $active = $this->add_movie();
            }else{
                $active = array('selected_movies' => 'active', 'name' => 'Filmy', 'fjmeno' => $_SESSION['user_profil']['fjmeno'], 'ljmeno' => $_SESSION['user_profil']['ljmeno']);
                $this->temp = 'admin_tools_movies';
            }
        }else if(@$param[0] == 'statistics'){
            $active = array('selected_statistics' => 'active', 'name' => 'Statistika', 'fjmeno' => $_SESSION['user_profil']['fjmeno'], 'ljmeno' => $_SESSION['user_profil']['ljmeno']);
            $this->temp = 'admin_tools_statistics';
        }else{
            $active = array('selected_users' => 'active', 'name' => 'Uživatelé', 'fjmeno' => $_SESSION['user_profil']['fjmeno'], 'ljmeno' => $_SESSION['user_profil']['ljmeno']);
            $this->temp = 'admin_tools_users';
        }

        $this->data = $active;
        $this->view();
    }

    public function add_movie(){
        $tmp = array(
            'selected_movies' => 'active',
            'name' => 'Nový film',
            'fjmeno' => $_SESSION['user_profil']['fjmeno'],
            'ljmeno' => $_SESSION['user_profil']['ljmeno']
        );
        $this->temp = 'admin_tools_movies_add';

        return $tmp;
    }

}

?>