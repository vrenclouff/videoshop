<?php

class ProfilController extends AbsController
{

    public function make($param){

        extract($_SESSION['user_profil']);

        $this->data = array(
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