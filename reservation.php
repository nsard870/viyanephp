<?php include("header.php"); ?>

<div class="resa__container">
    <div class="container m-auto ">
        <div class="row justify-content-center ">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header" style="background-color: #990000; color: #F5F5DC;">
                        <h1 class="mb-0">Réservation</h1>
                    </div>
                    <div class="card-body">
                        <form action="traitement_</div>reservation.php" method="post">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom:</label>
                                <input type="text" name="nom" id="nom" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom:</label>
                                <input type="text" name="prenom" id="prenom" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="exemple@gmail.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone:</label>
                                <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="06 xx xx xx xx" required>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date:</label>
                                <input type="date" name="date" id="date" class="form-control" required min="<?php echo date('Y-m-d');?>">
                            </div>

                            <div class="mb-3">
                                <label for="service" class="form-label">Service:</label>
                                <select class="form-select" name="service" id="service" required>
                                    <option value="">Choisissez un service</option>
                                    <option value="midi">Midi (11h30 - 14h30)</option>
                                    <option value="soir">Soir (18h30 - 22h00)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nombre_personnes" class="form-label">Nombre de personnes:</label>
                                <input type="number" name="nombre_personnes" id="nombre_personnes" class="form-control"
                                    min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="commentaires" class="form-label">Commentaires:</label>
                                <textarea name="commentaires" id="commentaires" class="form-control"></textarea>
                            </div>

                            <div class="d-grid gap-2 resa__btn">
                                <button type="submit" name="valid" class="btn"
                                    style="background-color: #D4AF37; color: var(--color-white); font-weight: bold;">Réserver</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php"); ?>