<?php
if (isset($_POST['pseudo']) && isset($_POST['message']) //Si les message existe
   && ($_POST['pseudo'] != NULL && $_POST['message'] != NULL)) //Si les deux champs sont bien rempli

    //On se connecte à MySQL
    { mysql_connect("localhost", "root", "26021990");
    mysql_select_db("users");

    // On utilise la fonction PHP htmlentities pour éviter d'enregistrer du code HTML dans la table
    $pseudo = htmlentities ($_POST['pseudo']);
    $message = htmlentities ($_POST['message']);

    //On enregistre dans la table minichat
    mysql_query("INSERT INTO minichat (`id`,`pseudo`,`message`) VALUES('', '$pseudo', '$message')");

    //On se deconnecte de MySQL
    mysql_close();
    }
?>