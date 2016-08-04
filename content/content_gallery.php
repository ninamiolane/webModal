<script type="text/javascript">
    $(function() {
        $('#gallery a').lightBox();
    });

    $(document).ready(function(){
        $("form.form").hide();
        $("button.afficheUpload").attr("statut","1")
        .click(function(){
            $("form.form").slideToggle("slow");
            if ($("button.afficheUpload").attr("statut")=="1"){
                $("button.afficheUpload").attr("statut","0");
            }
            else{
                $("button.afficheUpload").attr("statut","1");
            };
        });
    });
</script>

<?php
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
    // getimagesize arrive Ã  traiter le fichier ?
    if(!$getimagesize = getimagesize($_FILES['photo']['tmp_name'])) {
        $erreurs[] = "Le fichier n'est pas une image valide.";
    }
    // on vérifie le type de l'image
    if( (!in_array( get_extension($_FILES['photo']['name']), $extensions_ok ))) {
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

    // copie du fichier si aucune erreur !
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
            date_default_timezone_set('Europe/Paris');
            Photo::insererPhoto($_SESSION['login'], $dest_dossier.$dest_fichier,date("Y-m-d"));
            $valid[] = "$dest_dossier.$dest_fichier {$_SESSION['login']}  Image uploadée avec succès (<a href='".$dest_dossier . $dest_fichier."'>Voir</a>)";
        } else {
            $erreurs[] = "Impossible d'uploader le fichier.<br />Veuillez vÃ©rifier que le dossier ".$dest_dossier." existe avec un chmod 755 (ou 777).";
        }
    }
}
?>

<body>

    <h2 id="example" style="text-align: center;">Vos photos actuelles</h2>
    <p style="text-align: center;">
    <button class="afficheUpload" type="button" style="margin-top:30px;">
        Uploader une nouvelle image
    </button>
    </p>

    <p style="padding-left: 20px;">Cliquez pour agrandir les images.</p>
    
    <?php printGallery($_SESSION['login']); ?>
    <div>
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
                <legend>Sélectionner l'image à charger (moins de 1024ko)</legend>
                <p>
                    <label for="photo" style="width:70px;">Photo : </label>
                    <input type="file" name="photo" id="photo" />
                </p>
                <p>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $taille_max; ?>" />
                    <input type="submit" name="envoi" value="Envoyer l'image" style="width: auto;"/>
                </p>
            </fieldset>
        </form>


    </div>

</body>
