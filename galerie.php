<?php
$title = "Galerie - Viyane";
$description = "Découvrez notre galerie et laissez-vous séduire par les images de notre restaurant et de nos plats délicieux.";
include("header.php");
?>

<div class="hero" aria-label="Section hero avec titre et image de la galerie">
    <h1 class="hero__title" aria-level="1">Galerie</h1>
    <img class="hero__image" src="assets/image/imageWebp/galerie.webp" alt="Photo plats">
</div>

<div class="hero__content" aria-label="Description et boutons d'action">
    <p class="hero__description">Un avant-goût de Viyane : parcourez notre galerie et laissez vos sens s'éveiller aux délices de notre cuisine méditerranéenne et kurde.</p>
    <div class="hero__buttons">
        <a href="reservation.php" class="hero__button" aria-label="Bouton pour réserver une table">Réservez une table</a>
        <a href="menu.php" class="hero__button" aria-label="Bouton pour découvrir le menu">Découvrez notre menu</a>
    </div>
</div>

<div class="gallery" aria-label="Section galerie avec photos du restaurant et des plats">
    <div class="gallery__head">
        <img src="assets/image/ambiance/Calque_1-2.svg" alt="decoration" aria-hidden="true">
        <h2 id="section-title" aria-level="2">Restaurant</h2>
        <img src="assets/image/ambiance/Calque_1-2.svg" alt="decoration" aria-hidden="true">
    </div>
    <div>
        <div class="main-carousel" aria-label="Carrousel d'images du restaurant">
            <div class="carousel-cell"> <img src="assets/image/imageWebp/viyane1.webp" alt="Restaurant Image 1" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/imageWebp/viyane2.webp" alt="Restaurant Image 2" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/imageWebp/viyane3.webp" alt="Restaurant Image 3" loading="lazy"></div>
            <div class="carousel-cell"><img src="assets/image/imageWebp/viyane4.webp" alt="Restaurant Image 4" loading="lazy"></div>
        </div>
    </div>

    <div class="gallery__head">
        <img src="assets/image/ambiance/Calque_1-2.svg" alt="decoration" aria-hidden="true">
        <h2 id="section-title" aria-level="2">Nos Plats</h2>
        <img src="assets/image/ambiance/Calque_1-2.svg" alt="decoration" aria-hidden="true">
    </div>
    <div>
        <div class="second-carousel" aria-label="Carrousel d'images des plats">
            <div class="carousel-cell"> <img src="assets/image/imageWebp/1.webp" alt="Dish Image 1" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/imageWebp/2.webp" alt="Dish Image 2" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/imageWebp/3.webp" alt="Dish Image 3" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/imageWebp/4.webp" alt="Dish Image 4" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/imageWebp/5.webp" alt="Dish Image 5" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/imageWebp/6.webp" alt="Dish Image 6" loading="lazy"></div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>