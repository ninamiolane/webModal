<?php

function printLoginForm($askedPage) {
    ?>

<div id="wrapper">
    <div id="toppanel">

        <div id="panel">
            <div id="panel_contents">

                <div class="border" id="login">
                    <p style="text-align: center;">Entrez ici vos identifiants :</p>
                    <form method="post" action="index.php?page=<?php echo $askedPage; ?>&todo=login">
                        <p><label for="login" style="display: block; width:  50%;float: left;">Pseudo :</label>
                            <input type="text" size="15" name="login" id="username" />
                        </p>
                        <p>
                            <label for="mdp" style="display: block; width: 50%; float: left;">Password:</label>
                            <input type="password" size="15" name="mdp" id="password" />

                            <br />
                                <?php
                                if (isset($_SESSION['erreurLogin']))
                                    echo '<span style="color:red">' . $_SESSION['erreurLogin'] . '</span>';
                                ?>
                            <br/>
                            <input type="submit" accesskey="l" id="login_btn" name="connexion" value="Se connecter" />

                        </p>
                    </form>
                </div>   </div>
        </div>
        <div class="panel_button" style="display: visible;"><img src="./images/expand.png"  alt="expand"/>
            <a href="#">Connexion</a>

        </div>
        <div class="panel_button" id="hide_button" style="display: none;"><img src="./images/collapse.png" alt="collapse" />

            <a href="#">Fermer</a>
        </div>
    </div>
</div>

    <?php
}
?>

<?php

function printLogoutForm() {
    ?>
<div id="wrapper">
    <div id="toppanel">

        <div id="panel">
            <div id="panel_contents">

                <div class="border" id="login">
                    <p style="text-align: center;">Cliquez pour fermer votre session :</p>
                    <form method="post" action="index.php?page=accueil&todo=logout">
                        <input type="submit" accesskey="l" id="logout_btn" name="deconnexion" value="Se déconnecter" />
                    </form>
                </div>   </div>
        </div>
        <div class="panel_button" style="display: visible;"><img src="./images/expand.png"  alt="expand"/>
            <a href="#">Quitter</a>

        </div>
        <div class="panel_button" id="hide_button" style="display: none;"><img src="./images/collapse.png" alt="collapse" />

            <a href="#">Fermer</a>
        </div>
    </div>
</div>
    <?php
}


function printminichatForm() {
    ?>
<div class="menu">
    <div class="border" >
        <p style="text-align: center;font-weight: bold; font-size: large; color:maroon; line-height: 0;">Chat :</p>
        <div id="messages" ></div>
        <form action="#" method="post" id="formchat">
            <p style="text-align: center;">Votre message : <input type="text" name="message" id="message" /></p>
            <p style="text-align: center;"><input type="submit" value="Envoyer"/></p>
        </form>
    </div>
</div>
    <?php
}
?>