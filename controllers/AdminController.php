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
            exit;

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
            echo "<script type='text/javascript'>alert('Uzivatel nema admin prava');</script>";
            $this->temp = 'admin_login';
            $this->view();
            exit;
       }
       $this->route('');
    }

    public function route($param){

        $instants = "";

        if(@$param[0] == 'movies'){

            $_SESSION["admin_filtr"] = 'all';
            $instants = new Admin_movies($this->db);

            if(@$param[1] == 'add'){

              $instants->add_movie();

            }else if(@$param[1] == 'rm'){

              $instants->rm_movie($param[2]);
              $this->set_url('admin/movies');

            }else if(isset($_POST['add'])){

                $instants->updateMovies($_POST['add']);
                $this->set_url('admin/movies');
            }

        }else if(@$param[0] == 'statistics'){

            $_SESSION["admin_filtr"] = 'all';
            $instants = new Admin_statistics($this->db);

        }else{

            $instants = new Admin_users($this->db);

            if(@$param[1] == 'ch'){

                $instants->change_authority($param[2], $param[3]);
                $this->set_url('admin/users');

            }else if(@$param[1] == 'rm'){

                $instants->rm_user($param[2]);
                $this->set_url('admin/users');

            }else if(@$param[1] == 'view'){

                if(isset($param[2])){
                    $_SESSION["admin_filtr"] = $param[2];
                    $this->set_url('admin/view');
                }
            }
        }

        $this->data = $instants->getData();
        $this->temp = $instants->getTemp();
        $this->view();

    }

}

?>