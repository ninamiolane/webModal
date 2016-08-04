<?php
$page_list=array(
        array(
                "name"=>"accueil",
                "menutitle"=>"Accueil",
                "title"=>"Meetix, le nouveau site de rencontre pour polytechniciens"),
        array(
                "name"=>"connaissances",
                "menutitle"=>"Connaissances",
                "title"=>"Voici la liste de vos contacts actuels"),
        array(
                "name"=>"nouvelles",
                "menutitle"=>"News",
                "title"=>"Voici quels sont les derniers changements"),
        array(
                "name"=>"gallery",
                "menutitle"=>"Photos",
                "title"=>"Vos photos"),

        array(
                "name"=>"profil",
                "menutitle"=>"Profil",
                "title"=>"Votre profil"),

        array(
                "name"=>"messagerie",
                "menutitle"=>"Messagerie",
                "title"=>"Votre messagerie"),
);

function checkPage($p) {
    global $page_list;
    foreach($page_list as $page) {
        if ($p==$page['name']) return true;
    }
    return false;
}

function getPageTitle($p) {
    global $page_list;
    foreach($page_list as $page) {
        if ($p==$page['name']) return $page["title"];
    }
    return "Erreur";
}

function generateHTMLheader($title,$css) {
    //<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    echo<<<END
<?xml version="1.0" encoding="UTF-8"?>
<link rel="stylesheet" type="text/css" href="$css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>$title</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <script type="text/javascript" src="./js/jquery-1.5.1.min.js"></script>
  <script type="text/javascript" src="js/code.js"></script>
  <script type="text/javascript" src="js/jquery.cycle.all.latest.js"></script>
  <script type="text/javascript" src="js/javascript.js"></script>
  <script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
<script type="text/javascript" src="js/affichagePhoto.js"></script>
 <script type="text/javascript" src="js/monScript.js"></script>
  
</head>
END;
}
function generateHTMLfooter() {

}

function generateMenu($p) {
    global $page_list;
    echo "<div class=\"menu\">";
    echo "<ul>";
    if($_SESSION['loggedIn']) {


        foreach($page_list as $page) {
            if ($p==$page['name']) {
                echo "<li><a href=\"index.php?page={$page["name"]}\" class=\"selectedItem\">{$page["menutitle"]}</a></li>".PHP_EOL;
            }
            else echo "<li><a href=\"index.php?page={$page["name"]}\">{$page["menutitle"]}</a></li>".PHP_EOL;
        }
        echo "</ul>";
    }
    else echo "<li><a href=\"index.php?page=accueil\">Accueil</a></li>".PHP_EOL;
    echo "</div>";
}

function generateContent($p) {
    global $page_list;
    foreach($page_list as $page) {
        if($p == "accueil" && $_SESSION['loggedIn']) {
            require ("/content/content_bonjour.php");
            return;
        }
        if ($p==$page['name'] && $_SESSION['loggedIn']) {
            require("/content/content_$p.php");
            return;
        }
        if ($p==$page['name']) {
            if($p != accueil) echo "<p style=\"text-align:center;\">Pour accéder à cette page vous devez vous connecter !</p>";
            require("/content/content_accueil.php");
            return;
        }
    }
    echo '<p> La page demandée n\'existe pas ou vous n\'avez pas les droits requis pour y acceder. </p>';
}


class Database {
    public static function connect() {
        $dsn = 'mysql:dbname=users;host=127.0.0.1';
        $user = 'root';
        $password = '26021990';
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            exit(0);
        }
        return $dbh;
    }
}



function executeRequest($request) {
    $dbh = Database::connect();
    $query = $request;
    $sth = $dbh->prepare($query);
    $request_succeeded = $sth->execute();
    if(!request_succeded) {
        echo '<p>Problème avec la requête passée en argument</p>';
    }
    else {
        echo '<p> Résultat de la requete : </p><ul>'.PHP_EOL;
        while ($courant =  $sth->fetch(PDO::FETCH_ASSOC)) {
            echo "<li> Nom : {$courant["nom"]} Prénom : {$courant["prenom"]} </li>";
        }
        echo '</ul>';
    }
    $dbh = null;
}

