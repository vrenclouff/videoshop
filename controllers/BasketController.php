<?php



class BasketController extends AbsController
{

    public function make($param){

            $this->checkForError();

            if(empty($param))
            {
                $this->render();

            }else if($param[0] == 'rm')
            {
                $this->remove($param[1]);

            }else if($param[0] == 'borrow')
            {
                $this->borrow();

            }else
            {
                $this->render();
            }
    }

    private function render(){
        $this->prepare_data();
        $this->temp = 'basket';
        $this->view();
    }

    private function remove($id){
        foreach($_SESSION["basket"] as $key => $val){
            if($val == $id){
                unset($_SESSION["basket"][$key]);
            }
        }
        $this->set_url('basket');
        $this->render();
    }

    private function borrow(){
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
    }


    private function prepare_data(){

        $_SESSION["total_price"] = 0;
        $_SESSION["movies"] = array();
        $date = @date('j. n. Y', strtotime("+4 days"));

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