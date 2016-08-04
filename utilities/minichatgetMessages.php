<?php
session_name("Hello");
session_start();
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}

// Maintenant on doit récupérer les 10 dernières entrées de la table
// On se connecte d'abord à MySQL :
mysql_connect("localhost", "root", "26021990");
mysql_select_db("users");
$id = $_POST['id'];
if ($id == 0 && isset($_SESSION['idChat'])) {
    $id = $_SESSION['idChat'];
}
if ($id==0) {
    $query = "SELECT * FROM minichat WHERE `id`>{$id}  ORDER BY id DESC LIMIT 1";
//echo $query;
    $tab = array();
    $tab['message'] = "";
    $reponse = mysql_query($query);
    if (mysql_num_rows($reponse) == 1) {
        $donnees = mysql_fetch_array($reponse);
        $tab['id'] = $donnees['id'];

        $_SESSION['idChat'] = $donnees['id'];
    } else $tab['id'] = 0;
// On se déconnecte de MySQL
    mysql_close();
    echo json_encode($tab);
    exit();
}
// On utilise la requête suivante pour récupérer les 10 derniers messages :
$query = "SELECT * FROM minichat WHERE `id`>{$id}  ORDER BY id DESC ";
//echo $query;
$reponse = mysql_query($query);

// On se déconnecte de MySQL
mysql_close();
$tab = array();
$tab['id'] = $id;
// Puis on fait une boucle pour afficher tous les résultats :
while($donnees = mysql_fetch_array($reponse)) {
    if ($donnees['id'] > $tab['id']) $tab['id'] = $donnees['id'];

    $tab['message'].=<<<END
<p><strong style="color:blue"> {$_SESSION['login']} </strong> : {$donnees['message']}</p>
END;
// ci dessus, sesssion_login pour afficher directement le pseudo de l'utilisateur

}
echo json_encode($tab);
?>