class Message {
    public $destinataire;
    public $expediteur;
    public $date;
    public $objet;
    public $message;
    public $heure;
    public $lu;
    public $id;

    public function __toString() {
        $date=explode("-",$this->date);
        $affichage = "";
        $m = eregi_replace("\n", "<br/>", $this->message);
        if($lu == 0) $affichage = "<div class=\"msg\">
            <h3 class=\"titreMessage\" class=\"nonLu\">".$this->objet." <span style=\"font-size:small ; font-style:italic;\"> (envoyé par ".$this->expediteur." le ".$date[2]."/".$date[1]."/".$date[0]." à ".$this->heure.").
                <button style='float: right; margin-right : 10px;margin-top : 2px;' onclick=\"self.location.href='./index.php?page=messagerie&todo=delete&id=".$this->id."'\" href='www.google.com'>Supprimer</button> </h3>
                <p class=\"message\">".$m."</p>
                         </div>";
        else $affichage = "<div class=\"msg\">
            <h3 class=\"titreMessage\">".$this->objet." <span style=\"font-size:small ; font-style:italic;\"> (envoyé par ".$this->expediteur." le ".$date[2]."/".$date[1]."/".$date[0]." à ".$this->heure.").</h3>
                <p class=\"message\">".$m."</p>
                         </div>";
        return $affichage;
    }

    function deleteMsg($destinataire,$id) {
        $message = getMsgById($id);
        if($message->destinataire != $destinataire) return;
        $dbh = Database::connect();
        $query = "DELETE FROM `msg` WHERE `id`=?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($id));
        $dbh = null;
    }

}

class Utilisateur {
    public $login;
    public $email;
    public $mdp;
    public $sexe;
    public $cheveux;
    public $section;
    public $reincarne;

    public function __toString() {
        $avatar = Data::getAvatar2($this->login);
        $data = Data::getUtilisateur($this->login);
        $sport;
        switch ($this->section){
            case id1: $sport ="Badminton";
                break;
            case id2: $sport ="Basket";
                break;
            case id3:$sport ="Equitation";
                break;
            case id4:$sport ="Escrime";
                break;
            case id5:$sport ="Golf";
                break;
            case id6:$sport ="Natation";
                break;
            case id7:$sport ="Hand";
                break;
            case id8:$sport ="Volley";
                break;
            case id9:$sport ="Aviron";
                break;
            case id10:$sport ="Rugby";
                break;
            case id11:$sport ="Escalade";
                break;
            case id12:$sport ="Judo";
                break;
            case id13:$sport ="Foot";
                break;
            case id14:$sport ="Tennis";
                break;
            case id15:$sport ="Raid";
                break;

        }
        list($annee,$mois,$jour)=explode("-",$data->naissance);
        $user = "<div class='profil' style='clear:left'>
    <div class='avatarProfil'>
        <p><img alt='avatar' src='";
        $user=$user.$avatar."'></p>
    </div>
    <div style='float: left; width: 30%; text-align:left;'>
        <p style='text-align:left;'>
            <strong style='color:black'>Pseudonyme :</strong> ".$this->login."
        </p>
        <p style='text-align:left;'>
           <strong style='color:black'>Nom :</strong> ".$data->nom."
        </p>
        <p style='text-align:left;'>
           <strong style='color:black'>Prénom :</strong> ".$data->prenom."
        </p>
    </div>
    <div style='float: left; width: 30%;'>
        <p style='text-align:left;'><strong style='color:black'>Section : </strong> ".$sport."</p>
        <p style='text-align:left;'><strong style='color:black'>Date de naissance : ".$jour."/".$mois."/".$annee."</strong></p>
    </div>
    </div>";
        return $user;
    }

