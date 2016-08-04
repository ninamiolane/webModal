<script type="text/javascript">

    $(document).ready(function(){
        $("form.form").hide();
        $("div.avatarProfil").attr("statut","1")
        .click(function(){
            $("form.form").slideToggle("slow");
            if ($("div.avatarProfil").attr("statut")=="1"){
                $("div.avatarProfil").attr("statut","0");
                $("div.avatarProfil > img").attr("title","Cliquez pour masquer le formulaire");
            }
            else{
                $("div.avatarProfil").attr("statut","1");
                $("div.avatarProfil > img").attr("title","Cliquez pour modifier votre avatar");
            };
        });
    });

    $(document).ready(function(){
        $("form.formMdp").hide();
        $("button.afficheFormMdp").attr("statut","1")
        .click(function(){
            $("form.formMdp").slideToggle("slow");
            if ($("button.afficheFormMdp").attr("statut")=="1"){
                $("button.afficheFormMdp").attr("statut","0");
            }
            else{
                $("button.afficheFormMdp").attr("statut","1");
            };
        });
    });

</script>

<?php

if( isset($_GET['todo'])) {
    $todo = $_GET['todo'];

    if ($todo == mdp) {
        ?>
<h4 style='text-align:center;'> Changement de mot de passe </h4>
<p>
    Entrez l'ancien et le nouveau mot de passe ;
</p>

<form method="post" action="index.php?page=profil&todo=changeMdp">
    <p>
        <label for="ancienMdp">Ancien mot de passe: </label><input type="text" name="ancienMdp" value="" />
        <br/>
    </p>
    <p><label for="mdp">Ton nouveau mot de passe: </label><input type="password" name="mdp"/>
        <br/>
    </p>
    <p><label for="mdpbis">Retape ton nouveau mot de passe: </label><input type="password" name="mdpbis"/>
        <br/>
    </p>
    <input type="submit" value="Modifier" class="formbutton">
</form>
        <?php
    }

    else if($todo == changeMdp) {
        $user = Utilisateur::getUtilisateur($_SESSION['login']);
        $test = Utilisateur::testerMdp($user, $_POST['ancienMdp']);
        $test2 = ($_POST['mdp'] == $_POST['mdpbis']);
        if(!$test) echo "<p style='text-align:center;'>Ancien mot de passe incorrect !</p>";
        if(!$test2) echo "<p style='text-align:center;'>Les deux nouveaux mots de passe ne sont pas identiques !</p>";
        if($test && $test2) {
            Utilisateur::changerMdp($_SESSION['login'], $_POST['mdp']);
        }

    }

    else if ($todo == nom) {
        Data::changerNom($_SESSION['login'], $_POST['nom']);
    }

    else if ($todo == prenom) {
        Data::changerPrenom($_SESSION['login'], $_POST['prenom']);
    }

    else if ($todo == date) {
        Data::changerDate($_SESSION['login'], $_POST['date']);
    }


}

// Extensions images autorisée
$extensions_ok = array('jpg', 'jpeg','gif','png');
$typeimages_ok = array(2);

$taille_ko = 1024; // Taille en kilo octect (ko)
$taille_max = $taille_ko*1024; // En octects
$dest_dossier = './images/'; 
if(isset($_FILES['photo']))
{
    // Les erreurs que PHP renvoi
    if($_FILES['photo']['error'] !== "0") {
        switch ($_FILES['photo']['error']) {
            case 1:
                $erreurs[] = "Votre image doit faire moins de $taille_ko Ko !";
                break;
            case 2:
                $erreurs[] = "Votre image doit faire moins de $taille_ko Ko !";
                break;
            case 3:
                $erreurs[] = "L'image n'a Ã©tÃ© que partiellement tÃ©lÃ©chargÃ©.";
                break;
            case 4:
                $erreurs[] = "Aucun fichier n'a été téléchargé.";
                break;
            case 6:
                $erreur[] = "Un dossier temporaire est manquant.";
                break;
            case 7:
                $erreurs[] = "Echec de l'Ecriture du fichier sur le disque.";
                break;
        }
    }
    if(!$getimagesize = getimagesize($_FILES['photo']['tmp_name'])) {
        $erreurs[] = "Le fichier n'est pas une image valide.";
    }
    // on vérifie le type de l'image
    if( (!in_array( get_extension($_FILES['photo']['name']), $extensions_ok ))
           /* or (!in_array($getimagesize[2], $typeimages_ok ))*/) {
        foreach($extensions_ok as $text) {
            $extensions_string .= $text.', ';
        }
        $erreurs[] = 'Veuillez sélectionner un fichier de type '.substr($extensions_string, 0, -2).' !';
    }
    // on vérifie le poids de l'image
    if( file_exists($_FILES['photo']['tmp_name'])
            and filesize($_FILES['photo']['tmp_name']) > $taille_max) {
        $erreurs[] = "Votre fichier doit faire moins de $taille_ko Ko !";
    }
    // copie du fichier 
    if(!isset($erreurs) or empty($erreurs)) {
        $dest_fichier = basename($_FILES['photo']['name']);
        $dest_fichier = strtr($dest_fichier, 'Ã€ÃÃ‚ÃƒÃ„Ã…Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃÃŽÃÃ’Ã“Ã”Ã•Ã–Ã™ÃšÃ›ÃœÃÃ Ã¡Ã¢Ã£Ã¤Ã¥Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã²Ã³Ã´ÃµÃ¶Ã¹ÃºÃ»Ã¼Ã½Ã¿', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $dest_fichier = preg_replace('/([^.a-z0-9]+)/i', '_', $dest_fichier);

        // pour ne pas ecraser un fichier existant
        while(file_exists($dest_dossier . $dest_fichier)) {
            $dest_fichier = rand().$dest_fichier;
        }

        // copie du fichier
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier . $dest_fichier)) {
            Data::changerAvatar($_SESSION['login'], $dest_dossier.$dest_fichier);
            $valid[] = "$dest_dossier.$dest_fichier {$_SESSION['login']}  Image uploadée avec succès (<a href='".$dest_dossier . $dest_fichier."'>Voir</a>)";
        } else {
            $erreurs[] = "Impossible d'uploader le fichier.<br />Veuillez vÃ©rifier que le dossier ".$dest_dossier." existe avec un chmod 755 (ou 777).";
        }
    }
}
?>



