<?php

$pref = Preferences::getPreferencesUtilisateur($_SESSION['login']);
$test = $pref==NULL ? false : true;

?>

<h2 style="text-transform:capitalize">Bonjour <?php echo $_SESSION['login']?>!</h2>

<p>Faites nous part de ce qui, pour vous, caractérise le partenaire idéal ! Ainsi nous nous ferons un plaisir de trouver la personne vous correspondant le mieux !</p>

<form method="post" action="index.php?page=connaissances&todo=preferences" style="margin-right: 10%;margin-left: 10%;">
    <fieldset>
        <legend>Vos préférences</legend>
        <br/>
        <p> <label for="genre">Je recherche actuellement : </label>
            <select name="genre">
                <option value="h"<?php if (isset($_POST["genre"]) && $_POST["genre"] == "h") echo "selected=\"yes\"";
                if($test && $pref->getGenre()=='h')  echo "selected=\"yes\"";?>>un compagnon</option>
                <option value="f" <?php if (isset($_POST["genre"]) && $_POST["genre"] == "f")
                            echo "selected=\"yes\""; if($test && $pref->getGenre()=='f')  echo "selected=\"yes\"";?>>une copine</option>
                <option value="bi"<?php if (isset($_POST["genre"]) && $_POST["genre"] == "bi")
                            echo "selected=\"yes\""; if($test && $pref->getGenre()=='bi')  echo "selected=\"yes\"";?>>n'importe qui</option>
            </select>
        </p>
         <p> <label for="typeRecherche">Tu penses que : </label>
            <select name="typeRecherche">
                <option value="0"<?php if (isset($_POST["typeRecherche"]) && $_POST["typeRecherche"] == "0") echo "selected=\"yes\"";
                ?>>qui se ressemble s'assemble</option>
                <option value="1" <?php if (isset($_POST["typeRecherche"]) && $_POST["typeRecherche"] == "1")
                            echo "selected=\"yes\""; ?>>les contraires s'attirent</option>
            </select>
        </p>

        <p> <label for="age">Pour vous une banane se consomme : </label>
            <select name="age">
                <option value="inferieur"<?php if (isset($_POST["age"]) && $_POST["age"] == "inferieur")
                            echo "selected=\"yes\""; if($test && $pref->getAge()=='inferieur')  echo "selected=\"yes\""; ?>>Encore verte</option>
                <option value="identique" <?php if (isset($_POST["age"]) && $_POST["age"] == "identique")
                            echo "selected=\"yes\""; if($test && $pref->getAge()=='identique')  echo "selected=\"yes\""; ?>>Lorsqu'elle est d'un beau jaune vif</option>
                <option value="superieur"<?php if (isset($_POST["age"]) && $_POST["age"] == "superieur")
                            echo "selected=\"yes\""; if($test && $pref->getAge()=='superieur')  echo "selected=\"yes\""; ?>>Mûre lorsque de petites tâches marron apparaissent</option>
                <option value="indifferent"<?php if (isset($_POST["age"]) && $_POST["age"] == "indifferent")
                            echo "selected=\"yes\""; if($test && $pref->getAge()=='indifferent')  echo "selected=\"yes\""; ?>>sans la peau, c'est l'essentiel, le reste est secondaire</option>
            </select>
        </p>
<?php
/*
        <p> <label for="vacances">De bonnes vacances se passent : </label>
            <select name="vacances">
                <option value="plage"<?php if (isset($_POST["vacances"]) && $_POST["vacances"] == "plage")
                            echo "selected=\"yes\""; if($test && $pref->getVacances()=='plage')  echo "selected=\"yes\""; ?>>Au bord de la mer</option>
                <option value="montagne" <?php if (isset($_POST["vacances"]) && $_POST["vacances"] == "montagne")
                            echo "selected=\"yes\""; if($test && $pref->getVacances()=='montagne')  echo "selected=\"yes\""; ?>>Dans le bon air frais montagnard</option>
                <option value="campagne"<?php if (isset($_POST["vacances"]) && $_POST["vacances"] == "campagne")
                            echo "selected=\"yes\""; if($test && $pref->getVacances()=='campagne')  echo "selected=\"yes\""; ?>>A regarder brouter les vaches dans les prés</option>
                <option value="ville"<?php if (isset($_POST["vacances"]) && $_POST["vacances"] == "ville")
                            echo "selected=\"yes\""; if($test && $pref->getVacances()=='ville')  echo "selected=\"yes\""; ?>>Entre quatre murs de béton, mais avec un ordinateur</option>
                <option value="indifferent"<?php if (isset($_POST["vacances"]) && $_POST["vacances"] == "indifferent")
                            echo "selected=\"yes\""; if($test && $pref->getVacances()=='indifferent')  echo "selected=\"yes\""; ?>>Entre quatre murs de béton, mais à l'hotel</option>
            </select>
        </p>
 *
 */