    public function affichage1() {
        $user = "<div class='profil' style='clear:left'>
    <div class='avatarProfil'>
        <p><img alt='avatar' src='./images/avatardefault.gif'></p>
    </div>
    <div style='float: left; width: 30%; text-align:left;'>
        <p style='text-align:left;'>
            <strong style='color:black'>Pseudonyme :</strong> ".$this->login."
        </p>
        
        <p style='text-align:left;'>
           <strong style='color:black'>Nom : ?</strong>
        </p>
        <p style='text-align:left;'>
           <strong style='color:black'>Prénom : ?</strong>
        </p>
    </div>
    <div style='float: left; width: 30%;'>
        <p style='text-align:left;'><strong style='color:black'>Section : ?</strong> </p>
        <p style='text-align:left;'><strong style='color:black'>Date de naissance : ???</strong></p>
    </div>
    <div style='clear: both; width: 100%;'>
    <p style='text-align-center; font-style:italic;'>
            Cette relation débute.
            Un amour ne demande qu'à naître... N'as-tu pas envie de mieux connaître cette personne? Si tu t'interesses à elle, son profil se révèlera !
        </p>
        </div>
    </div>";
        return $user;
    }

    public function affichage2() {
        $avatar = Data::getAvatar2($this->login);
        $user = "<div class='profil' style='clear:left'>
    <div class='avatarProfil'>
        <p><img alt='avatar' src='";
        $affiche = $user.$avatar."'></p>
    </div>
    <div style='float: left; width: 30%; text-align:left;'>
        <p style='text-align:left;'>
            <strong style='color:black'>Pseudonyme :</strong> ".$this->login."
        </p>
        <p style='text-align:left;'>
           <strong style='color:black'>Nom :</strong> ".$data->nom."
        </p>
        <p style='text-align:left;'>
           <strong style='color:black'>Prénom :</strong> ".$data->prenom."
        </p>
    </div>
    <div style='float: left; width: 30%;'>
        <p style='text-align:left;'><strong style='color:black'>Section : ?</strong> </p>
        <p style='text-align:left;'><strong style='color:black'>Date de naissance : ???</strong></p>
    </div>
    <div style='clear: both; width: 100%;'>
    <p style='text-align-center; font-style:italic;'>
            Ta relation avec <strong style='color:black'>".$this->login."</strong> avance, tu as maintenant accès à son avatar et à son nom !
        </p>
        </div>
        </div>";
        return $affiche;
    }

    public static function getUtilisateur($login) {
        $dbh = Database::connect();
        $query = "SELECT * FROM `utilisateurs` WHERE `login`='$login'";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $sth->execute();
        $user = $sth->fetch(PDO::FETCH_CLASS);
        $sth->closeCursor();
        if ($user!=null)
            return $user;
        else return null;
    }

    //fonction dont on a besoin pour l'algorithme
    public static function getAllUtilisateursSauf($login) {
        $dbh = Database::connect();
        $query = "SELECT * FROM `utilisateurs`WHERE `login`!='$login'";
        $sth = $dbh->prepare($query);
        $sth->execute(array());
        $tabUsers = $sth->fetchAll(PDO::FETCH_CLASS, 'Utilisateur');
        if ($tabUsers != null)
            return $tabUsers;
        else
            return null;
    }

