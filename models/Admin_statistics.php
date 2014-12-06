<?php

class Admin_statistics
{

    private $db;
    private $data;
    private $temp;

    function __construct($db){
        $this->db = $db;
        $this->setData();
        $this->temp = 'admin_tools_statistics';
    }

    public function setData(){

        $sql = "select count(film_idfilm) as count, f.nazev from profil_has_film INNER JOIN film f on film_idfilm = f.idfilm where film_idfilm IS NOT NULL group by film_idfilm";
        $count = $this->db->ViaSQL($sql);

        $this->data = array(
            'selected_statistics' => 'active',
            'name' => 'Statistika',
            'count' => $count,
            'fjmeno' => $_SESSION['user_profil']['fjmeno'],
            'ljmeno' => $_SESSION['user_profil']['ljmeno']
        );

    }

    public function getData(){

        return $this->data;

    }

    public function getTemp(){
        return $this->temp;
    }

}

?>