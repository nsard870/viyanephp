<?php
session_start();
include("config.php");
if (!auth::islogged()) {
    header('location:admin.php');
    die();
}


// traitement update ICI
// if (isset($_POST['valid'])) {
//     include '';
// }

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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modification réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
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
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo $resresa['date'];?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="heure" class="form-label">Horaire</label>
                                <input type="time" class="form-control" id="heure" name="heure" value="<?php echo $resresa['heure'];?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre_personnes" class="form-label">Nb. de pers.</label>
                                <input type="number" class="form-control" id="nombre_personnes" name="nombre_personnes" value="<?php echo $resresa['nombre_personnes'];?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="commentaires" class="form-label">Commentaires</label>
                                <textarea class="form-control" id="commentaires" name="commentaires" rows="3"><?php echo $resresa['commentaires'];?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <?php foreach ($enumValues as $value):?>
                                        <option value="<?php echo $value;?>" <?php echo ($value == $resresa['status'])? 'selected': "";?>><?php echo $value;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <input type="hidden" name="idr" value="<?php echo $resresa['id_reservation'];?>">
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