    public static function insererUtilisateur($login,$email,$mdp,$sexe,$cheveux,$section,$reincarne) {

        $dbh = Database::connect();
        if (Utilisateur::getUtilisateur($login)!=null) {
            $_SESSION['erreurCreerCompte'] = 'Le pseudo est deja pris';
            return false;
        }
        elseif ($_POST['mdp']!=$_POST['mdpbis']) {
            $_SESSION['erreurCreerCompte'] = 'Vous n\'avez pas tape deux fois le meme mot de passe';
            return false;
        }
        elseif (!((isset($_POST["login"]) && $_POST["login"] != "" &&
                isset($_POST["email"]) && $_POST["email"] != "" &&
                isset($_POST["mdp"]) && $_POST["mdp"] != ""&&
                isset($_POST["sexe"]) && $_POST["sexe"] != ""))) {
            $_SESSION['erreurCreerCompte']='Tu n\'as pas rempli tous les champs';
        }


        else {
            $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`login`,`email`,`mdp`, `sexe`,`cheveux`,`section`,`reincarne`) VALUES(?,?,SHA1(?),?,?,?,?)");
            $sth->execute(array($login,$email,$mdp,$sexe,$cheveux,$section,$reincarne));
            $dbh = null;
            return true;
        }
    }

    public static function testerMdp($user,$mdp) {
        if($user->mdp==SHA1($mdp)) return true;
        else return false;
    }

    public static function changerMdp($user, $mdp) {
        $dbh = Database::connect();
        $query = "UPDATE `utilisateurs` SET `mdp`=SHA(?) WHERE `login`=?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($mdp, $user));
    }

    public function getAmis() {
        $dbh = Database::connect();
        $query = "SELECT `utilisateurs`.* FROM `utilisateurs` JOIN `connaissances` ON `utilisateurs`.`login`=`connaissances`.`user1`AND `connaissances`.`user2`=? ORDER BY connaissances.user1 ASC";
        $sth = $dbh->prepare($query);
        //echo $query;
        $sth->execute(array($this->login));
        $usertab =  $sth->fetchAll(PDO::FETCH_CLASS,'Utilisateur');
        return $usertab;
    }

    public function getAmis2() {
        $dbh = Database::connect();
        $query = "SELECT `utilisateurs`.* FROM `utilisateurs` JOIN `amis` ON `utilisateurs`.`login`=`amis`.`login2`AND `amis`.`login1`=?";
        $sth = $dbh->prepare($query);
        echo $query;
        $sth->execute(array($this->login));
        $usertab =  $sth->fetchAll(PDO::FETCH_CLASS,'Utilisateur');
        return $usertab;

    }


}

class Data {
    public $login;
    public $nom;
    public $prenom;
    public $naissance;
    public $avatar;

    public function __toString() {
        $date=explode("-",$this->login);
    }

    public static function getUtilisateur($login) {
        $dbh = Database::connect();
        $query = "SELECT * FROM `data` WHERE `login`='$login'";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Data');
        $sth->execute();
        $user = $sth->fetch(PDO::FETCH_CLASS);
        $sth->closeCursor();
        if ($user!=null)
            return $user;
        else return null;
    }

    public static function insererUtilisateur($login) {

        $dbh = Database::connect();
        $sth = $dbh->prepare("INSERT INTO `data` (`login`) VALUES(?)");
        $sth->execute(array($login));
        $dbh = null;
    }

    public static function changerNom($user, $nom) {
        $dbh = Database::connect();
        $query = "UPDATE `data` SET `nom`='$nom' WHERE `login`='$user'";
        $sth = $dbh->prepare($query);
        $sth->execute(array($nom, $user));
        $dbh = null;
    }

    public static function changerPrenom($user, $prenom) {
        $dbh = Database::connect();
        $query = "UPDATE `data` SET `prenom`='$prenom' WHERE `login`='$user'";
        $sth = $dbh->prepare($query);
        $sth->execute(array($prenom, $user));
        $dbh = null;
    }

    public static function changerAvatar($user, $avatar) {
        $dbh = Database::connect();
        $query = "UPDATE `data` SET `avatar`='$avatar' WHERE `login`='$user'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $dbh = null;
    }

    public static function changerDate($user, $date) {
        $dbh = Database::connect();
        $query = "UPDATE `data` SET `naissance`='$date' WHERE `login`='$user'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $dbh = null;
    }

    public static function getAvatar($user) {
        $usr = Data::getUtilisateur($user);
        if($usr->avatar != null) echo "$usr->avatar";
        else echo "./images/avatardefault.gif";
    }

    public static function getAvatar2($user) {
        $usr = Data::getUtilisateur($user);
        if($usr->avatar != null) return "$usr->avatar";
        else return "./images/avatardefault.gif";
    }

    public function getNom() {
        if ($this->nom != null)
            return $this->nom;
        else return "";
    }

    public function getPrenom() {
        if ($this->prenom != null)
            return $this->prenom;
        else return "";
    }

    public function getDate() {
        if ($this->naissance != null)
            return $this->naissance;
        else return "";
    }


}

class Preferences {

    public $login;
    public $genre;
    public $age;
    public $sportif;
    public $cheveux;
    public $caractere;

