<?php

function logIn() {

    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    $user = Utilisateur::getUtilisateur($login);
    $mdpOk = Utilisateur::testerMdp($user, $mdp);
    if ($mdpOk) {
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['loggedIn'] = true;
    }
}

function logOut() {
    session_unset();
    session_destroy();
}

?>
