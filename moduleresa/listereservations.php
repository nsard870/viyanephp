<?php
session_start();
include("config.php");

if (!auth::islogged()) {
    header('location: admin.php');
    exit();
}

$admin_name = isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Admin';

//  Fonction de pagination
$items_per_page = 10; // Nombre de réservations à afficher par page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page); // Assurez-vous que la page est au moins 1
$offset = ($current_page - 1) * $items_per_page;

//  Fonctionnalité de recherche 
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Nombre total de réservations pour la pagination
try {
    $total_reservations_stmt = $pdo->prepare("SELECT COUNT(*) 
                                                FROM clients
                                                WHERE nom 
                                                LIKE :search 
                                                OR prenom 
                                                LIKE :search");
    $total_reservations_stmt->execute([':search' => "%$search%"]);
    $total_reservations = $total_reservations_stmt->fetchColumn();
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Erreur lors du comptage des réservations: " . htmlspecialchars($e->getMessage()) . "</div>";
    error_log("Erreur PDO (comptage des réservations): " . $e->getMessage());
    $total_reservations = 0; // Valeur par défaut à 0 en cas d'erreur
}

// Récupération des réservations avec LIMIT, OFFSET et SEARCH
try {
    $reqsql = $pdo->prepare("SELECT r.*, c.nom, c.prenom, c.email, c.telephone
                            FROM reservations r
                            INNER JOIN clients c ON r.id_client = c.id_client
                            WHERE c.nom LIKE :search OR c.prenom LIKE :search
                            ORDER BY r.date_heure ASC
                            LIMIT :limit OFFSET :offset");
    $reqsql->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $reqsql->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $reqsql->bindValue(':offset', $offset, PDO::PARAM_INT);
    $reqsql->execute();
    $reservations = $reqsql->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Erreur lors de la récupération des réservations : " . htmlspecialchars($e->getMessage()) . "</div>";
    error_log("Erreur PDO (récupération des réservations): " . $e->getMessage());
    $reservations = []; // Définir à un tableau vide en cas d'erreur
}

// Mise à jour du statut de la reservation
if (isset($_POST['btn_ok']) || isset($_POST['btn_ko'])) {
    $status = isset($_POST['btn_ok']) ? 'Acceptée' : 'Refusée';
    if (isset($_POST['id_resa']) && is_array($_POST['id_resa'])) {
        $ids_a_modifier = $_POST['id_resa'];
        $placeholders = implode(',', array_fill(0, count($ids_a_modifier), '?'));

        // Récupérer les emails et les anciens statuts des réservations avant la mise à jour
        $select_query = "SELECT id_reservation, email, status 
                            FROM reservations 
                            WHERE id_reservation 
                            IN ($placeholders)";
        $select_stmt = $pdo->prepare($select_query);
        $select_stmt->execute($ids_a_modifier);
        $reservations = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

        // Mettre à jour le statut des réservations
        $sql_update = "UPDATE reservations 
                        SET status = ? 
                        WHERE id_reservation 
                        IN ($placeholders)";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindValue(1, $status, PDO::PARAM_STR);
        foreach ($ids_a_modifier as $index => $id) {
            $stmt_update->bindValue($index + 2, $id, PDO::PARAM_INT);
        }
        $stmt_update->execute();

        // Envoyer les emails si le statut a changé
        foreach ($reservations as $reservation) {
            if ($reservation['status'] != $status) {
                sendStatusChangeEmail($reservation['email'], $status);
            }
        }

        echo "<div class='alert alert-success'>Statut(s) mis à jour avec succès.</div>";
        header("Location: listereservations.php?page=$current_page");
        exit();
    }
}

// Fonction de suppression de la liste
if (isset($_POST['btn_spr'])) {
    if (isset($_POST['id_resa']) && is_array($_POST['id_resa'])) {
        $ids_a_supprimer = $_POST['id_resa'];
        $placeholders = implode(',', array_fill(0, count($ids_a_supprimer), '?'));

        $sql_suppression = "DELETE FROM reservations 
                            WHERE id_reservation 
                            IN ($placeholders)";
        $stmt_suppression = $pdo->prepare($sql_suppression);
        foreach ($ids_a_supprimer as $index => $id) {
            $stmt_suppression->bindValue($index + 1, $id, PDO::PARAM_INT); // +1 car bindValue commence à 1
        }

        try {
            $stmt_suppression->execute();
            echo "<div class='alert alert-success'>Réservation(s) supprimée(s) avec succès.</div>";
            header("Location: listereservations.php?page=$current_page"); // Rediriger et garder la page actuelle
            exit();
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur lors de la suppression : " . htmlspecialchars($e->getMessage()) . "</div>";
            error_log("Erreur PDO (suppression de réservation): " . $e->getMessage());
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Liste des Réservations</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="modulecss/listeclients.css">
    <style>
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="indexadmin.php">Espace Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text me-3 text-white">Bienvenue, <?php echo $admin_name; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-action" href="viyaneadmin/logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Liste des réservations</h1>
            </div>
            <div class="card-body">
                <form action="" method="get" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou prénom" value="<?php echo $search; ?>">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Rechercher</button>
                    </div>
                </form>
                <form action="" method="post">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Horaire</th>
                                    <th>Nb pax</th>
                                    <th>Commentaires</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Numéro de téléphone</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Sélection</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservations as $resresa) : ?>
                                    <tr>
                                        <td><?php echo (new DateTime($resresa['date_heure']))->format('d/m/Y'); ?></td>
                                        <td><?php echo (new DateTime($resresa['date_heure']))->format('H:i'); ?></td>
                                        <td><?php echo $resresa['nombre_personnes']; ?></td>
                                        <td><?php echo htmlspecialchars(mb_substr($resresa['commentaires'], 0, 50));
                                            if (mb_strlen($resresa['commentaires']) > 50) {
                                                echo "...";
                                            } ?></td>
                                        <td><?php echo htmlspecialchars($resresa['nom']); ?></td>
                                        <td><?php echo htmlspecialchars($resresa['prenom']); ?></td>
                                        <td><?php echo htmlspecialchars($resresa['email']); ?></td>
                                        <td><?php echo htmlspecialchars($resresa['telephone']); ?></td>
                                        <td><?php echo htmlspecialchars($resresa['status']); ?></td>
                                        <td>
                                            <a class='btn btn-primary btn-action' href='modif_reservations.php?id=<?php echo $resresa['id_reservation']; ?>'>
                                                <i class="fas fa-edit"></i> Modifier
                                            </a>
                                        </td>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="id_resa[]" value="<?php echo $resresa['id_reservation']; ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a class="btn btn-secondary btn-action" href="indexadmin.php">
                            <i class="fas fa-arrow-left"></i> Retour au menu principal
                        </a>
                        <button type="submit" name="btn_ok" class="btn btn-success btn-action">
                            <i class="fas fa-check"></i> Confirmer
                        </button>
                        <button type="submit" name="btn_ko" class="btn btn-danger btn-action">
                            <i class="fas fa-times"></i> Refuser
                        </button>
                        <button type="submit" name="btn_spr" class="btn btn-danger btn-action" onclick="return confirm('Êtes-vous sûr de vouloir supprimer les réservations sélectionnées ?');">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        // Lien de pagination uniquement si des réservations sont trouvées
        if ($total_reservations > 0) {
            $total_pages = ceil($total_reservations / $items_per_page);

            echo '<nav aria-label="Page navigation" class="mt-3"><ul class="pagination justify-content-center">';

            // Page précedente
            if ($current_page > 1) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '&search=' . $search . '">Précédent</a></li>';
            }

            // Page links
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li class="page-item' . ($i == $current_page ? ' active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . $search . '">' . $i . '</a></li>';
            }

            // Page suivante
            if ($current_page < $total_pages) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '&search=' . $search . '">Suivant</a></li>';
            }

            echo '</ul></nav>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>