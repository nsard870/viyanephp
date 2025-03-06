<?php
session_start();
include("config.php");

// Verifier si l'utilisateur est connecté
if (!auth::islogged()) {
    header('location:admin.php');
    exit();
}

// Récupérer le nom de l'admin
$admin_name = isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Admin';

// Récupérer les données du client par l'ID
if (isset($_GET['id'])) {
    $id_client = $_GET['id'];
    $requete = "SELECT * FROM clients 
                WHERE id_client =:id";
    $reqsql = $pdo->prepare($requete);
    $reqsql->bindParam(':id', $id_client, PDO::PARAM_INT);
    $reqsql->execute();
    $resclient = $reqsql->fetch(PDO::FETCH_ASSOC);

    if ($resclient) { ?>

        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <title>Modification client</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                                <h1 class="mb-0">Modification client</h1>
                            </div>
                            <div class="card-body">
                                <form action="traitement_modif_clients.php" method="post">
                                    <div class="mb-3">
                                        <label for="nom" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($resclient['nom']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prenom" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($resclient['prenom']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($resclient['email']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                                        <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($resclient['telephone']); ?>" required>
                                    </div>
                                    <input type="hidden" name="idc" value="<?php echo $resclient['id_client']; ?>">
                                    <div class="d-flex justify-content-between"> <button type="submit" name="valid" class="btn btn-primary">Confirmer</button>
                                        <a class="btn btn-secondary" href="listeclients.php"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
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
    } else {
        echo "Client non trouvé.";
    }
} else {
    echo "ID client manquant.";
} ?>