<?php

class Homepage
{

    private $db;

    function __construct($db){
        $this->db = $db;
    }

    public function prepareHomepage(){

        extract($this->dataFromDB());

        $data = array(
            'movies' => $movies,
            'dabings' => $dabings,
            'years' => $years,
            'actors' => $actors,
            'directors' => $directors,
            'dabing_def' => $_SESSION["filtr"]['dabing_filtr'],
            'actor_def' => $_SESSION["filtr"]['actor_filtr'],
            'director_def' => $_SESSION["filtr"]['director_filtr'],
            'year_def' => $_SESSION["filtr"]['year_filtr']
        );

        return $data;

    }

    public function dataFromDB(){
        @extract($_SESSION["filtr"]);

        $dabings = $this->db->DBSelectAll('dabing', '*', '');
        $actors = $this->db->DBSelectAll('herci', '*', '');
        $years = $this->db->DBSelectAll('film', 'DISTINCT rok_vydani', '', '', array(array('column' => 'rok_vydani', 'sort' => '* 1')));
        $directors = $this->db->DBSelectAll('reziser', '*', '');

        $where_array = array();
        if(@$dabing_filtr != 0) array_push($where_array, "d.iddabing = ".$dabing_filtr);
        if(@$actor_filtr != 0) array_push($where_array, "h.idherci = ".$actor_filtr);
        if(@$director_filtr != 0) array_push($where_array, "r.idreziser = ".$director_filtr);
        if(@$year_filtr != 0) array_push($where_array, "f.rok_vydani = ".$year_filtr);


        $where_pom = "";
	 	if ($where_array){
            foreach ($where_array as $item){
                if ($where_pom != "") $where_pom .= " AND ";
                $where_pom .= $item;
            }
        }
        if (trim($where_pom) != "") $where_pom = "where $where_pom";

        $sql_movies = "select f.idfilm, f.nazev, f.rok_vydani, f.cover_link, f.cena, d.jazyk, r.jmeno_reziser, r.prijmeni_reziser, h.jmeno_herci, h.prijmeni_herci from film as f inner join film_has_dabing as fd on fd.film_idfilm = f.idfilm inner join dabing as d on fd.dabing_iddabing = d.iddabing inner join reziser as r on f.reziser_idreziser = r.idreziser inner join film_has_herci as fh on fh.film_idfilm = f.idfilm inner join herci as h on fh.herci_idherci = h.idherci $where_pom order by f.idfilm";
        $movies = $this->db->ViaSQL($sql_movies);


        $data = array(
            'movies' => $movies,
            'dabings' => $dabings,
            'actors' => $actors,
            'years' => $years,
            'directors' => $directors
        );
//
//        foreach($movies as $movie){
//            print_r($movie);
//            echo "<br />";
//        }

        return $data;
    }
}

?>