<h2>
    Ton profil
</h2>

<?php
// Variables à utiliser par la suite
$data = Data::getUtilisateur($_SESSION['login']);
$nom = $data->getNom();
$prenom = $data->getPrenom();
$date = $data->getDate();

?>
<div class="profil">
    <div class="avatarProfil">
        <p style="width:35%"><img alt="avatar" src="<?php Data::getAvatar($_SESSION['login']); ?> " title="Cliquez pour modifier votre avatar"></p>
        <p  class="legende">Cliquer pour changer l'avatar</p>
    </div>
    <div style="float: left; width: 450px;">

        <form class ="modif" action="./index.php?page=profil&todo=nom" method="POST">
            <p> <label for="login">Nom : </label><input type="text" name="nom" value="<?php echo $nom ?>" /><input type="submit" value="Modifier">
            </p>
        </form>

        <form class ="modif" action="./index.php?page=profil&todo=prenom" method="POST">
            <p> <label for="login">Prénom : </label><input type="text" name="prenom" value="<?php echo $prenom ?>" /><input type="submit" value="Modifier">
            </p>
        </form>
        <form class ="modif" action="./index.php?page=profil&todo=date" method="POST">
            <p> <label for="login">Date de naissance (AAAA-MM-JJ) : </label><input type="text" name="date" value="<?php echo $date ?>" /><input type="submit" value="Modifier">
            </p>
        </form>
        <button class="afficheFormMdp" type="button" style="margin-top:30px;">
            Modifier le mot de passe
        </button>


    </div>
    <div style="clear: both;">
        
       <br/>
       <br/>
        
    </div>
    <div style="clear: both;">
        <form method="POST" action="" enctype="multipart/form-data" class="form">
            <?php
            if(!empty($erreurs)) {
                echo '<ul class="erreur">';
                foreach($erreurs as $erreur) {
                    echo '<li>'.$erreur.'</li>';
                }
                echo '</ul>';
            }
            if(!empty($valid)) {
                echo '<ul class="validation">';
                foreach($valid as $text) {
                    echo '<li>'.$text.'</li>';
                }
                echo '</ul>';
            }

            ?>
            <fieldset>
                <legend>Nouvel avatar</legend>
                <p>
                    <label for="photo" style="width:70px;">Avatar : </label>
                    <input type="file" name="photo" id="photo" />
                </p>
                <p>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $taille_max; ?>" />
                    <input type="submit" name="envoi" style="width: auto;" value="Envoyer l'image" />
                </p>
            </fieldset>
        </form>


    </div>

    <form method="post" action="index.php?page=profil&todo=changeMdp" class="formMdp">
        <p>
            <label for="ancienMdp">Ancien mot de passe: </label><input type="text" name="ancienMdp" value="" />
            <br/>
        </p>
        <p><label for="mdp">Ton nouveau mot de passe: </label><input type="password" name="mdp"/>
            <br/>
        </p>
        <p><label for="mdpbis">Retape ton nouveau mot de passe: </label><input type="password" name="mdpbis"/>
            <br/>
        </p>
        <input type="submit" value="Modifier" class="formbutton">
    </form>
</div>

