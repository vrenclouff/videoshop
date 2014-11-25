<?php



class BasketController extends AbsController
{

    public function make($param){

//            print_r($param);
            $today = @date("j. n. Y");

            if(empty($param)){
//                print_r($_SESSION["basket"]);
                $this->data = array(
                    'title' => 'Půjčovna filmů',
                    'FName' => $_SESSION['user_profil']['fname'],
                    'LName' => $_SESSION['user_profil']['lname'],
                    'date' => $today
                );
                $this->temp = 'basket';
                $this->view();
                exit;




                // get ID movies from session
                // from database get moview
                // render to table
            }

            if($param[0] > 0){
                if(!in_array($param[0], $_SESSION["basket"])){
                    array_push($_SESSION["basket"], $param[0]);
                }
                $this->set_url('');
            }
    }
}

?>