<?php

class Admin_statistics
{

    private $db;

    function __construct($db){
        $this->db = $db;
    }

    public function getData(){

        return array('selected_statistics' => 'active', 'name' => 'Statistika', 'fjmeno' => $_SESSION['user_profil']['fjmeno'], 'ljmeno' => $_SESSION['user_profil']['ljmeno']);


    }

    public function getTemp(){
        return 'admin_tools_statistics';
    }

}

?>