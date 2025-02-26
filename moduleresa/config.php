<?php
// setlocale(LC_ALL, 'fr_FR');
// Database credentials - keep these separate and secure!  Consider using environment variables.
$host = "localhost";
$dbname = "module_resa";
$user = "root";
$password = "root";

// Establish database connection ONCE and store it.  This is a HUGE performance gain.
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection error: " . $e->getMessage());
}

class Auth
{
    private static $pdo; // Store the PDO connection within the class

    // Inject the PDO connection into the class (Dependency Injection is good practice)
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public static function isLogged()
    {
        if (isset($_SESSION['mdp']) && isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            $password = $_SESSION['mdp'];


            $reqadmin = "SELECT mdp FROM admin WHERE login = :login"; // Only select what you need!
            $reqsql = self::$pdo->prepare($reqadmin);
            $reqsql->bindParam(':login', $login, PDO::PARAM_STR);
            $reqsql->execute();

            if ($row = $reqsql->fetch(PDO::FETCH_ASSOC)) { // Directly check if a row was fetched
                $mdpstocke = $row['mdp'];
                if (password_verify($password, $mdpstocke)) {
                    return true;
                }
            }
            return false; // Return false if the user isn't found or password doesn't match


        } else {
            return false;
        }
    }
}

// Initialize the PDO connection for the Auth class.  Do this *after* creating the PDO object.
Auth::setPDO($pdo);

?>

