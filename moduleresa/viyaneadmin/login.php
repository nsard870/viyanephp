<?php
session_start();
include("../config.php");

// Fonction de connexion à l'espace admin
if (isset($_POST['valid'])) {
    if (empty($_POST['login']) || empty($_POST['mdp'])) {
        header('location:admin.php?error=empty_fields');
        exit();
    }

    // Récupérer le login et le mot de passe
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    $requete = "SELECT * FROM admin 
                WHERE login=:login";
    $reqsql = $pdo->prepare($requete);
    $reqsql->bindParam(':login', $login, PDO::PARAM_STR);
    $reqsql->execute();
    $count = $reqsql->rowCount();

    // Vérifier le mot de passe
    if ($count == 1) {
        $reslogin = $reqsql->fetch(PDO::FETCH_ASSOC);
        $mdpstocke = $reslogin['mdp'];

        if (password_verify($mdp, $mdpstocke)) {
            $_SESSION['login'] = $login;
            $_SESSION['id_admin'] = $reslogin['id_admin'];
            $_SESSION['mdp'] = $mdp;
            
            header('location:../indexadmin.php'); // Rediriger vers l'espace admin si la connexion est reussie
        } else {
            header('location:admin.php?err=1'); // Rediriger vers la page de connexion si le mot de passe est incorrect
        }
    } else {
        header('location:admin.php?err=2'); // Rediriger vers la page de connexion si le login est incorrect
    }
} else {
    header('location:admin.php'); // Rediriger vers la page de connexion si le formulaire n'a pas encore été soumis
}
