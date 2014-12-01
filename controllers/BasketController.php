<?php



class BasketController extends AbsController
{

    public function make($param){

            $this->checkForError();

            if(empty($param)){

                $this->render();

            }else if($param[0] == 'rm'){

                $id = $param[1];
                foreach($_SESSION["basket"] as $key => $val){
                    if($val == $id){
                        unset($_SESSION["basket"][$key]);
                    }
                }
                $this->set_url('basket');
                $this->render();


            }else if($param[0] > 0){

                if(!in_array($param[0], $_SESSION["basket"])){
                    array_push($_SESSION["basket"], $param[0]);
                }
                $this->set_url('');

            }else if($param[0] == 'borrow'){

                if($_SESSION["basket"] == null){
                    $this->temp = 'error';
                    $this->view();
                    exit;
                 }

                extract($_SESSION['user_profil']);

                $this->data = array(
                    'fname' => $fjmeno,
                    'lname' => $ljmeno,
                    'tel' => $tel,
                    'city' => $mesto,
                    'psc' => $psc,
                    'street' => $ulice,
                    'Email' => $email
                );
                $this->temp = 'borrow';
                $this->view();
            }else{
                $this->render();
            }
    }

    public function render(){
        $this->prepare_data();
        $this->temp = 'basket';
        $this->view();
    }

    public function prepare_data(){

        $_SESSION["total_price"] = 0;
        $_SESSION["movies"] = array();
        $date = @date('j. n. Y', strtotime("+4 days"));
        $key = 1;

        foreach ($_SESSION["basket"] as $value) {

            $dat = array(
                array(
                    'column' => 'idfilm',
                    'symbol' => '=',
                    'value_mysql' => $value
                ),
            );
            $film = $this->db->DBSelectOne('film', '*', $dat, '');


            $tmp = array(
                'nm' => $key++,
                'id' => $film['idfilm'],
                'name' => $film['nazev'],
                'price' => $film['cena'],
                'cover_link' => $film['cover_link']
            );
            $_SESSION["total_price"] += $film['cena'];
            array_push($_SESSION["movies"], $tmp);
        }

        $this->data = array(
            'fname' => $_SESSION['user_profil']['fjmeno'],
            'lname' => $_SESSION['user_profil']['ljmeno'],
            'date' => $date,
            'total' => $_SESSION["total_price"],
            'basket' => $_SESSION["movies"]
        );

    }
}

?>