    public static function getPreferencesUtilisateur($login) {
        $dbh = Database::connect();
        $query = "SELECT * FROM `preferences` WHERE `login`='$login'";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Preferences');
        $sth->execute();
        $user = $sth->fetch(PDO::FETCH_CLASS);
        $sth->closeCursor();
        return $user;
    }

    public static function setPreferences($login, $genre, $age, $sportif, $cheveux, $caractere) {
        $dbh = Database::connect();
        $test = Preferences::getPreferencesUtilisateur($login);
        if ($test == null) {
            $sth = $dbh->prepare("INSERT INTO `preferences` (`login`, `genre`, `age`, `sportif`, `cheveux`, `caractere`) VALUES(?,?,?,?,?,?)");
            $sth->execute(array($login, $genre, $age, $sportif, $cheveux, $caractere));
            $dbh = null;
        } else {
            $sth = $dbh->prepare("UPDATE `preferences` SET  `genre`=?, `age`=?, `sportif`=?, `cheveux`=?, `caractere`=? WHERE `login`=?");
            $sth->execute(array($genre, $age, $sportif, $cheveux, $caractere, $login));
            $dbh = null;
        }
    }

    public function getCheveux() {
        return "$this->cheveux";
    }

    public function getGenre() {
        return $pref->genre;
    }

    public function getAge() {
        return $this->age;
    }

    public function getSportif() {
        return $this->sportif;
    }

    public function getCaractere() {
        return $this->caractere;
    }

}

class Photo {
    public $login;
    public $photo;
    public $date;

    public function __toString() {
        $date=explode("-",$this->login);
        return $this->photo;
    }

    public static function getPhoto($login) {
        $dbh = Database::connect();
        $query = "SELECT * FROM `photo` WHERE `login`=? ORDER BY date DESC";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login));
        $phototab =  $sth->fetchAll(PDO::FETCH_CLASS,'Photo');
        $dbh = null;
        return $phototab;
    }

    public static function insererPhoto($login, $photo, $date) {

        $dbh = Database::connect();
        $sth = $dbh->prepare("INSERT INTO `photo` (`login`,`photo`, `date`) VALUES(?,?,?)");
        $sth->execute(array($login, $photo, $date));
        $dbh = null;
    }

    public function getName() {
        return $this->photo;
    }
}

function printGallery($login) {
    $phototab = Photo::getPhoto($login);
    if($phototab == null) {
        echo "<div class='photos' style='clear:both;'><p style='text-align:center;'> Malheureusement encore aucune photo n'a été chargée ... </p></div>";
        return;
    }
    echo "<div class='photos' style='clear:both;' id='gallery'>
        <p style='text-align:center;'> La gallerie des photos : </p>
        <p style='text-align:center;'>
        <ul>";
    foreach($phototab as $photo) {
        echo "<li>
                <a href=".$photo->getName()." title=''>
                    <img src=".$photo->getName()." width='72' height='72' alt='' />
                </a>
            </li>";
    }
    echo "</ul></p></div>";
}

function sendMsg($destinataire,$expediteur,$date,$objet,$msg, $heure) {

    $dbh = Database::connect();
    $sth = $dbh->prepare("INSERT INTO `msg` (`destinataire`, `expediteur`, `date`, `objet`, `message`, `heure`,`lu`) VALUES(?,?,?,?,?,?,0)");
    $sth->execute(array($destinataire,$expediteur,$date,$objet,$msg,$heure));
    $dbh = null;
}


function getMsg($utilisateur) {
    $dbh = Database::connect();
    $query = "SELECT * FROM `msg` WHERE `destinataire`=? ORDER BY date DESC, heure DESC";
    $sth = $dbh->prepare($query);
    $sth->execute(array($utilisateur));
    $msgtab =  $sth->fetchAll(PDO::FETCH_CLASS,'Message');
    $dbh = null;
    return $msgtab;
}

function getMsgById($id) {
    $dbh = Database::connect();
    $query = "SELECT * FROM `msg` WHERE `id`=?";
    $sth = $dbh->prepare($query);
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Message');
    $sth->execute(array($id));
    $msg = $sth->fetch(PDO::FETCH_CLASS);
    $sth->closeCursor();
    $dbh = null;
    return $msg;
}

