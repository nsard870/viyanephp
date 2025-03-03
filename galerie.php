<?php include("header.php"); ?>

<div class="hero">
    <h1 class="hero__title">Galerie</h1>
    <img class="hero__image" src="assets/image/galerie.jpg" alt="Photo plats">
</div>

<div class="hero__content">
    <p class="hero__description">Un avant-goût de Viyane : parcourez notre galerie et laissez vos sens s'éveiller aux délices de notre cuisine méditerranéenne et kurde.
    </p>
    <div class="hero__buttons">
        <a href="reservation.php" class="hero__button">Réservez une table</a>
        <a href="menu.php" class="hero__button">Découvrez notre menu</a>
    </div>
</div>

<div class="gallery">
    <div class="gallery__head">
        <img src="assets/image/ambiance/Calque_1-2.svg" alt="decoration">
        <h2 id="section-title">Restaurant</h2>
        <img src="assets/image/ambiance/Calque_1-2.svg" alt="decoration">
    </div>
    <div>
        <div class="main-carousel">
            <div class="carousel-cell"> <img src="assets/image/2021-09-20.jpg" alt="Restaurant Image 1" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/viyane_restaurant2.jpg" alt="Restaurant Image 2" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/viyane_restaurant7.jpg" alt="Restaurant Image 3" loading="lazy"></div>
            <div class="carousel-cell"><img src="assets/image/viyanne_photo3.jpg" alt="Restaurant Image 4" loading="lazy"></div>
        </div>
    </div>

    <div class="gallery__head">
        <img src="assets/image/ambiance/Calque_1-2.svg" alt="decoration">
        <h2 id="section-title">Nos Plats</h2>
        <img src="assets/image/ambiance/Calque_1-2.svg" alt="decoration">
    </div>
    <div>
        <div class="second-carousel">
            <div class="carousel-cell"> <img src="assets/image/galerie/1.png" alt="Dish Image 1" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/galerie/2.png" alt="Dish Image 2" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/galerie/3.png" alt="Dish Image 3" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/galerie/4.png" alt="Dish Image 4" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/galerie/5.png" alt="Dish Image 5" loading="lazy"></div>
            <div class="carousel-cell"> <img src="assets/image/galerie/6.png" alt="Dish Image 6" loading="lazy"></div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>