// Flkity Carousel
var flkty = new Flickity('.main-carousel', {
    cellAlign: 'left',
    contain: true,
    wrapAround: true,
    autoPlay: 5000,
    pauseAutoPlayOnHover: true,
    prevNextButtons: true,
    pageDots: true,
    imagesLoaded: true,
});

var flkty = new Flickity('.second-carousel', {
    cellAlign: 'left',
    contain: true,
    wrapAround: true,
    autoPlay: 5000,
    pauseAutoPlayOnHover: true,
    prevNextButtons: true,
    pageDots: true,
    imagesLoaded: true,
});

// headroom
// AFFICHAGE DU MENU POUR LE MOBILE

const hamburger = document.querySelector(".menuBurger");
const menu = document.querySelector(".menu");
const page = document.body;

if (hamburger && menu) {
    hamburger.addEventListener("click", () => {
        const isOpen = hamburger.ariaExpanded === "true";
        const isClosed = !isOpen;

        hamburger.ariaExpanded = isClosed;
        hamburger.classList.toggle("menuBurger--open", isClosed);
        menu.ariaHidden = isOpen;
        menu.classList.toggle("menu--open", isClosed);
        page.classList.toggle("noscroll", isClosed);
    });
}
// PARAMETRAGE POUR LE HEADER AVEC HEADROOM
const navBar = document.querySelector(".headroom");
if (navBar) {
    const headroom = new Headroom(navBar, {
        offset: 200,
    });
    headroom.init();
}


// Flèche pour remonter sur le haut de page 
window.addEventListener('scroll', function () {
    var scrollToTop = document.getElementById('scrollToTop');
    if (window.pageYOffset > 100) { 
        /* Affiche la flèche après 100px de scroll */
        scrollToTop.style.display = 'block';
    } else {
        scrollToTop.style.display = 'none';
    }
});

// Animation de scroll au clic
document.getElementById('scrollToTop').addEventListener('click', function (e) {
    e.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth' /* Animation de scroll */
    });
});