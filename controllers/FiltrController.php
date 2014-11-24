<?php

class FiltrController extends AbsController
{

    public function make($param){

        $filtr = @$_POST['filtr'];
        print_r($filtr);

    }

}

?>