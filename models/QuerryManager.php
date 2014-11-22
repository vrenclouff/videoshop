<?php

class QuerryManager
{

    public function getAllMovie(){

    }

    public function getUser($id){

    }

    public function getUserAll(){
        $querry = "INSERT INTO `mydb`.`profil` (`idprofil`, `fname`, `lname`, `email`, `heslo`, `mesto`, `psc`, `ulice`, `tel`, `opravneni`) VALUES ('3', 'Tomas', 'Dad', 'ahoj@text.cz', 'ahoj', 'Nevim', '33333', 'Asdf', '321434983', 'user');";
        $navrat = self::$connection->prepare($querry);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
    }

    //..

}


?>