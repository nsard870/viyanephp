<?php
include('config.php');

//Récupérer le changement des informations par les inputs
if (isset($_POST['valid'])) {
    $id_client = $_POST['idc'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    // Vérification de l'ID récupéré en POST
    $requete = "SELECT * FROM clients
                WHERE id_client=:id";
    $reqsql = $pdo->prepare($requete);
    $reqsql->bindParam(':id', $id_client, PDO::PARAM_INT);
    $reqsql->execute();
    $count = $reqsql->rowCount();

    if ($count == 1) {
        $reqmodif = ' UPDATE clients 
                    SET nom=:nom,prenom=:prenom,email=:email,telephone=:telephone
                    WHERE id_client=:id';
        $reqsql = $pdo->prepare($reqmodif);
        $reqsql->bindParam(':nom', $nom, PDO::PARAM_STR);
        $reqsql->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $reqsql->bindParam(':email', $email, PDO::PARAM_STR);
        $reqsql->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $reqsql->bindParam(':id', $id_client, PDO::PARAM_INT);
        $reqsql->execute();
        header('Location: listeclients.php');
    } else {
        header('Location: listeclients.php');
    }
}
