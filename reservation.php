<?php
session_start(); 
include("header.php");

// Fonction pour échapper les données (sécurité XSS)
function escape($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>

<div class="container reservation-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">Réservation</h1>
                </div>
                <div class="card-body">
                    <p class="intro-paragraph">
                        Réservez votre table dès maintenant et préparez-vous à un voyage culinaire inoubliable !
                    </p>

                    <?php if (isset($_SESSION['errors'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <li><?php echo escape($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION['errors']); ?> <?php endif; ?>

                    <form action="moduleresa/traitement_reservation.php" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="nom" id="nom" class="form-control" value="<?php echo isset($_SESSION['old_data']['nom']) ? escape($_SESSION['old_data']['nom']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" name="prenom" id="prenom" class="form-control" value="<?php echo isset($_SESSION['old_data']['prenom']) ? escape($_SESSION['old_data']['prenom']) : ''; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="exemple@gmail.com" value="<?php echo isset($_SESSION['old_data']['email']) ? escape($_SESSION['old_data']['email']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="06 xx xx xx xx" pattern="[0-9]{10}" title="Veuillez entrer un numéro de téléphone valide à 10 chiffres" value="<?php echo isset($_SESSION['old_data']['telephone']) ? escape($_SESSION['old_data']['telephone']) : ''; ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" id="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_SESSION['old_data']['date']) ? escape($_SESSION['old_data']['date']) : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="service" class="form-label">Service <span class="text-danger">*</span></label>
                                <select class="form-select" name="service" id="service" required>
                                    <option value="" disabled <?php echo !isset($_SESSION['old_data']['service']) ? 'selected' : ''; ?>>Choisissez un service</option>
                                    <option value="midi" <?php echo (isset($_SESSION['old_data']['service']) && $_SESSION['old_data']['service'] == 'midi') ? 'selected' : ''; ?>>Midi (11h30 - 14h30)</option>
                                    <option value="soir" <?php echo (isset($_SESSION['old_data']['service']) && $_SESSION['old_data']['service'] == 'soir') ? 'selected' : ''; ?>>Soir (18h30 - 22h00)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre_personnes" class="form-label">Nombre de personnes <span class="text-danger">*</span></label>
                                <input type="number" name="nombre_personnes" id="nombre_personnes" class="form-control" min="1" max="20" value="<?php echo isset($_SESSION['old_data']['nombre_personnes']) ? escape($_SESSION['old_data']['nombre_personnes']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-12 mb-3">
                                <label for="commentaires" class="form-label">Commentaires</label>
                                <textarea name="commentaires" id="commentaires" class="form-control" rows="3"><?php echo isset($_SESSION['old_data']['commentaires']) ? escape($_SESSION['old_data']['commentaires']) : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="valid" class="btn btn-reserve">Réserver</button>
                        </div>
                        <small class="text-danger">* Champs obligatoires</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>