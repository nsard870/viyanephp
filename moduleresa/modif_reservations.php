<?php
session_start();
include("config.php");

// Verifier si l'utilisateur est connecté
if (!auth::islogged()) {
    header('location:admin.php');
    die();
}

// Récupérer le nom de l'admin
$admin_name = isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Admin';

// Récupérer les info du client par l'id
if (isset($_GET['id'])) {
    $id_reservation = $_GET['id'];
    $requete = " SELECT * FROM reservations 
                WHERE id_reservation=:id";
    $reqsql = $pdo->prepare($requete);
    $reqsql->bindParam(':id', $id_reservation, PDO::PARAM_INT);
    $reqsql->execute();
    $count = $reqsql->rowCount();
    if ($count == 1) {
        $resresa = $reqsql->fetch(PDO::FETCH_ASSOC);

        // Récupération des valeurs ENUM pour le status
        try {
            $reqsql = $pdo->query("SHOW COLUMNS FROM reservations LIKE 'status'");
            $row = $reqsql->fetch(PDO::FETCH_ASSOC);
            $enumValues = str_replace(
                array(
                    'enum',
                    '(',
                    ')',
                    '\''
                ),
                array(
                    '',
                    '',
                    '',
                    ''
                ),
                $row['Type']
            );
            $enumValues = explode(",", $enumValues);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des valeurs ENUM : " . $e->getMessage();
            // Gestion de l'erreur : on pourrait par exemple attribuer un tableau vide à $enumValues pour éviter une erreur plus bas.
            $enumValues = [];
        }

        // Détermine le service en fonction de l'heure
        $heure = date('H', strtotime($resresa['date_heure']));
        $service = ($heure >= 11 && $heure <= 14) ? 'midi' : 'soir';
?>

        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <title>Modification réservation</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <link rel="stylesheet" href="modulecss/listeclients.css">
        </head>

        <body class="bg-light">

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="#">Espace Admin</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <span class="navbar-text me-3 text-white">Bienvenue, <?php echo htmlspecialchars($_SESSION['login']); ?></span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-danger" href="viyaneadmin/logout.php">Se déconnecter</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h1 class="mb-0">Modification réservation</h1>
                            </div>
                            <div class="card-body">
                                <form action="traitement_modif_reservations.php" method="post">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d', strtotime($resresa['date_heure'])); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="service" class="form-label">Service <span class="text-danger">*</span></label>
                                        <select class="form-select" name="service" id="service" aria-label="Service" required>
                                            <option value="" disabled>Choisissez un service</option>
                                            <option value="midi" <?php echo ($service == 'midi') ? 'selected' : ''; ?>>Midi (11h30 - 14h30)</option>
                                            <option value="soir" <?php echo ($service == 'soir') ? 'selected' : ''; ?>>Soir (18h30 - 22h00)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombre_personnes" class="form-label">Nb. de pers.</label>
                                        <input type="number" class="form-control" id="nombre_personnes" name="nombre_personnes" value="<?php echo $resresa['nombre_personnes']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="commentaires" class="form-label">Commentaires</label>
                                        <textarea class="form-control" id="commentaires" name="commentaires" rows="3"><?php echo $resresa['commentaires']; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <?php foreach ($enumValues as $value): ?>
                                                <option value="<?php echo $value; ?>" <?php echo ($value == $resresa['status']) ? 'selected' : ""; ?>><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="idr" value="<?php echo $resresa['id_reservation']; ?>">
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" name="valid" class="btn btn-primary">Confirmer</button>
                                        <a class="btn btn-secondary" href="listereservations.php"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>

        </html>
<?php
    }
}
?>