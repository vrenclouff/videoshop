<?php



class BasketController extends AbsController
{

    public function make($param){

//            print_r($param);

            if(empty($param)){
//                print_r($_SESSION["basket"]);
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
                extract($_SESSION['user_profil']);

                $this->data = array(
                    'title' => 'Půjčovna filmů',
                    'PasswordOld' => 'Stare heslo',
                    'PasswordOldAgain' => 'Stare heslo znovu',
                    'PasswordNew' => 'Nove heslo',
                    'Tel_name' => 'Telefon',
                    'City_name' => 'Město',
                    'PSC_name' => 'PSC',
                    'Street_name' => 'Ulice',
                    'fname' => $fname,
                    'lname' => $lname,
                    'tel' => $tel,
                    'city' => $mesto,
                    'psc' => $psc,
                    'street' => $ulice,
                    'Email' => $email
                );

                $this->temp = 'borrow';
                $this->view();
            }
    }

    public function render(){
        $this->prepare_data();
        $this->temp = 'basket';
        $this->view();
    }

    public function prepare_data(){

        $today = @date("j. n. Y");
        $bin = array();
        $total = 0;
        $key = 1;

        $price = 99;

        foreach ($_SESSION["basket"] as $value) {

            $dat = array(
                array(
                    'column' => 'idfilm',
                    'symbol' => '=',
                    'value' => $value
                ),
            );
            $profil = $this->db->DBSelectOne('film', '*', $dat, '');


            $tmp = array(
                'nm' => $key++,
                'id' => $profil['idfilm'],
                'name' => $profil['nazev'],
                'price' => $profil['cena'],
                'cover_link' => $profil['cover_link']
            );
            $total += $profil['cena'];
            array_push($bin, $tmp);
        }

        $this->data = array(
            'title' => 'Půjčovna filmů',
            'FName' => $_SESSION['user_profil']['fjmeno'],
            'LName' => $_SESSION['user_profil']['ljmeno'],
            'date' => $today,
            'total' => $total,
            'basket' => $bin
        );

    }
}

?>