function marquerLu($utilisateur, $date, $heure) {
    $dbh = Database::connect();
    $query = "UPDATE `msg` SET `lu`='1' WHERE `destinateur`='$utilisateur'&& `date`='$date' && `heure`='$heure'";
    $sth = $dbh->prepare($query);
    $sth->execute();
    $dbh = null;
}

function get_extension($nom) {
    $nom = explode(".", $nom);
    $nb = count($nom);
    return strtolower($nom[$nb-1]);
}



//fonctions utilisees pour l'algorithme

function insertConnaissance($loginref, $login) {
    $dbh = Database::connect();
    $sth = $dbh->prepare("INSERT INTO `connaissances` (`user1`,`user2`,`indice`) VALUES(?,?,?)");
    $sth->execute(array($loginref, $login, 0));
    $dbh = null;
    return true;
}

function getIndiceConnaissance($loginref, $login) {
    $dbh = Database::connect();
    $userref = Utilisateur::getUtilisateur($loginref);
    $user = Utilisateur::getUtilisateur($login);
    $sth = $dbh->prepare("SELECT * from `connaissances` WHERE `user1`='$login' AND `user2`='$loginref'");
    $sth->execute();
    $indic = $sth->fetch(PDO::FETCH_ASSOC);
    $sth->closeCursor();
    return $indic['indice'];
}

function incrementeIndice($loginref, $login) {
    $dbh = Database::connect();
    $sth = $dbh->prepare("UPDATE `connaissances` SET indice=indice+1 WHERE `user1`='$login' AND `user2`='$loginref'");
    $sth->execute();
    $dbh = null;
}

function incrementeTousIndices($loginref) {
    $userref = Utilisateur::getUtilisateur($loginref);
    $tabAmis = $userref->getAmis();
    foreach ($tabAmis as $ami) {
        incrementeIndice($loginref, $ami->login);
    }
}

function rechercheEtInsere($loginref, $typeRecherche) {
    $userref = Utilisateur::getUtilisateur($loginref);
    $pref = Preferences::getPreferencesUtilisateur($loginref);
    //on charge le tableau de tous les autres utilisateurs
    $tabUsers = Utilisateur::getAllUtilisateursSauf($loginref);

    $tabAmis = $userref->getAmis();
    $tabUsersBis = array_diff($tabUsers, $tabAmis);
    $proche['ok'] = (-1);
    $loin['ok'] = 40;
    $proche['user'] = $userref;
    $loin['user'] = $userref;
    foreach ($tabUsersBis as $user) {

        $ok = 0;
        if ($pref->genre == $user->sexe) {
            $ok = $ok + 1;
        }
        if ($pref->genre == bi) {
            $ok = $ok + 1;
        }
        if (($pref->age == inferieur) && ($userref->naissance < $user->naissance)) {
            $ok = $ok + 1;
        }
        if (($pref->age == superieur) && ($userref->naissance > $user->naissance)) {
            $ok = $ok + 1;
        }
        if ($pref->age == indifferent) {
            $ok = $ok + 1;
        }
        if ($pref->sportif == $user->section) {
            $ok = $ok + 1;
        }
        if ($pref->cheveux == $user->cheveux) {
            $ok = $ok + 1;
        }

        if ($pref->cheveux == indifferent) {
            $ok = $ok + 1;
        }
        if ($pref->caractere == $user->reincarne) {
            $ok = $ok + 1;
        }
        if ($pref->caractere == indifferent) {
            $ok = $ok + 1;
        }
        if ($ok >= $proche['ok']) {
            $proche['ok'] = $ok;
            $proche['user'] = $user;
        }
        if ($ok <= $loin['ok']) {
            $loin['ok'] = $ok;
            $loin['user'] = $user;
        }
    }
    if ($typeRecherche == 0) {
        insertConnaissance($proche['user']->login, $loginref);
        return $proche['user']->login;
    } else {
        insertConnaissance($loin['user']->login, $loginref);
        return $loin['user']->login;
    }
}

?>