<?php

class BorrowController extends AbsController
{

    public function make($param){

        $this->checkForError();

        $this->toDB();

        $this->render();

    }

    private function render(){

        $this->data = array(
            'fname' => $_SESSION['user_profil']['fjmeno'],
            'lname' => $_SESSION['user_profil']['ljmeno']
        );

        $this->temp = 'borrow_done';
        $this->view();
    }

    private function toDB(){

        $id_user = $_SESSION['user_profil']['idprofil'];
        @$today = date("Y-j-n");

        foreach ($_SESSION["basket"] as $id_movie) {

            $item = array(
                    array('column' => 'profil_idprofil', 'value_mysql' => "'".$id_user."'"),
                    array('column' => 'film_idfilm', 'value_mysql' => "'".$id_movie."'"),
                    array('column' => 'datum_vypujceni', 'value_mysql' => "'".$today."'")
                );

            $this->db->DBInsertExpanded('profil_has_film', $item);
        }

        $_SESSION["basket"] = array();

    }

}

?>