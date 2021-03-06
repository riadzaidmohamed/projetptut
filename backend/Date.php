<?php
namespace backend;

use DateInterval;
use DateTime;
use Exception;


/*
* class qui gère les données pour le calendrier
*/
class Date {
    var $days   = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    var $months = array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

    var $attrTournoi = array('Num Tournoi', 'Nom Tournoi', 'Date debut', 'Date fin', 'Lieu');
    var $attrMatch   = array('Num Match', 'Date Match', 'Heure', 'Club Adversaire', 'Lieu', 'Num Tournoi');

    /*
    * recupère tous les articles par date decroissante pour l'année
    */
    public function getArticles($year) {
        global $DB;
        $r = array();
        $req = $DB->query('SELECT * FROM `ARTICLES` WHERE YEAR(Date_A)='.$year.'
                        ORDER BY Date_A DESC, Time_A DESC');
        $i = 0;
        while ($d = $req->fetch(\PDO::FETCH_OBJ)) {
            $r[$i] = '<h3 class="article_title"><a href="article.php?article='.
                $d->Num_A.'" class="article_title">'.$d->Title_A.'</a></h3><p class="article_text">'.$d->Date_A.' '.
            $d->Time_A.'</p>';
            if ($d->Image_A != "")$r[$i] .= '<img class="article_image" src="'.$d->Image_A.'">';
            if ($d->Text_A != "")$r[$i] .= '<p class="article_text">'.$d->Text_A.'</p>';
            ++$i;
        }
        return $r;
    }

    /*
    * recupère tous les tournois par date decroissante pour l'année
    */
    public function getTournoi($year) {
        global $DB;
        $r = array();
        $req = $DB->query('SELECT Num_T, Nom_T, Date_deb, Date_fin, Lieu
                FROM TOURNOI WHERE YEAR(Date_deb) ='.$year.' ORDER BY Date_deb DESC');
        $i = 0;
        while ($d = $req->fetch(\PDO::FETCH_OBJ)) {
            $r[$i] = new Tournoi($d->Num_T, $d->Nom_T, $d->Date_deb, $d->Date_fin,
                                    $d->Lieu);
            ++$i;
        }
        return $r;
    }

    /*
    * recupère tous les match par date et heure decroissante pour l'année
    */
    public function getMatch($year) {
        global $DB;
        $r = array();
        $req = $DB->query('SELECT Num_M, Date_M, Heure,
        Club_Adversaire, M.Lieu, Num_T FROM MATCHS M WHERE YEAR(Date_M) = '.$year.
        ' ORDER BY Date_M DESC, Heure DESC');
        $i = 0;
        while ($d = $req->fetch(\PDO::FETCH_OBJ)) {
            $r[$i] = new Match($d->Num_M, $d->Date_M, $d->Heure, $d->Club_Adversaire,
            $d->Lieu, $d->Num_T);
            ++$i;
        }
        return $r;
    }

    /*
    * recupère tous les évènements l'année
    */
    public function getEvents($year) {
        global $DB;
        $r = array();
        // on recupère tous les tournois
        $req = $DB->query('SELECT Num_T, Nom_T, Date_deb, Date_fin, Lieu
                                    FROM TOURNOI WHERE YEAR(Date_deb) ='.$year);
        while ($d = $req->fetch(\PDO::FETCH_OBJ)) {
            $r[strtotime($d->Date_deb)][$d->Num_T] = 'Debut du '.$d->Nom_T. ' à '.
                $d->Lieu;
            $r[strtotime($d->Date_fin)][$d->Num_T] = 'Fin du '.$d->Nom_T. ' à '.
                $d->Lieu;
        }
        // on recupère tous les matchs
        $reqM = $DB->query('SELECT Num_M, Date_M, Heure,
        Club_Adversaire, M.Lieu FROM MATCHS M, TOURNOI T WHERE M.Num_T = T.Num_T
        AND YEAR(Date_M) = '.$year);
        while($d2 = $reqM->fetch(\PDO::FETCH_OBJ)) {
            $r[strtotime($d2->Date_M)][$d2->Num_M] = 'Match à '.$d2->Heure.
                ' contre '. $d2->Club_Adversaire.' à '.$d2->Lieu;
        }
        return $r;
    }

    /*
    * recupère tous les évènements à venir à aix en provence pour l'année
    */
    public function getHomeEvents($year) {
        global $DB;
        $r = array();
        $m      = \date('m');
        $d      = \date('d');
        $hour   = \date('H');
        $min    = \date('i');
        $sec    = \date('s');

        $dateCurrent = strtotime("$year-$m-$d");
        $timeCurrent = strtotime("$hour:$min:$sec");
        $req = $DB->query('SELECT Num_T, Nom_T, Date_deb, Date_fin, Lieu
                                    FROM TOURNOI WHERE Lieu="Aix-en-Provence" AND Date_deb >= CURDATE()');
        $i = 0;

        // on recupère tous les tournois
        while ($d = $req->fetch(\PDO::FETCH_OBJ)) {
            $r[$i] = '<h4 class="home_events_title"><a class"home_events_title" href="calendar.php">'
                .$d->Nom_T.'</a></h4><p class="home_events_text">'
                .$d->Date_deb.' au '.$d->Date_fin.'</p>';
            ++$i;
            // $r[$i] = '<h4 class="home_events_title">Fin du '.$d->Nom_T.'</h4><p class="home_events_text">'.$d->Date_fin.'</p>';
            // ++$i;
        }
        // on recupère tous les matchs
        // $reqM = $DB->query("SELECT M.Num_M, Date_M, Heure, Club_Adversaire, M.Lieu,
        // Nom_Equipe FROM MATCHS M, Equipe E, Jouer J WHERE M.Num_M = J.Num_M AND
        // J.Num_Equipe = E.Num_Equipe AND M.Lieu='Aix-en-Provence' AND Date_M >= $dateCurrent
        //      ORDER BY Date_M DESC, Heure DESC");
        // while($d2 = $reqM->fetch(\PDO::FETCH_OBJ)) {
        //     if ($d2->Heure < $timeCurrent && $d2->Date_M >= $dateCurrent)continue;
        //     $r[$i] = '<h4 class="home_events_title">'.$d2->Nom_Equipe.' contre '. $d2->Club_Adversaire.'</h4><p class="home_events_text">'.$d2->Date_M.
        //         ' '.$d2->Heure.'</p>';
        //     ++$i;
        // }
        return $r;
    }

    /*
    * creer le calendrier
    */
    public function getAll($year) {
        $r = array();
        try {
            $date = new DateTime($year . '-01-01');
        } catch (Exception $e) {
            echo 'error initialisize DateTime';
        }
        while ($date->format('Y') <= $year) {
            $y = $date->format('Y');
            $m = $date->format('n');
            $d = $date->format('j');
            $w = str_replace('0', '7', $date->format('w'));
            $r[$y][$m][$d] = $w;
            $date->add(new DateInterval('P1D'));
        }
        return $r;
    }
}
