<?php
session_start();
include("config.php");
if (!auth::islogged()) {
    header('Location: viyaneadlin/admin.php');
    die();
}

$admin_name = $_SESSION['login'];

$requete = "SELECT * FROM reservations r
            INNER JOIN clients c ON r.id_client = c.id_client
            WHERE DATE(date_heure) = CURDATE()
            ORDER BY date_heure ASC";
$reqsql = $pdo->prepare($requete);
$reqsql->execute();
$reservations = $reqsql->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['btn_ok']) || isset($_POST['btn_ko'])) {
    $status = (isset($_POST['btn_ok'])) ? 'Acceptée' : 'Refusée';
    if (isset($_POST['id_resa'])) {
        foreach ($_POST['id_resa'] as $id_reservation) {
            $id_reservation = intval($id_reservation);

            try {
                $update_query = "UPDATE reservations SET status = ? WHERE id_reservation = ?";
                $update_stmt = $pdo->prepare($update_query);
                $update_stmt->execute([$status, $id_reservation]);
            } catch (PDOException $e) {
                error_log("Error updating reservation: " . $e->getMessage());
            }
        }
    }
    header("Location: indexadmin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Accueil - Espace Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="modulecss/index.css">
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
                        <span class="welcome-message">Bienvenue, <?php echo $admin_name; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="viyaneadmin/logout.php">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Tableau de Bord</h1>
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Gestion des Clients</h5>
                        <a href="listeclients.php" class="btn btn-primary">Gérer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-3x mb-3 text-success"></i>
                        <h5 class="card-title">Gestion des Réservations</h5>
                        <a href="listereservations.php" class="btn btn-primary">Gérer</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x mb-3 text-info"></i>
                        <h5 class="card-title">Statistiques</h5>
                        <a href="stats.php" class="btn btn-info">Voir</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Réservations du jour</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Horaire</th>
                                            <th>Personnes</th>
                                            <th>Commentaires</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
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
                                                    <a class="btn btn-primary btn-action" href='modif_reservations.php?id=<?php echo $resresa['id_reservation']; ?>'>
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
                            <div class="d-flex justify-content-end btn-check-group">
                                <button type="submit" name="btn_ok" class="btn btn-outline-success"><i class="fas fa-check"></i> Confirmer</button>
                                <button type="submit" name="btn_ko" class="btn btn-outline-danger"><i class="fas fa-times"></i> Refuser</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>