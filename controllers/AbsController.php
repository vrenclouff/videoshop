<?php

abstract class AbsController
{

    protected $data = array();
    protected $temp = "";
    protected $db = "";
    private $twig = "";

    abstract function make($param);

    function __construct(){
         $this->twig = TwigController::getTwig();
         $this->db = Database::getDatabase();
    }

    public function view()
    {
        if($this->temp){
            if(!isset($_SESSION["user_islogin"])){
                $this->temp .= '_nlg';
            }

            $html = $this->twig->loadTemp($this->temp);
            echo $html->render($this->data);
        }else{
             $this->homepage();
        }
    }

    public function set_url($url)
    {
        @header("Location: /$url");
        @header("Connection: close");
        exit;
    }

    public function homepage(){

        $sql_movies = "select f.idfilm, f.nazev, f.rok_vydani, f.cover_link, f.cena, d.jazyk, r.jmeno_reziser, r.prijmeni_reziser, h.jmeno_herci, h.prijmeni_herci from film as f inner join film_has_dabing as fd on fd.film_idfilm = f.idfilm inner join dabing as d on fd.dabing_iddabing = d.iddabing inner join reziser as r on f.reziser_idreziser = r.idreziser inner join film_has_herci as fh on fh.film_idfilm = f.idfilm inner join herci as h on fh.herci_idherci = h.idherci order by f.idfilm";

        $movies = $this->db->ViaSQL($sql_movies);
        $dabings = $this->db->DBSelectAll('dabing', '*', '');
        $actors = $this->db->DBSelectAll('herci', '*', '');
        $years = $this->db->DBSelectAll('film', 'rok_vydani', '', '', array(array('column' => 'rok_vydani', 'sort' => '* 1')));
        $directors = $this->db->DBSelectAll('reziser', '*', '');

        if(!isset($_SESSION["user_islogin"])){
        }else{
            $this->data = array(
                'fname' => $_SESSION['user_profil']['fjmeno'],
                'lname' => $_SESSION['user_profil']['ljmeno']
            );
        }
        $this->temp = 'login';
        $this->view();

        $this->data = array(
            'movies' => $movies,
            'dabings' => $dabings,
            'years' => $years,
            'actors' => $actors,
            'directors' => $directors
        );

        $this->temp = 'content';
        $this->view();

        $this->set_url('');
    }

}
?>