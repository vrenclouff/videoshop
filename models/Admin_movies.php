<?php

class Admin_movies
{

    private $db;
    private $temp;
    private $data;

    function __construct($db){
        $this->db = $db;
        $this->temp = 'admin_tools_movies';
        $this->setData();
    }


    public function setData(){

        $movies = $this->db->DBSelectAll('film', "idfilm, nazev, cover_link", '');

        $this->data = array(
           'selected_movies' => 'active',
           'name' => 'Filmy',
           'data' => $movies,
           'fjmeno' => $_SESSION['user_profil']['fjmeno'],
           'ljmeno' => $_SESSION['user_profil']['ljmeno']
        );

    }

     public function rm_movie($id){

        $dat = array(
            array(
                'column' => 'idfilm',
                'symbol' => '=',
                'value_mysql' => $id
            )
        );

        $this->db->DBDelete('film', $dat);

     }

    public function add_movie(){
        $this->data = array(
            'selected_movies' => 'active',
            'name' => 'Nový film',
            'fjmeno' => $_SESSION['user_profil']['fjmeno'],
            'ljmeno' => $_SESSION['user_profil']['ljmeno']
        );

        $this->temp = 'admin_tools_movies_add';
     }

    public function getTemp(){
        return $this->temp;
    }
    public function getData(){
        return $this->data;
    }

}

?>