<?php


class AjaxController
{


    public function make($param){
        $id = $_POST['id_movie'];

        if(!in_array($id, $_SESSION["basket"])){
            array_push($_SESSION["basket"], $id);
        }
    }
}

?>