<?php
session_start();
include("config.php");
if (!auth::islogged()) {
    header('location:admin.php');
    die();
}

$admin_name = $_SESSION['login'];

// Traitement formulaire ajout client
if (isset($_POST['valid'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    // Vérification champs vides
    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($telephone)) {
        $reqajout = 'INSERT INTO clients (nom,prenom,email,telephone) values (:nom, :prenom, :email, :telephone)';
        $reqsql = $pdo->prepare($reqajout);
        $reqsql->bindParam(':nom', $nom, PDO::PARAM_STR);
        $reqsql->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $reqsql->bindParam(':email', $email, PDO::PARAM_STR);
        $reqsql->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $reqsql->execute();
    }
    // Redirection post traitement
    header('Location: listeclients.php');
    exit;
}

?>

<head>
    <title>Ajout d'un client</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        <a class="nav-link btn btn-danger" href="logout.php">Se déconnecter</a>
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
                        <h1 class="mb-0">Ajouter un client</h1>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="nom" required>
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" name="prenom" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Numéro de téléphone</label>
                                <input type="tel" class="form-control" name="telephone" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-secondary" href="listeclients.php"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
                                <button type="submit" name="valid" class="btn btn-primary">Confirmer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>