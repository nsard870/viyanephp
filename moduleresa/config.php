<?php

// Informations d'identification de la base de données
$host = "localhost";
$dbname = "module_resa";
$user = "root";
$password = "root";

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

class Auth
{
    private static $pdo; // Propriété statique pour stocker la connexion PDO

    // Fonction statique pour configurer la connexion PDO
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }
    
    // Fonction statique pour vérifier si l'utilisateur est connecté
    public static function isLogged()
    {
        if (isset($_SESSION['mdp']) && isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            $password = $_SESSION['mdp'];

            $reqadmin = "SELECT mdp 
                            FROM admin 
                            WHERE login = :login"; // Sélectionner uniquement ce dont vous avez besoin !
            $reqsql = self::$pdo->prepare($reqadmin);
            $reqsql->bindParam(':login', $login, PDO::PARAM_STR);
            $reqsql->execute();

            if ($row = $reqsql->fetch(PDO::FETCH_ASSOC)) { // Vérifier directement si une ligne a été récupérée
                $mdpstocke = $row['mdp'];
                if (password_verify($password, $mdpstocke)) {
                    return true;
                }
            }
            return false; // Retourner false si l'utilisateur n'est pas trouvé ou si le mot de passe ne correspond pas

        } else {
            return false;
        }
    }
}

// Configurer la connexion PDO
Auth::setPDO($pdo);

// Fonction pour envoyer un email de notification
function sendStatusChangeEmail($email, $status) {
    $subject = "Mise à jour de votre réservation";
    $message = "Bonjour,\n\nVotre réservation a été mise à jour avec le statut suivant : $status.\n\nMerci de votre confiance.\n\nCordialement,\nL'équipe Viyane";
    $headers = "From: no-reply@viyane.com";

    mail($email, $subject, $message, $headers);
}

?>
