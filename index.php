<?php
session_name("Hello");
session_start();
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
// Décommenter la ligne suivante pour afficher le tableau $_SESSION pour le debuggage
// print_r($_SESSION);


unset($_SESSION['erreurCreerCompte']);
require('./utilities/utils.php');
require('./utilities/logInOut.php');
require('./utilities/loginPanel.php');

//traitement des formulaires Inscription ou Login
if (isset($_GET['todo'])) {
    switch ($_GET['todo']) {
        case 'creerCompte' : Utilisateur::insererUtilisateur($_POST["login"], $_POST["email"], $_POST["mdp"], $_POST["sexe"], $_POST["cheveux"], $_POST["section"], $_POST["reincarne"]);
            logIn();
            Data::insererUtilisateur($_POST["login"]);
            break;
        case 'login': incrementeTousIndices($_POST["login"]);logIn();
            break;
        case 'logout': logOut();
            break;
        case 'preferences' :
            Preferences::setPreferences($_SESSION['login'], $_POST["genre"], $_POST["age"], $_POST["sportif"], $_POST["cheveux"], $_POST["caractere"]);
            $_SESSION['nouvelleConnaissance']=rechercheEtInsere($_SESSION['login'],$_POST['typeRecherche']);
    }
}

//traitement de la page demandée, si elle est autorisée
if (isset($_GET['page'])) {
    $askedPage = $_GET['page'];
}
else
    $askedPage='accueil';


$authorized = checkPage($askedPage);
$pageTitle;
if ($authorized == true)
    $pageTitle = getPageTitle($askedPage);
else
    $pageTitle="Erreur";



generateHTMLheader("$pageTitle", 'feuilleCSS2.css');
?>

<body>

    <div class="bg"></div><!--background transparent-->
    <div class="head"></div><!--header-->
    <!--Diaporama-->
    <div class="slideshow">
        <img src="./photos/image1.jpg" width="200" height="200" alt="img"/>
        <img src="./photos/image2.jpg" width="200" height="200" alt="img"/>
        <img src="./photos/image3.jpg" width="200" height="200" alt="img"/>
        <img src="./photos/image4.jpg" width="200" height="200" alt="img"/>
        <img src="./photos/image5.jpg" width="200" height="200" alt="img"/>
    </div>
    <div class="slideshow2">
        <img src="./photos/image1.jpg" width="200" height="200" alt="img"/>
        <img src="./photos/image2.jpg" width="200" height="200" alt="img"/>
        <img src="./photos/image3.jpg" width="200" height="200" alt="img"/>
        <img src="./photos/image4.jpg" width="200" height="200" alt="img"/>
        <img src="./photos/image5.jpg" width="200" height="200" alt="img"/>
    </div>
    <!--Banière par dessus le header-->
    <div class="title">
        <p><img src="./images/test10.png" alt="img"/></p>
    </div>
    <div class="title2">
        <p><img src="./images/test10.png" alt="img"/></p>
    </div>

    <!--Eléments de la colonne de gauche-->
    <div class="left">

        <?php
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"])
            generateMenu($askedPage);
        ?>


        <?php
        if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"])) {
            printminichatForm();
        }
        ?>
        <div>
            <?php
            if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
                printLogoutForm();
            } else {
                printLoginForm($askedPage);
            }
            ?>
        </div>

    </div>

    <!--Bloc central de la page-->
    <div class="content">
        <?php
        generateContent($askedPage);
        ?>

    </div>
</body>
</html>
