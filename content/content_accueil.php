<?php

if (isset($_SESSION['erreurCreerCompte'])) {
    echo '<span style="color:red">' . $_SESSION['erreurCreerCompte'] . '</span>';
}

?>

    <h2 style="text-align: center;">Bienvenue sur Meet'X, le magnifique site de rencontres entre X</h2>
    <p>
        Si vous n'êtes pas encore inscrits, veuillez remplir le formulaire ci-dessous :
    </p>

    <form method="post" action="index.php?page=accueil&todo=creerCompte">
        <p> <label for="login">Ton pseudo MeetX </label><input type="text" name="login" value="<?php if (isset($_POST["login"]))
        echo $_POST["login"]; ?>" />
            <br/>
        </p>
        <p>
            <label for="email">Ton adresse email: </label><input type="text" name="email" value="<?php
    if (isset($_POST["email"]))
        echo $_POST["email"]; else
        echo "prenom.nom"; ?>" />@polytechnique.edu
        <br/>
    </p>
    <p><label for="mdp">Ton mot de passe: </label><input type="password" name="mdp"/>
        <br/>
    </p>
    <p><label for="mdpbis">Retape ton mot de passe: </label><input type="password" name="mdpbis"/>
        <br/>
    </p>

            <p> <label for="naissance">Ta date de naissance: </label><input type="text" name="naissance" value="<?php if (isset($_POST["naissance"]))
        echo $_POST["naissance"]; ?>" />
            <br/>
        </p>
        <p>

    <p><label for="sexe">Tu es: </label>
        <input type="radio" name="sexe" value="h" <?php if (isset($_POST["sexe"]) && $_POST["sexe"] == "h")
            echo "checked=\"checked\"" ?>> Un homme
        <input type="radio" name="sexe" value="f" <?php if (isset($_POST["sexe"]) && $_POST["sexe"] == "f")
                echo "checked=\"checked\"" ?>> Une femme <br>
     </p>
     <p><label for="cheveux">Tu es: </label>
         <select name="cheveux">
             <option value="id1"<?php if (isset($_POST["cheveux"]) && $_POST["cheveux"] == "id1")
                    echo "selected=\"yes\"" ?>>blond/blonde</option>
                 <option value="id2" <?php if (isset($_POST["cheveux"]) && $_POST["cheveux"] == "id2")
                        echo "selected=\"yes\"" ?>>brun/brune</option>
                <option value="id3"<?php if (isset($_POST["cheveux"]) && $_POST["cheveux"] == "id3")
                            echo "selected=\"yes\"" ?>>roux/rousse</option>
                    <option value="autre"<?php if (isset($_POST["cheveux"]) && $_POST["cheveux"] == "id4")
                                echo "selected=\"yes\"" ?>>autre</option>
                    </select>
                    <br/></p>
           <p><label for="section">Tu es en section: </label><select name="section">
<?php
                                $tabSections = array('Badminton', 'Basket', 'Equitation', 'Escrime', 'Golf', 'Natation', 'Hand', 'Volley', 'Aviron', 'Rugby', 'Escalade', 'Judo', 'Foot', 'Tennis', 'Raid');
                                $num=0;
                                foreach ($tabSections as $sectionName) {
                                    $num=$num+1;
                                    $s = "";
                                    if (isset($_POST["section"]) && $_POST["section"] == $sectionName)
                                        $s = "selected=\"yes\"";
                                    echo "<option {$s} value=\"id{$num}\">{$sectionName}</option>";
                                }
?>
                            </select>
                            <br/></p>

                        <p><label for="reincarne">Si tu devais te réincarner, tu serais: </label><select name="reincarne">
<?php
                                $tabReincarnes = array('un chat', 'un chien', 'un oiseau', 'un kangourou', 'un serpent', 'un cheval', 'une fleur');
                                $num=0;
                                foreach ($tabReincarnes as $reincarneName) {
                                    $num=$num+1;
                                    $s = "";
                                    if (isset($_POST["reincarne"]) && $_POST["reincarne"] == $reincarneName)
                                        $s = "selected=\"yes\"";
                                    echo "<option {$s} value=\"id{$num}\">{$reincarneName}</option>";
                                }
?>
                            </select>
                        </p>


                        <input type="submit" value="S'inscrire" class="formbutton">
                    </form>

<?php
                            
?>