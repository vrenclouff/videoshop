<?php

class BorrowController extends AbsController
{

    public function make($param){

        $this->checkForError();

        // pridani do databaze

        extract($_SESSION['user_profil']);

        $this->data = array(
            'fname' => $fjmeno,
            'lname' => $ljmeno
        );

        $this->temp = 'borrow_done';
        $this->view();

    }

}

?>