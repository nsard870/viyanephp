<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $message = $_POST["message"];

    $to = "sardinicolas@hotmail.fr"; 
    $subject = "Nouveau message du formulaire de contact Viyane";
    $body = "Nom: $nom\n";
    $body .= "Prénom: $prenom\n";
    $body .= "Email: $email\n";
    $body .= "Téléphone: $telephone\n\n";
    $body .= "Message:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "Merci pour votre message ! Nous vous contacterons sous peu.";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
