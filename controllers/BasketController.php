<?php



class BasketController extends AbsController
{

    public function make($param){


            if(empty($param)){
//                print_r($basket);
                $this->view();

                // get ID movies from session
                // from database get moview
                // render to table
            }

            if($param[0] > 0){
//                echo $param[0]."<br />";
//                array_push($basket, $param[0]);
//                $this->view();
                $this->set_url('');
            }
    }
}

?>