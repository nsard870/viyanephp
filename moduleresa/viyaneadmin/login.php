<?php
session_start();
include("../config.php");

if (isset($_POST['valid'])) {
    if (empty($_POST['login']) || empty($_POST['mdp'])) {
        header('location:admin.php?error=empty_fields');
        exit();
    }

    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    $requete = "SELECT * FROM admin 
                WHERE login=:login";
    $reqsql = $pdo->prepare($requete);
    $reqsql->bindParam(':login', $login, PDO::PARAM_STR);
    $reqsql->execute();
    $count = $reqsql->rowCount();

    if ($count == 1) {
        $reslogin = $reqsql->fetch(PDO::FETCH_ASSOC);
        $mdpstocke = $reslogin['mdp'];

        if (password_verify($mdp, $mdpstocke)) {
            $_SESSION['login'] = $login;
            $_SESSION['id_admin'] = $reslogin['id_admin'];
            $_SESSION['mdp'] = $mdp;
            
            header('location:../indexadmin.php');
        } else {
            header('location:admin.php?err=1');
        }
    } else {
        header('location:admin.php?err=2');
    }
} else {
    header('location:admin.php');
}
