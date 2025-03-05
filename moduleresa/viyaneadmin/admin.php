<?php
session_start();
include("../config.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Espace Gestion</title>
    <link rel="stylesheet" href="../modulecss/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Connexion Espace Gestion</h2>
            </div>
            <div class="card-body">
                <form method="post" action="login.php">
                    <div class="mb-3">
                        <label for="login" class="form-label">Identifiant</label>
                        <input type="text" name="login" id="login" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de Passe</label>
                        <div class="input-group"> <input type="password" name="mdp" id="mdp" class="form-control" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="valid" class="btn btn-danger">Connexion</button>
                    </div>
                </form>

                <div class="d-grid gap-2 mt-3">
                    <a href="../../index.php" class="btn btn-secondary">Retour à l'accueil</a>
                </div>

                <?php if (isset($_GET['err']) && 1 == $_GET['err']) { ?>
                    <div class="alert alert-danger mt-3">
                        Le pseudo/mot de passe est incorrect.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</body>

</html>