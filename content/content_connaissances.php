<script type="text/javascript">

    $(document).ready(function(){
        $("div.affichage").each(function(i){
            if(i%2==0){
                $(this).find("div.photos").css("background-color","#fffdee");
                $(this).css("background-color","#fffdee");
            }
            else{
                $(this).find("div.photos").css("background-color","white;");
                $(this).css("background-color","white");
            }
            $(this).find("div.photos").attr("id","TexteAAfficher"+(i+1)).hide();
            $(this).find("div.avatarProfil").attr("id","inviteClic"+(i+1)).attr("statut","1").click(
            function(){
                $("#TexteAAfficher"+(i+1)).slideToggle("slow");
                $("#TexteAAfficher"+(i+1)+" a").lightBox();
                if ($("#inviteClic"+(i+1)).attr("statut")=="1"){
                    $("#inviteClic"+(i+1)).attr("statut","0");
                }
                else{
                    $("#inviteClic"+(i+1)).attr("statut","1");
                };
            })
        });
    });
</script>

<h2>Liste de vos connaissances actuelles</h2>
<p style="text-align: center; font-size: small; font-style: italic; color: black;">Cliquer sur les avatars pour accéder aux galleries de photos</p>
<div class="zoneTexteAfficherMasquer">
    <?php
    if ($_GET['todo'] == preferences) {
        $nvConn = $_SESSION['nouvelleConnaissance'];
        $nvuser = Utilisateur::getUtilisateur($nvConn);
        echo "<p style='text-align:center; font-style:italic;'>Voici une personne qui vous convient très bien!'</p>";
        echo '<br/>';
        echo "<div class='affichage'>";
        echo $nvuser->affichage1();
        echo "</div>";
    }

    $log = $_SESSION['login'];
    $u = Utilisateur::getUtilisateur($log);
    $tab = $u->getAmis();
    if ($_GET['todo'] == preferences) {
        $tabBis = array_diff($tab, array($nvuser));
    } else {
        $tabBis = $tab;
    }
    foreach ($tabBis as $util) {
        echo '<br/>';
        echo "<div class='affichage'>";
        $indic = getIndiceConnaissance($log, $util->login);
        if ($indic <= 5) {
            echo $util->affichage1();
        }
        else if ((5 < $indic) && ($indic <= 10)) {
            echo $util->affichage2();
        }
        else if ((10 < $indic) && ($indic <= 20)) {
            echo $util;
            echo "<p style='clear:both; text-align:center; font-style:italic;'>Ta relation avec <strong style='color:black'>".$util->login."</strong> est déjà remarquablement bien avancée. Encore un peu et tu pourras avoir accès à sa galerie de photos !</p>";
        }
        else {
            echo $util;
            printGallery($util->login);
        }
        echo "</div>";
    }
    ?>
</div>