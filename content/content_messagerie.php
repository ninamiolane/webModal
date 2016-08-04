<h2>Messages dans votre boite :</h2>

<script type="text/javascript">


$(document).ready(function(){
    $("div.zoneTexteAfficherMasquer").each(function(i){
        // find permet d appliquer un sélecteur sur un ensemble selectionné
        $(this).find("div.TexteAAfficher").attr("id","TexteAAfficher"+(i+1)).hide();
        $(this).find("p.ZoneDeClic").attr("id","inviteClic"+(i+1)).attr("statut","1").click(
        function(){
            $("#TexteAAfficher"+(i+1)).slideToggle("slow");
            // selon le statut on renomme le texte
            if ($("#inviteClic"+(i+1)).attr("statut")=="1"){
                $("#inviteClic"+(i+1)).attr("statut","0");
            }
            else{
                $("#inviteClic"+(i+1)).attr("statut","1");
            };
        })
    });
});

$(document).ready(function(){
    $("div.msg").each(function(i){
        // find permet d appliquer un sélecteur sur un ensemble selectionné
        $(this).find("p.message").attr("id","message"+(i+1)).hide();
        $(this).find("h3.titreMessage").attr("id","titreMessage"+(i+1)).attr("statut","1").click(
        function(){
            $("#message"+(i+1)).slideToggle("slow");
            // selon le statut on renomme le texte
            if ($("#titreMessage"+(i+1)).attr("statut")=="1"){
                $("#titreMessage"+(i+1)).attr("statut","0");
            }
            else{
                $("#titreMessage"+(i+1)).attr("statut","1");
            };
        })
    });
});

</script>

<script type="text/javascript">
    var xhr = getXMLHttpRequest(); // Voyez la fonction getXMLHttpRequest() définie dans la partie précédente

    xhr.open("GET", "./index.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("page=messagerie&todo=delete");

</script>

<?php
if(isset ($_GET['todo']) && isset($_GET['id'])){
    if($_GET['todo']=="delete") {
        Message::deleteMsg($_SESSION['login'],$_GET['id']);
        echo "<p style='text-align:center;font-style:italic;'>Message supprimé</p>";
    }
}
else if (isset ($_POST['destinataire']) && isset($_POST['objet']) && isset($_POST['message']) && $_POST['destinataire']!= "" && $_POST['objet']!= "" && $_POST['message']!= ""  ) {
    date_default_timezone_set('Europe/Paris');
    sendMsg($_POST['destinataire'], "JKZ", date("Y-m-d"), $_POST['objet'], $_POST['message'], date('H:i:s'));
    incrementeIndice($_SESSION['login'], $_POST['destinataire']);
    echo "<p style='text-align:center;font-style:italic;'>Message envoyé</p>";
}
else {
    echo "
        <div class= \"zoneTexteAfficherMasquer\">
        <p class=\"ZoneDeClic\"><button>Afficher/Masquer mes messages</button></p>
        <div class= \"TexteAAfficher\">";
    $messages = getMsg($_SESSION['login']);
    foreach($messages as $message){
        echo $message;
        echo "<br/>";
    }

echo "</div>
</div>


<div class= \"zoneTexteAfficherMasquer\">
<p class=\"ZoneDeClic\"><button>Rédiger un nouveau message</button></p>


<div class= \"TexteAAfficher\">
<form method=\"post\" action=\"./index.php?page=messagerie\">
    <p>
        <label for=\"destinataire\">Destinataire :  </label><input type=\"text\" name=\"destinataire\" value=\"";
    if(isset($_POST["destinataire"])) echo $_POST["destinataire"];
    echo "\" />
        <br/></p>
    <p><label for=\"objet\">Objet : </label><input type=\"text\" name=\"objet\"  value=\"Sans objet\"/>
        <br/></p>
    <p><label for=\"message\">Message : </label><textarea name=\"message\" cols=\"40\" rows=\"10\" >";
    if(isset($_POST["message"])) echo $_POST["message"];
    echo "</textarea>
        <br/></p>

    <input type=\"submit\" value=\"Envoyer\" class=\"formbutton\">

</form>
</div>
</div>";
}
?>
