<?php
session_start();
include("config.php");

if (!auth::islogged()) {
    header('Location: admin.php'); // Redirect to login
    exit();
}

$admin_name = isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Admin';

// --- Pagination Variables ---
$items_per_page = 10; // Number of clients to display per page. Change this as needed.
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page, default to 1
$current_page = max(1, $current_page); // Ensure page is at least 1.
$offset = ($current_page - 1) * $items_per_page;

// --- Search Functionality ---
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// --- Total Number of Clients (for pagination) ---
try {
    $total_clients_stmt = $pdo->prepare("SELECT COUNT(*) FROM clients WHERE nom LIKE :search OR prenom LIKE :search");
    $total_clients_stmt->execute([':search' => "%$search%"]);
    $total_clients = $total_clients_stmt->fetchColumn(); // Fetch the count
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error counting clients: " . htmlspecialchars($e->getMessage()) . "</div>";
    error_log("PDO Error (counting clients): " . $e->getMessage());
    $total_clients = 0;
}

// --- Fetch Clients (with LIMIT, OFFSET, and SEARCH) ---
try {
    $reqsql = $pdo->prepare("SELECT * FROM clients WHERE nom LIKE :search OR prenom LIKE :search ORDER BY nom, prenom LIMIT :limit OFFSET :offset");
    $reqsql->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $reqsql->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $reqsql->bindValue(':offset', $offset, PDO::PARAM_INT);
    $reqsql->execute();
    $clients = $reqsql->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Erreur lors de la récupération des clients : " . htmlspecialchars($e->getMessage()) . "</div>";
    error_log("PDO Error (fetching clients): " . $e->getMessage());
    $clients = []; // Set to empty array on error.
}

// --- Deletion Logic (Corrected and Improved) ---
if (isset($_POST['btn_spr']) && isset($_POST['id_cli']) && is_array($_POST['id_cli'])) {
    $ids_a_supprimer = $_POST['id_cli'];
    $placeholders = implode(',', array_fill(0, count($ids_a_supprimer), '?'));

    $sql_suppression = "DELETE FROM clients WHERE id_client IN ($placeholders)";
    $stmt_suppression = $pdo->prepare($sql_suppression);

    // Bind parameters correctly *inside* the loop
    foreach ($ids_a_supprimer as $index => $id) {
        $stmt_suppression->bindValue($index + 1, $id, PDO::PARAM_INT); // +1 because bindValue starts at 1
    }

    try {
        $stmt_suppression->execute();
        echo "<div class='alert alert-success'>Client(s) supprimé(s) avec succès.</div>";
        header("Location: listeclients.php"); // Redirect *after* successful deletion.
        exit();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression : " . htmlspecialchars($e->getMessage()) . "</div>";
        error_log("PDO Error (client deletion): " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Liste des Clients</title>
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
                        <span class="welcome-message">Bienvenue, <?php echo $admin_name; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-action" href="viyaneadmin/logout.php">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Liste des Clients</h1>
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
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Action</th>
                                    <th>Sélection</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clients as $client) : ?>
                                    <tr>
                                        <td><?php echo $client['id_client']; ?></td>
                                        <td><?php echo htmlspecialchars($client['nom']); ?></td>
                                        <td><?php echo htmlspecialchars($client['prenom']); ?></td>
                                        <td><?php echo htmlspecialchars($client['email']); ?></td>
                                        <td><?php echo htmlspecialchars($client['telephone']); ?></td>
                                        <td>
                                            <a class='btn btn-primary btn-action' href='modif_clients.php?id=<?php echo $client['id_client']; ?>'>
                                                <i class="fas fa-edit"></i> Modifier
                                            </a>
                                        </td>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="id_cli[]" value="<?php echo $client['id_client']; ?>">
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
                        <a href="ajout_client.php" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Ajouter</a>
                        <button type="submit" name="btn_spr" class="btn btn-danger btn-action" onclick="return confirm('Êtes-vous sûr de vouloir supprimer les clients sélectionnés ?');">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </div>

                </form>
            </div>
        </div>
        <?php if ($total_clients > 0): ?>
            <nav aria-label="Page navigation" class="mt-3">
                <ul class="pagination">
                    <?php
                    $total_pages = ceil($total_clients / $items_per_page);

                    // Previous page link
                    if ($current_page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '&search=' . $search . '">Précédent</a></li>';
                    }

                    // Page links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo '<li class="page-item' . ($i == $current_page ? ' active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . $search . '">' . $i . '</a></li>';
                    }

                    // Next page link
                    if ($current_page < $total_pages) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '&search=' . $search . '">Suivant</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>