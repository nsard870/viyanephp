<?php
include("config.php"); // Your database connection

$requete = "SELECT id_admin, mdp FROM admin"; // Fetch users with old hashes
$reqsql = $pdo->prepare($requete);
$reqsql->execute();
$users = $reqsql->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $new_hash = password_hash($user['mdp'], PASSWORD_DEFAULT); // Hash with bcrypt
    $update_query = "UPDATE admin SET mdp = :new_hash WHERE id_admin = :id";
    $update_statement = $pdo->prepare($update_query);
    $update_statement->execute([':new_hash' => $new_hash, ':id' => $user['id_admin']]);
}

echo "Passwords updated successfully!";
?>