?>
 <p><label for="sportif">Les sportifs les plus sexys sont les: </label><select name="sportif">
<?php
                                $tabSportifs = array('Joueurs de Badminton', 'Basketeurs', 'Equitants', 'Escrimeurs', 'Golfeurs', 'Nageurs', 'Handballeurs', 'Volleyeurs', 'Avironeurs', 'Rugbeux', 'Grimpeurs', 'Judokas', 'Footeux', 'Tennismen', 'Raideurs');
                                $num=0;
                                foreach ($tabSportifs as $sportifName) {
                                    $num=$num+1;
                                    $s = "";
                                    if (isset($_POST["sportif"]) && $_POST["sportif"] == $sportifName)
                                        $s = "selected=\"yes\"";
                                    echo "<option {$s} value=\"id{$num}\">{$sportifName}</option>";
                                }
?>
                            </select>
                            <br/></p>

        <p> <label for="cheveux">Le future prénom de ta fille sera : </label>
            <select name="cheveux">
                <option value="id1"<?php if (isset($_POST["cheveux"]) && $_POST["cheveux"] == "blond")
                            echo "selected=\"yes\""; if($test && $pref->getCheveux()=='blond')  echo "selected=\"yes\""; ?>>Scarlet</option>
                <option value="id2"<?php if (isset($_POST["cheveux"]) && $_POST["cheveux"] == "brun")
                            echo "selected=\"yes\""; if($test && $pref->getCheveux()=='brun')  echo "selected=\"yes\""; ?>>Angelina</option>
                 <option value="id3" <?php if (isset($_POST["cheveux"]) && $_POST["cheveux"] == "roux")
                            echo "selected=\"yes\""; if($test && $pref->getCheveux()=='roux')  echo "selected=\"yes\""; ?>>Julia</option>
                <option value="indifferent"<?php if (isset($_POST["cheveux"]) && $_POST["cheveux"] == "indifferent")
                            echo "selected=\"yes\""; if($test && $pref->getCheveux()=='indifferent')  echo "selected=\"yes\""; ?>>Choisi par sa mère</option>
            </select>
        </p>

        <p> <label for="caractere">Tu penses que ton élément totémique est : </label>
            <select name="caractere">
                <option value="id1"<?php if (isset($_POST["caractere"]) && $_POST["caractere"] == "eau")
                            echo "selected=\"yes\""; if($test && $pref->getCaractere()=='eau')  echo "selected=\"yes\""; ?>>L'eau, insondable</option>
                <option value="id2" <?php if (isset($_POST["caractere"]) && $_POST["caractere"] == "terre")
                            echo "selected=\"yes\""; if($test && $pref->getCaractere()=='terre')  echo "selected=\"yes\""; ?>>La terre, inébranlable</option>
                <option value="id3"<?php if (isset($_POST["caractere"]) && $_POST["caractere"] == "feu")
                            echo "selected=\"yes\""; if($test && $pref->getCaractere()=='feu')  echo "selected=\"yes\""; ?>>Le feu, impérieux</option>
                <option value="id4"<?php if (isset($_POST["caractere"]) && $_POST["caractere"] == "vent")
                            echo "selected=\"yes\""; if($test && $pref->getCaractere()=='vent')  echo "selected=\"yes\""; ?>>Le vent, insaisissable</option>
                <option value="indifferent"<?php if (isset($_POST["caractere"]) && $_POST["caractere"] == "indifferent")
                            echo "selected=\"yes\""; if($test && $pref->getCaractere()=='indifferent')  echo "selected=\"yes\""; ?>>... sérieusement les questions empirent ...</option>
            </select>
        </p>


        <br/>
        <input type="submit" value="Trouver l'Amour!" class="formbutton">
        <br/>
    </fieldset>
</form>
