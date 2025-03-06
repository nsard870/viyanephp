<?php
session_start();

// Destruire la session
session_destroy();

// Rediriger vers la page de connexion
header('Location: admin.php');

// Fermer le script
exit();