<?php

class Admin_users
{

    private $db;
    private $temp;
    private $data;

    function __construct($db){
        $this->db = $db;
        $this->temp = 'admin_tools_users';
        $this->setData();
    }

    public function setData(){

        $where_array = '';

        if(isset($_SESSION["admin_filtr"])){
            if($_SESSION["admin_filtr"] != 'all'){
                $where_array = array(
                    array(
                        'column' => 'opravneni',
                        'symbol' => '=',
                        'value_mysql' => "'".$_SESSION["admin_filtr"]."'"
                    )
                );
            }
        }

        $users = $this->db->DBSelectAll('profil', '*', $where_array);

        $this->data = array(
            'selected_users' => 'active',
            'name' => 'Uživatelé',
            'users' => $users,
            'fjmeno' => $_SESSION['user_profil']['fjmeno'],
            'ljmeno' => $_SESSION['user_profil']['ljmeno']
        );
    }

    public function change_authority($id, $auth){

        if($id == $_SESSION['user_profil']['idprofil']) return;

        $update = array(array('column' => 'opravneni', 'value_mysql' => "'".$auth."'"));

        $where_array = array(
            array(
                'column' => 'idprofil',
                'symbol' => '=',
                'value_mysql' => $id
            )
        );

        $this->db->DBUpdate('profil', $update, $where_array);

    }

    public function rm_user($id){

        if($id == $_SESSION['user_profil']['idprofil']) return;

        $dat = array(
            array(
                'column' => 'idprofil',
                'symbol' => '=',
                'value_mysql' => $id
            )
        );

        $this->db->DBDelete('profil', $dat);

     }

    public function getTemp(){
        return $this->temp;
    }
    public function getData(){
        return $this->data;
    }

}

?>