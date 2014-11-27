<?php

class ProfilController extends AbsController
{

    public function make($param){

//        print_r($_SESSION['user_profil']);
//        echo "<br /><br />";
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
            'fname' => $fjmeno,
            'lname' => $ljmeno,
            'tel' => $tel,
            'city' => $mesto,
            'psc' => $psc,
            'street' => $ulice
        );

        $this->temp = 'profil';
        $this->view();

    }

}

?>