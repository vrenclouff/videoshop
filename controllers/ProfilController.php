<?php

class ProfilController extends AbsController
{

    public function make($param){

        $this->checkForError();

        $update = @$_POST['update'];

        if(isset($update)){
            $update = $this->validUpdate($update);

            $where_array = array(
                array(
                    'column' => 'idprofil',
                    'symbol' => '=',
                    'value_mysql' => $_SESSION['user_profil']['idprofil']
                )
            );

            $this->db->DBUpdate('profil', $update, $where_array);
            $profil = $this->db->DBSelectOne('profil', '*', $where_array, '');
            if($profil) $_SESSION['user_profil'] = $profil;
             echo "<script type='text/javascript'>alert('Profil byl zmenen.');</script>";
        }

        $this->render();

    }

    private function render(){

        extract($_SESSION['user_profil']);

        $this->data = array(
            'fname' => $fjmeno,
            'lname' => $ljmeno,
            'tel' => $tel,
            'city' => $mesto,
            'psc' => $psc,
            'street' => $ulice
        );

        $this->temp = 'profil';
        $this->view();
        exit;

    }

    private function validUpdate($profil){

        extract($profil);

        if(empty($FName)){
            echo "<script type='text/javascript'>alert('Zadejte jmeno');</script>";
            $this->render();
        }
        if(empty($LName)){
            echo "<script type='text/javascript'>alert('Zadejte prijmeni');</script>";
            $this->render();
        }
        if(empty($city)){
            echo "<script type='text/javascript'>alert('Zadejte mesto');</script>";
            $this->render();
        }
        if(empty($psc) || strlen($psc) != 5 || intval($psc) == 0){
            echo "<script type='text/javascript'>alert('Zadejte PSC');</script>";
            $this->render();
        }
        if(empty($street)){
            echo "<script type='text/javascript'>alert('Zadejte ulici');</script>";
            $this->render();
        }
        if(!empty($tel)){
            if(intval($tel) == 0 || strlen($tel) != 9){
                echo "<script type='text/javascript'>alert('Zadejte spravne cislo');</script>";
                $this->render();
            }
        }

        if(isset($passNew)){
            if($passOld == $passOld2){
                $profil['pass'] = md5($passNew);
            }else{
                echo "<script type='text/javascript'>alert('Hesla se neshoduji');</script>";
                $this->render();
            }
        }

        return $this->prepare_for_db($profil);
    }

    private function prepare_for_db($profil){
        extract($profil);
        if($tel){ $tel = "'".$tel."'"; } else { $tel = "NULL"; }
        $item = array(
            array('column' => 'fjmeno', 'value_mysql' => "'".$FName."'"),
            array('column' => 'ljmeno', 'value_mysql' => "'".$LName."'"),
            array('column' => 'heslo', 'value_mysql' => "'".$pass."'"),
            array('column' => 'mesto', 'value_mysql' => "'".$city."'"),
            array('column' => 'psc', 'value_mysql' => "'".$psc."'"),
            array('column' => 'ulice', 'value_mysql' => "'".$street."'"),
            array('column' => 'tel', 'value_mysql' => $tel),
        );
        return $item;
    }

}

?>