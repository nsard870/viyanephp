<?php
include('config.php');

//Récupérer le changement des informations par les inputs
if (isset($_POST['valid'])) {
    $id_reservation = $_POST['idr'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $nombre_personnes = $_POST['nombre_personnes'];
    $commentaires = $_POST['commentaires'];
    $status = $_POST['status'];

    // Vérification de l'ID récupéré en POST
    $requete = "SELECT * FROM reservations
                WHERE id_reservation=:id";
    $reqsql = $pdo->prepare($requete);
    $reqsql->bindParam(':id', $id_reservation, PDO::PARAM_INT);
    $reqsql->execute();
    $count = $reqsql->rowCount();

    if ($count == 1) {
        $reqmodif = 'UPDATE reservations
                    SET date=:date,heure=:heure,nombre_personnes=:nombre_personnes,commentaires=:commentaires, status=:status
                    WHERE id_reservation=:id';
        $reqsql = $pdo->prepare($reqmodif);
        $reqsql->bindParam(':date', $date, PDO::PARAM_STR);
        $reqsql->bindParam(':heure', $heure, PDO::PARAM_STR);
        $reqsql->bindParam(':nombre_personnes', $nombre_personnes, PDO::PARAM_INT);
        $reqsql->bindParam(':commentaires', $commentaires, PDO::PARAM_STR);
        $reqsql->bindParam(':status', $status, PDO::PARAM_STR);
        $reqsql->bindParam(':id', $id_reservation, PDO::PARAM_INT);
        $reqsql->execute();
        header('Location: listereservations.php');
    } else {
        header('Location: listereservationsstatus');
    }
}
