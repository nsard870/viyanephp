<?php
include('config.php');

// Récupérer le changement des informations par les inputs
if (isset($_POST['valid'])) {
    $id_reservation = $_POST['idr'];
    $date = $_POST['date'];
    $service = $_POST['service'];
    $nombre_personnes = $_POST['nombre_personnes'];
    $commentaires = $_POST['commentaires'];
    $status = $_POST['status'];

    // Détermination de l'heure en fonction du service
    if ($service == 'midi') {
        $heure = '11:30:00'; // Heure par défaut pour le midi
    } else {
        $heure = '18:30:00'; // Heure par défaut pour le soir
    }

    // Combine la date et l'heure en une seule chaîne
    $date_heure = $date . ' ' . $heure;

    // Vérification de l'ID récupéré en POST
    $requete = "SELECT * FROM reservations 
                WHERE id_reservation=:id";
    $reqsql = $pdo->prepare($requete);
    $reqsql->bindParam(':id', $id_reservation, PDO::PARAM_INT);
    $reqsql->execute();
    $count = $reqsql->rowCount();

    if ($count == 1) {
        $reqmodif = 'UPDATE reservations 
                    SET date_heure=:date_heure, nombre_personnes=:nombre_personnes, commentaires=:commentaires, 
                    status=:status WHERE id_reservation=:id';
        $reqsql = $pdo->prepare($reqmodif);
        $reqsql->bindParam(':date_heure', $date_heure, PDO::PARAM_STR); // Utilisation de date_heure
        $reqsql->bindParam(':nombre_personnes', $nombre_personnes, PDO::PARAM_INT);
        $reqsql->bindParam(':commentaires', $commentaires, PDO::PARAM_STR);
        $reqsql->bindParam(':status', $status, PDO::PARAM_STR);
        $reqsql->bindParam(':id', $id_reservation, PDO::PARAM_INT);

        try {
            $reqsql->execute();

            // Vérifier si le statut a changé et envoyer l'email
            if ($resresa['status'] !== $status) {
                sendStatusChangeEmail($resresa['email'], $status);
            }

            header('Location: listereservations.php'); // Rediriger en cas de succès
            exit();
        } catch (PDOException $e) {
            // Gérer les erreurs de mise à jour ici
            echo "Erreur lors de la modification : " . $e->getMessage();
            // Rediriger ou afficher un message d'erreur
        }
    } else {
        header('Location: listereservations.php'); // Rediriger si on n'arrive pas depuis le formulaire
        exit();
    }
}
