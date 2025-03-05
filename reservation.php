<?php
session_start();
$title = "Réservation - Viyane";
$description = "Réservez votre table dès maintenant et préparez-vous à un voyage culinaire inoubliable chez Viyane, où la cuisine turque, grecque et kurde vous attend.";
include("header.php");

// Fonction pour échapper les données (sécurité XSS)
function escape($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>

<div class="hero">
    <h1 class="hero__title">Réservation</h1>
    <img class="hero__image" src="assets/image/imageWebp/6.webp" alt="Photo d'un plat">
</div>

<div class="hero__content">
    <p class="hero__description">Réservez votre table dès maintenant et préparez-vous à un voyage culinaire inoubliable !</p>
</div>

<div class="container reservation-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-menu">
                <div class="card-body">
                    <?php if (isset($_SESSION['errors'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <li><?php echo escape($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION['errors']); ?> 
                    <?php endif; ?>

                    <form action="moduleresa/traitement_reservation.php" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="nom" id="nom" class="form-control" aria-label="Nom" value="<?php echo isset($_SESSION['old_data']['nom']) ? escape($_SESSION['old_data']['nom']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" name="prenom" id="prenom" class="form-control" aria-label="Prénom" value="<?php echo isset($_SESSION['old_data']['prenom']) ? escape($_SESSION['old_data']['prenom']) : ''; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" aria-label="Email" placeholder="exemple@gmail.com" value="<?php echo isset($_SESSION['old_data']['email']) ? escape($_SESSION['old_data']['email']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" name="telephone" id="telephone" class="form-control" aria-label="Téléphone" placeholder="06xxxxxxxx" pattern="[0-9]{10}" title="Veuillez entrer un numéro de téléphone valide à 10 chiffres" value="<?php echo isset($_SESSION['old_data']['telephone']) ? escape($_SESSION['old_data']['telephone']) : ''; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" id="date" class="form-control" aria-label="Date" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_SESSION['old_data']['date']) ? escape($_SESSION['old_data']['date']) : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="service" class="form-label">Service <span class="text-danger">*</span></label>
                                <select class="form-select" name="service" id="service" aria-label="Service" required>
                                    <option value="" disabled <?php echo !isset($_SESSION['old_data']['service']) ? 'selected' : ''; ?>>Choisissez un service</option>
                                    <option value="midi" <?php echo (isset($_SESSION['old_data']['service']) && $_SESSION['old_data']['service'] == 'midi') ? 'selected' : ''; ?>>Midi (11h30 - 14h30)</option>
                                    <option value="soir" <?php echo (isset($_SESSION['old_data']['service']) && $_SESSION['old_data']['service'] == 'soir') ? 'selected' : ''; ?>>Soir (18h30 - 22h00)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre_personnes" class="form-label">Nombre de personnes <span class="text-danger">*</span></label>
                                <input type="number" name="nombre_personnes" id="nombre_personnes" class="form-control" aria-label="Nombre de personnes" min="1" max="20" value="<?php echo isset($_SESSION['old_data']['nombre_personnes']) ? escape($_SESSION['old_data']['nombre_personnes']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-12 mb-3">
                                <label for="commentaires" class="form-label">Commentaires</label>
                                <textarea name="commentaires" id="commentaires" class="form-control" aria-label="Commentaires" rows="3"><?php echo isset($_SESSION['old_data']['commentaires']) ? escape($_SESSION['old_data']['commentaires']) : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" name="valid" class="btn btn-reserve" aria-label="Réserver">Réserver</button>
                        </div>
                        <small class="text-danger">* Champs obligatoires</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
