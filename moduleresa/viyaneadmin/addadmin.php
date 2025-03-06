<?php
session_start();
include("../config.php");

// Vérifier si l'utilisateur est connecté
if (!auth::islogged()) {
    header('location:admin.php');
    exit();
}

// Récupérer le nom de l'admin
$admin_name = isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Admin';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    // Hash le mot de passe
    $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);

    // Inserer le nouvel admin dans la base de données
    $insert_query = "INSERT INTO admin (login, mdp) 
                        VALUES (:login, :mdp)";
    $insert_statement = $pdo->prepare($insert_query);
    $insert_statement->execute([':login' => $login, ':mdp' => $hash_mdp]);

    echo "<div class='alert alert-success' role='alert'>Le nouvel admin a été ajouté avec succès !</div>"; // Afficher un message de confirmation
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add New Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../modulecss/listeclients.css">
</head>

<body>

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
                        <a class="nav-link btn btn-danger" href="logout.php">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 w-50">
        <div class="card">
            <div class="card-header">
                <h2>Ajouter un nouvel admin</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Login :</label>
                        <input type="text" class="form-control" name="login" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="mdp" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter l'admin</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>