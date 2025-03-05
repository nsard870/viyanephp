<?php
session_start();
include("config.php");

if (!auth::islogged()) {
    header('Location: admin.php');
    exit();
}

$admin_name = isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Admin';

// --- 1. Total des Réservations ---
try {
    $total_reservations = $pdo->query("SELECT COUNT(*) FROM reservations")->fetchColumn();
} catch (PDOException $e) {
    $total_reservations = 0; // Valeur par défaut en cas d'erreur
    error_log("Erreur lors de la récupération du total des réservations : " . $e->getMessage());
}

// --- 2. Total des Clients ---
try {
    $total_clients = $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
} catch (PDOException $e) {
    $total_clients = 0;
    error_log("Erreur lors de la récupération du total des clients : " . $e->getMessage());
}

// --- 3. Réservations Aujourd'hui ---
try {
    $today_reservations_stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE DATE(date_heure) = CURDATE()");
    $today_reservations_stmt->execute();
    $today_reservations = $today_reservations_stmt->fetchColumn();
} catch (PDOException $e) {
    $today_reservations = 0;
    error_log("Erreur lors de la récupération des réservations d'aujourd'hui : " . $e->getMessage());
}

// --- 4. Réservations par Statut ---
try {
    $status_counts_stmt = $pdo->query("SELECT status, COUNT(*) as count FROM reservations GROUP BY status");
    $status_counts = $status_counts_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir le résultat en un format plus pratique pour une utilisation ultérieure
    $status_data = [];
    foreach ($status_counts as $row) {
        $status_data[$row['status']] = $row['count'];
    }
    // S'assurer que chaque statut est présent, même si le compte est 0.
    $status_data['Acceptée'] = $status_data['Acceptée'] ?? 0;  // Utilisation de l'opérateur de coalescence nulle
    $status_data['Refusée'] = $status_data['Refusée'] ?? 0;
    $status_data['Attente'] = $status_data['Attente'] ?? 0;
} catch (PDOException $e) {
    $status_data = ['Acceptée' => 0, 'Refusée' => 0, 'Attente' => 0]; // Valeur par défaut en cas d'erreur
    error_log("Erreur lors de la récupération des comptes par statut : " . $e->getMessage());
}

