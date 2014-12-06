<?php

class Admin_movies
{

    private $db;
    private $temp;
    private $data;

    function __construct($db){
        $this->db = $db;
        $this->temp = 'admin_tools_movies';
        $this->setData();
    }


    public function setData(){

        $movies = $this->db->DBSelectAll('film', "idfilm, nazev, cover_link", '');

        $this->data = array(
           'selected_movies' => 'active',
           'name' => 'Filmy',
           'data' => $movies,
           'fjmeno' => $_SESSION['user_profil']['fjmeno'],
           'ljmeno' => $_SESSION['user_profil']['ljmeno']
        );

    }

     public function rm_movie($id){

        $dat = array(
            array(
                'column' => 'idfilm',
                'symbol' => '=',
                'value_mysql' => $id
            )
        );

        $this->db->DBDelete('film', $dat);

     }

     public function updateMovies($data_add){

        $file = new File();
        $file_name = $file->getFile();

        $this->toDB($data_add, $file_name);

     }

     private function getDabingID($old, $new){

        if($new != ''){


            $item = array(
                array('column' => 'iddabing', 'value_mysql' => "NULL"),
                array('column' => 'jazyk', 'value_mysql' => "'".strtoupper($new)."'")
            );

            $old = $this->db->DBInsertExpanded('dabing', $item);

        }

        return $old;

     }

     private function getDirectorID($old, $new){

         if($new != ''){

             $iparr = split (" ", $new);
             $item = array(
                 array('column' => 'idreziser', 'value_mysql' => "NULL"),
                 array('column' => 'jmeno_reziser', 'value_mysql' => "'".$iparr[0]."'"),
                 array('column' => 'prijmeni_reziser', 'value_mysql' => "'".$iparr[1]."'")
             );

             $old = $this->db->DBInsertExpanded('reziser', $item);

          }

          return $old;

      }


     private function getActorID($old, $new){

        if($new != ''){

            $iparr = split (" ", $new);
            $item = array(
                array('column' => 'idherci', 'value_mysql' => "NULL"),
                array('column' => 'jmeno_herci', 'value_mysql' => "'".$iparr[0]."'"),
                array('column' => 'prijmeni_herci', 'value_mysql' => "'".$iparr[1]."'")
            );

            $old = $this->db->DBInsertExpanded('herci', $item);

         }

         return $old;

     }

     private function toDB($data, $file){

        extract($data);

        $dabing = $this->getDabingID($dabing, $dabing_plus);
        $actor = $this->getActorID($actor, $actor_plus);
        $director = $this->getDirectorID($director, $director_plus);

        $dat = array(array('column' => 'nazev', 'symbol' => '=', 'value_mysql' => $name));
        $film = $this->db->DBSelectOne('film', 'idfilm', $dat, '')['idfilm'];

        if($film != ''){

            $item = array(
                array('column' => 'film_idfilm', 'value_mysql' => "'".$film."'"),
                array('column' => 'dabing_iddabing', 'value_mysql' => "'".$dabing."'")
            );

            $this->db->DBInsertExpanded('film_has_dabing', $item);


        }else{
            $item = array(
                array('column' => 'idfilm', 'value_mysql' => "NULL"),
                array('column' => 'nazev', 'value_mysql' => "'".$name."'"),
                array('column' => 'rok_vydani', 'value_mysql' => "'".$year."'"),
                array('column' => 'cover_link', 'value_mysql' => "'".$file."'"),
                array('column' => 'cena', 'value_mysql' => "'".$price."'"),
                array('column' => 'reziser_idreziser', 'value_mysql' => "'".$director."'")
            );

            $film = $this->db->DBInsertExpanded('film', $item);

            $item = array(
                array('column' => 'film_idfilm', 'value_mysql' => "'".$film."'"),
                array('column' => 'herci_idherci', 'value_mysql' => "'".$actor."'")
            );

            $this->db->DBInsertExpanded('film_has_herci', $item);

            $item = array(
                array('column' => 'film_idfilm', 'value_mysql' => "'".$film."'"),
                array('column' => 'dabing_iddabing', 'value_mysql' => "'".$dabing."'")
            );

            $this->db->DBInsertExpanded('film_has_dabing', $item);

        }
     }

     public function add_movie(){

        $dabings = $this->db->DBSelectAll('dabing', '*', '');
        $actors = $this->db->DBSelectAll('herci', '*', '');
        $directors = $this->db->DBSelectAll('reziser', '*', '');

        $this->data = array(
            'selected_movies' => 'active',
            'name' => 'Nový film',
            'year' => @date('Y'),
            'fjmeno' => $_SESSION['user_profil']['fjmeno'],
            'ljmeno' => $_SESSION['user_profil']['ljmeno'],
            'dabings' => $dabings,
            'actors' => $actors,
            'directors' => $directors
        );

        $this->temp = 'admin_tools_movies_add';
     }

    public function getTemp(){
        return $this->temp;
    }
    public function getData(){
        return $this->data;
    }

}

?>