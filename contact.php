<?php 
$title = "Contact - Viyane";
$description = "Contactez-nous pour toute question ou réservation. Retrouvez nos coordonnées et horaires d'ouverture.";
include("header.php"); 
?>

<div class="hero">
    <h1 class="hero__title">Retrouvez-nous !</h1>
    <img class="hero__image" src="assets/image/imageWebp/4.webp" alt="Photo d'un plat">
</div>

<section class="contact__container">

    <div class="contact__info">
        <address>
            <p>15 Rue Saint Nicolas - 90100 Delle</p>
            <p>Téléphone : <a href="tel:+33384190911" aria-label="Numéro de téléphone">+33 3 84 19 09 11</a></p>
        </address>
        <div class="contact__info__center">
            <p>Déjeuner : 11h30 - 14h30</p>
            <p>Dîner : 18h30 - 22h00</p>
        </div>
        <div>
            <p>Fermé le dimanche et le lundi soir</p>
        </div>
    </div>
    <div class="contact__form__container">
        <div class="contact__content">
            <div class="contact__maps">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5390.111499124419!2d6.99978237587987!3d47.50830549476085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47921e5307a38387%3A0x55cbd3487ce3d263!2sRestaurant%20Viyane!5e0!3m2!1sfr!2sfr!4v1734689815605!5m2!1sfr!2sfr"
                    style="border:0;" allowfullscreen="true" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>


        <div class="contact__form">
            <h2 id="form-title">Contactez-nous !</h2>
            <p>Chez Viyane, nous vous accueillons à bras ouverts et avec une table remplie de délicieuses
                spécialités turques, grecques et kurdes. Une question ? Une envie particulière ?
                Contactez-nous !</p>

            <form class="contact_formulaire" action="moduleresa/traitement_formulaire.php" method="post" aria-labelledby="form-title">
                <fieldset class="contact_container">
                    <div class="name_fields">
                        <div class="form__top">
                            <input type="text" id="prenom" name="prenom" required placeholder="Prénom">
                            <input type="text" id="nom" name="nom" required placeholder="Nom">
                        </div>
                        <div class="form__mid">
                            <input type="email" id="email" name="email" placeholder="exemple@gmail.com" required>
                            <input type="tel" id="telephone" name="telephone" pattern="[0-9]{10}" placeholder="0123456789" required>
                        </div>
                        <div class="form__bottom">
                            <textarea id="message" name="message" rows="4" cols="50" required placeholder="Message"></textarea>
                        </div>
                        <div class="form__bot">
                            <button type="submit">Envoyer</button>
                        </div>
                    </div>
                </fieldset>
            </form>
            
        </div>
    </div>
</section>

<?php include("footer.php"); ?>