<?php
session_start(); // Important pour la gestion des erreurs et confirmations

// Inclure le fichier de configuration (assurez-vous que le chemin est correct)
include('config.php');

// Fonction pour échapper les données (sécurité XSS) - Toujours utiliser une fonction pour cela!
function escape($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['valid'])) {

    // 1. Récupération des données du formulaire (avec isset et trim)
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
    $date = isset($_POST['date']) ? $_POST['date'] : ''; // On garde la date du formulaire
    $service = isset($_POST['service']) ? $_POST['service'] : '';
    $nombre_personnes = isset($_POST['nombre_personnes']) ? (int)$_POST['nombre_personnes'] : 0;  // Conversion en entier
    $commentaires = isset($_POST['commentaires']) ? trim($_POST['commentaires']) : '';


    // 2. Validation des données (crucial pour la sécurité et l'intégrité des données)
    $errors = [];

    // Validation du nom
    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire.";
    }

    // Validation du prénom
    if (empty($prenom)) {
        $errors[] = "Le prénom est obligatoire.";
    }

    // Validation de l'email
    if (empty($email)) {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }

    // Validation du téléphone (format français simple)
    if (empty($telephone)) {
        $errors[] = "Le téléphone est obligatoire.";
    } elseif (!preg_match("/^[0-9]{10}$/", $telephone)) {
        $errors[] = "Le numéro de téléphone doit contenir 10 chiffres.";
    }

    // Validation de la date (on s'assure qu'elle est présente et au bon format)
    if (empty($date)) {
        $errors[] = "La date est obligatoire.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $date)) {
        $errors[] = "La date n'est pas valide.";
    }


    // Validation du service
    if (empty($service) || ($service != 'midi' && $service != 'soir')) {
        $errors[] = "Le service est invalide.";
    }

    // Validation du nombre de personnes
    if ($nombre_personnes <= 0 || $nombre_personnes > 20) { // Mettez votre propre limite max
        $errors[] = "Le nombre de personnes doit être compris entre 1 et 20.";
    }

    // S'il y a des erreurs, on les stocke en session et on redirige vers le formulaire
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST; // Conserve les données saisies pour réaffichage
        header("Location: reservation.php");  // Redirection vers le formulaire
        exit();
    }

    // 3. Préparation de la date et de l'heure pour l'insertion
    if ($service == 'midi') {
        $heure = '11:30:00';  // Ou l'heure de début de votre service du midi
    } else {
        $heure = '18:30:00';  // Ou l'heure de début de votre service du soir
    }

    $date_heure = $date . ' ' . $heure;

    // 4. Connexion à la base de données (à l'intérieur du if(isset), car inutile si le formulaire n'est pas soumis)
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Important pour la sécurité avec les requêtes préparées
    } catch (PDOException $e) {
        $_SESSION['errors'] = ["Erreur de connexion à la base de données."];
        error_log("Erreur de connexion PDO : " . $e->getMessage()); // Enregistrez l'erreur complète
        header("Location: reservation.php");
        exit();
    }


    // 5.  Logique d'insertion (avec gestion du client existant ou nouveau)
    try {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id_client 
                                FROM clients 
                                WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Le client existe déjà -> récupérer son ID
            $client = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_client = $client['id_client'];

            // Insertion de la réservation
            $stmt = $pdo->prepare("
                INSERT INTO reservations (id_client, date_heure, nombre_personnes, commentaires, status)
                VALUES (:id_client, :date_heure, :nombre_personnes, :commentaires, :status)
            ");

            $status = 'Attente'; // Valeur par défaut
            $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
            $stmt->bindParam(':date_heure', $date_heure);
            $stmt->bindParam(':nombre_personnes', $nombre_personnes, PDO::PARAM_INT);
            $stmt->bindParam(':commentaires', $commentaires);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        } else {
            // Le client n'existe pas -> insertion du client
            $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, email, telephone) VALUES (:nom, :prenom, :email, :telephone)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->execute();

            $id_client = $pdo->lastInsertId(); // Récupérer l'ID du client inséré

            // Insertion de la réservation
            $stmt = $pdo->prepare("
                INSERT INTO reservations (id_client, date_heure, nombre_personnes, commentaires, status)
                VALUES (:id_client, :date_heure, :nombre_personnes, :commentaires, :status)
            ");
            $status = 'Attente'; // Valeur par défaut
            $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
            $stmt->bindParam(':date_heure', $date_heure);
            $stmt->bindParam(':nombre_personnes', $nombre_personnes, PDO::PARAM_INT);
            $stmt->bindParam(':commentaires', $commentaires);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        }

        // 6. Succès:  Redirection et message de confirmation
        unset($_SESSION['old_data']); // Vider les données du formulaire
        $_SESSION['success'] = "Votre réservation a été enregistrée avec succès. Nous vous contacterons prochainement pour la confirmer.";
        header("Location: ../index.php"); // Redirige vers la page du formulaire
        exit();
    } catch (PDOException $e) {
        // 7. Gestion des erreurs (doublons, problèmes de base de données, etc.)
        $_SESSION['errors'] = ["Une erreur est survenue lors de l'enregistrement de votre réservation. Veuillez réessayer."];
        error_log("Erreur PDO : " . $e->getMessage()); // Enregistrez l'erreur complète
        header("Location: ../reservation.php");
        exit();
    }
} else {
    header("Location: ../reservation.php"); // Redirection en cas d'accès direct au fichier
    exit();
}
