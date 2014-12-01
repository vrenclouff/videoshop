<?php

class InvoiceController extends AbsController
{

    public function make($param){

        $this->checkForError();

        $total = $_SESSION["total_price"];
        $movies = $_SESSION["movies"];
        $profil = $_SESSION['user_profil'];
        $date = @date('j. n. Y', strtotime("+4 days"));
        $today = @date('j. n. Y');
        $invoice = rand(1000, 9999);
        $payment = @date('j. n. Y', strtotime("+10 days"));


        $this->data = array(
            'profil' => $profil,
            'date' => $date,
            'basket' => $movies,
            'total' => $total,
            'invoice_nm' => $invoice,
            'today' => $today,
            'payment' => $payment
        );

        $this->temp = 'invoice';
        $this->view();

    }


}


?>