// --- 5. Réservations par Jour (7 derniers jours) - Données pour Chart.js ---
try {
    $reservations_per_day_stmt = $pdo->prepare("
        SELECT DATE(date_heure) AS reservation_date, COUNT(*) AS daily_count
        FROM reservations
        WHERE date_heure >= CURDATE() - INTERVAL 6 DAY  -- Corrigé pour revenir 6 jours en arrière
        GROUP BY DATE(date_heure)
        ORDER BY DATE(date_heure)
    ");
    $reservations_per_day_stmt->execute();
    $reservations_per_day = $reservations_per_day_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Préparer les données pour Chart.js. Remplir les dates manquantes.
    $labels = [];
    $data = [];
    $today = new DateTime();
    for ($i = 6; $i >= 0; $i--) { // Reculer de 6 jours + aujourd'hui = 7
        $date = clone $today;  // Le clonage est *essentiel* ici
        $date->sub(new DateInterval("P{$i}D")); // Soustraire i jours.
        $date_string = $date->format('Y-m-d');
        $labels[] = $date->format('D, M j');  // ex., "Lun, Mar 4" - Jour, Mois, Jour du Mois

        // Trouver le compte pour cette date, ou utiliser 0 si non trouvé
        $count = 0;
        foreach ($reservations_per_day as $row) {
            if ($row['reservation_date'] == $date_string) {
                $count = (int)$row['daily_count']; // caster le compte
                break;
            }
        }
        $data[] = $count;
    }

    $chart_labels = json_encode($labels); // Convertir en JSON pour Chart.js
    $chart_data = json_encode($data);
} catch (PDOException $e) {
    $chart_labels = "[]";
    $chart_data = "[]";
    error_log("Erreur lors de la récupération des réservations par jour : " . $e->getMessage());
}

// --- 6. Réservations Récentes (pour le tableau) ---
try {
    $recent_reservations_stmt = $pdo->prepare("
        SELECT r.*, c.nom, c.prenom, c.email, c.telephone
        FROM reservations r
        INNER JOIN clients c ON r.id_client = c.id_client
        ORDER BY r.date_heure DESC
        LIMIT 5
    ");
    $recent_reservations_stmt->execute();
    $recent_reservations = $recent_reservations_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $recent_reservations = []; // Tableau vide en cas d'erreur
    echo "<div class='alert alert-danger'>Erreur lors de la récupération des réservations : " . htmlspecialchars($e->getMessage()) . "</div>";
    error_log("Erreur PDO (récupération des réservations récentes) : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Statistiques - Espace Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="modulecss/listeclients.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text me-3 text-white">Bienvenue, <?php echo $admin_name; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-action" href="viyaneadmin/logout.php">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Statistiques</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-check fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Total Réservations</h5>
                        <p class="card-text fs-3"><?php echo $total_reservations; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-3 text-success"></i>
                        <h5 class="card-title">Total Clients</h5>
                        <p class="card-text fs-3"><?php echo $total_clients; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-day fa-3x mb-3 text-info"></i>
                        <h5 class="card-title">Réservations Aujourd'hui</h5>
                        <p class="card-text fs-3"><?php echo $today_reservations; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Réservations par Statut</div>
                    <div class="card-body">
                        <ul>
                            <li>Acceptées: <?php echo $status_data['Acceptée']; ?></li>
                            <li>Refusées: <?php echo $status_data['Refusée']; ?></li>
                            <li>En Attente: <?php echo $status_data['Attente']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Réservations par Jour (7 derniers jours)</div>
                    <div class="card-body">
                        <canvas id="reservationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">5 Dernières réservations</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Personnes</th>
                                        <th>Téléphone</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_reservations as $reservation) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((new DateTime($reservation['date_heure']))->format('d/m/Y')); ?></td>
                                            <td><?php echo htmlspecialchars((new DateTime($reservation['date_heure']))->format('H:i')); ?></td>
                                            <td><?php echo htmlspecialchars($reservation['nom']); ?></td>
                                            <td><?php echo htmlspecialchars($reservation['prenom']); ?></td>
                                            <td><?php echo htmlspecialchars($reservation['nombre_personnes']); ?></td>
                                            <td><?php echo htmlspecialchars($reservation['telephone']); ?></td>
                                            <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const ctx = document.getElementById('reservationsChart').getContext('2d');
            const reservationsChart = new Chart(ctx, {
                type: 'line', //  Graphique en ligne
                data: {
                    labels: <?php echo $chart_labels; ?>, //  Étiquettes de l'axe X (dates)
                    datasets: [{
                        label: 'Réservations',
                        data: <?php echo $chart_data; ?>, //  Données de l'axe Y (comptes)
                        backgroundColor: '#D4AF37', //  Couleur de remplissage
                        borderColor: '#990000', //  Couleur de la ligne
                        borderWidth: 2,
                        tension: 0.4, //  Lignes lisses
                        pointRadius: 5, //  Points plus grands
                        pointBackgroundColor: '#D4AF37', // Couleur des points
                        pointBorderColor: '#fff', // Couleur de la bordure des points
                        pointHoverRadius: 7, //  Rayon plus grand au survol
                    }]
                },
                options: {
                    responsive: true, // Rendre le graphique réactif
                    maintainAspectRatio: false, // Important pour un dimensionnement correct dans Bootstrap
                    scales: {
                        y: {
                            beginAtZero: true, // Commencer l'axe y à 0
                            ticks: {
                                stepSize: 1, //  Forcer les graduations entières
                                precision: 0 //  Pas de décimales sur l'axe y
                            }
                        }
                    }
                }
            });
        </script>
        <div class="mt-3 mb-3">
            <a class="btn btn-secondary btn-action" href="indexadmin.php">
                <i class="fas fa-arrow-left"></i> Retour au menu principal
            </a>
        </div>
</body>

</html>