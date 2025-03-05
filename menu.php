<?php 
$title = "Notre Menu - Viyane";
$description = "Explorez notre menu, un véritable voyage culinaire à travers la Turquie, la Grèce et le Kurdistan. Des mezzés savoureux aux grillades parfumées, chaque plat est une invitation à la découverte et au partage.";
include("header.php"); 
?>

<div class="hero">
    <h1 class="hero__title">Notre Menu</h1>
    <img class="hero__image" src="assets/image/galerie/1.png" alt="Photo plats">
</div>

<div class="hero__content">
    <p class="hero__description">Explorez notre menu, un véritable voyage culinaire à travers la Turquie, la Grèce et le Kurdistan. Des mezzés savoureux aux grillades parfumées, chaque plat est une invitation à la découverte et au partage.
    </p>
    <div class="hero__buttons">
        <a href="reservation.php" class="hero__button">Réservez une table</a>
    </div>
</div>

<div class="container">
    <div class="menu_restaurant">

        <div class="menu-group">
            <div class="menu-group__title" data-bs-toggle="collapse" data-bs-target="#menuCollapse">Menus</div>
            <div class="collapse" id="menuCollapse">
                <div class="card card-body">

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#menuDecouverteCollapse">
                            Menu Découverte</div>
                        <div class="collapse" id="menuDecouverteCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Cacik</span>
                                    <p class="menu-item__description">Yaourt au concombre</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Hunkar Begendi</span>
                                    <p class="menu-item__description">Agneau ou Poulet, purée d'aubergine, fromage, lait
                                    </p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Baklava</span>
                                    <p class="menu-item__description">Feuilleté aux noix, sirop de sucre, chantilly</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Thé ou Café</span>
                                    <span class="menu-item__price">24,50€</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse" data-bs-target="#menuEnfantCollapse">
                            Menu Enfant</div>
                        <div class="collapse" id="menuEnfantCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Menu Enfant</span>
                                    <span class="menu-item__price">7,90€</span>
                                    <p class="menu-item__description">Brochettes de poulet ou brochettes d'agneau,
                                        Crudités, Frites</p>
                                    <p class="menu-item__description">ou</p>
                                    <p class="menu-item__description">Pizza Bambino</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="menu-group">
            <div class="menu-group__title" data-bs-toggle="collapse" data-bs-target="#entreesCollapse">Entrées</div>
            <div class="collapse" id="entreesCollapse">
                <div class="card card-body">

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#entreesFroidesCollapse">
                            Entrées Froides</div>
                        <div class="collapse" id="entreesFroidesCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Cacik</span>
                                    <span class="menu-item__price">6,90€</span>
                                    <p class="menu-item__description">Yaourt au concombre</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Haydari</span>
                                    <span class="menu-item__price">6,80€</span>
                                    <p class="menu-item__description">Menthe, carottes, yaourt</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Humus</span>
                                    <span class="menu-item__price">6,90€</span>
                                    <p class="menu-item__description">Purée de pois chiches, tahin, huile d'olive</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Ezme</span>
                                    <span class="menu-item__price">7,30€</span>
                                    <p class="menu-item__description">Tartare de tomates, oignons, persil</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Patlican Tava</span>
                                    <span class="menu-item__price">7,90€</span>
                                    <p class="menu-item__description">Aubergines, poivrons, sauce tomate</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Karides</span>
                                    <span class="menu-item__price">8,10€</span>
                                    <p class="menu-item__description">Crevettes, poivrons, tomates</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Salade Verte</span>
                                    <span class="menu-item__price">4,90€</span>
                                    <p class="menu-item__description">Salade Verte, tomates</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Bostane Sivan</span>
                                    <span class="menu-item__price">7,90€</span>
                                    <p class="menu-item__description">Tomates, Concombres, Oignons, Persil, Fromage fêta
                                    </p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Rus Salatasi</span>
                                    <span class="menu-item__price">7,60€</span>
                                    <p class="menu-item__description">Pommes de terre, Carottes, Blanc d'oeuf,
                                        Cornichons, Petits pois, Mayonnaise</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Salade Thon</span>
                                    <span class="menu-item__price">Petite: 9,90€ | Grande: 12,90€</span>
                                    <p class="menu-item__description">Salade verte, thon, poivrons, oignons, olives,
                                        anchois</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#entreesChaudesCollapse">
                            Entrées Chaudes</div>
                        <div class="collapse" id="entreesChaudesCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Kasarli Mantar</span>
                                    <span class="menu-item__price">7,50€</span>
                                    <p class="menu-item__description">Champignons, Fromage / au four</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Borek</span>
                                    <span class="menu-item__price">7,70€</span>
                                    <p class="menu-item__description">Feuilletté au fromage et persil</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Mijwer</span>
                                    <span class="menu-item__price">7,60€</span>
                                    <p class="menu-item__description">Carottes, Courgettes, Menthe, Oeuf frits, Sauce
                                        blanche</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Kizartilmis Patates</span>
                                    <span class="menu-item__price">7,50€</span>
                                    <p class="menu-item__description">Pommes de terre, Oignons frits au fromage au four
                                    </p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Kalamar</span>
                                    <span class="menu-item__price">7,90€</span>
                                    <p class="menu-item__description">Beignets de Calamars au citron, salade</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#entreesAssortimentsCollapse">Entrées - Assortiments</div>
                        <div class="collapse" id="entreesAssortimentsCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Bostane Viyane (2 personnes)</span>
                                    <span class="menu-item__price">19,50€</span>
                                    <p class="menu-item__description">Composition d'entrées froides et chaudes</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Bostane Viyane (4 personnes)</span>
                                    <span class="menu-item__price">38,00€</span>
                                    <p class="menu-item__description">Composition d'entrées froides et chaudes</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Viyane</span>
                                    <span class="menu-item__price">10,90€</span>
                                    <p class="menu-item__description">Borek, mijwer, calamars (seul ou à partager)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu-group">
            <div class="menu-group__title" data-bs-toggle="collapse" data-bs-target="#platsCollapse">Plats</div>
            <div class="collapse" id="platsCollapse">
                <div class="card card-body">

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse" data-bs-target="#platsViandesCollapse">
                            Viandes</div>
                        <div class="collapse" id="platsViandesCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Agneau Grillé</span>
                                    <span class="menu-item__price">18,50€</span>
                                    <p class="menu-item__description">Agneau mariné aux épices, grillé</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Agneau Haché</span>
                                    <span class="menu-item__price">17,50€</span>
                                    <p class="menu-item__description">Agneau haché, grillé</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Brochettes Agneau</span>
                                    <span class="menu-item__price">16,90€</span>
                                    <p class="menu-item__description">Brochettes d'agneau mariné</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Brochettes Poulet</span>
                                    <span class="menu-item__price">15,90€</span>
                                    <p class="menu-item__description">Brochettes de poulet mariné</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Adana Kebap</span>
                                    <span class="menu-item__price">16,50€</span>
                                    <p class="menu-item__description">Viande d'agneau hachée, grillée sur brochette</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Iskender Kebap</span>
                                    <span class="menu-item__price">18,90€</span>
                                    <p class="menu-item__description">Pain pita, agneau, sauce tomate, yaourt</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Kuzu Tandir</span>
                                    <span class="menu-item__price">21,00€</span>
                                    <p class="menu-item__description">Agneau cuit lentement au four</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#platsPoissonsCollapse">
                            Poissons</div>
                        <div class="collapse" id="platsPoissonsCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Saumon</span>
                                    <span class="menu-item__price">19,50€</span>
                                    <p class="menu-item__description">Saumon grillé</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Dorade</span>
                                    <span class="menu-item__price">18,90€</span>
                                    <p class="menu-item__description">Dorade grillée</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Loup de Mer</span>
                                    <span class="menu-item__price">20,50€</span>
                                    <p class="menu-item__description">Loup de mer grillé</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#platsAccompagnementsCollapse">Accompagnements</div>
                        <div class="collapse" id="platsAccompagnementsCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Boulgour</span>
                                    <span class="menu-item__price">5,50€</span>
                                    <p class="menu-item__description">Boulgour cuisiné</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Riz</span>
                                    <span class="menu-item__price">5,00€</span>
                                    <p class="menu-item__description">Riz nature</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Frites</span>
                                    <span class="menu-item__price">4,50€</span>
                                    <p class="menu-item__description">Frites maison</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Crudités</span>
                                    <span class="menu-item__price">4,00€</span>
                                    <p class="menu-item__description">Salade de crudités</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu-group">
            <div class="menu-group__title" data-bs-toggle="collapse" data-bs-target="#pizzasCollapse">Pizzas</div>
            <div class="collapse" id="pizzasCollapse">
                <div class="card card-body">
                    <div class="menu-item">
                        <span class="menu-item__title">Margherita</span>
                        <span class="menu-item__price">13,30€</span>
                        <p class="menu-item__description">Tomate, Mozzarella</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Funghi</span>
                        <span class="menu-item__price">13,90€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Champignons</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Regina</span>
                        <span class="menu-item__price">14,20€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Epaule de porc, Champignons</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Bolonaise</span>
                        <span class="menu-item__price">13,90€</span>
                        <p class="menu-item__description">Tomate, Fromage, Oignons, Viande Hachée, Olive</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Hawaii</span>
                        <span class="menu-item__price">14,90€</span>
                        <p class="menu-item__description">Tomate, Ananas, Mozzarella, Epaule de porc</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Napolitaine</span>
                        <span class="menu-item__price">14,90€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Câpres, Olives, Anchois</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Orientale</span>
                        <span class="menu-item__price">14,30€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Merguez, Poivrons, Oignons, Olives</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Viyane</span>
                        <span class="menu-item__price">14,90€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Saucisson du pays, Poivrons, Oeuf</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Thon</span>
                        <span class="menu-item__price">14,90€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Câpres, Olives, Thon, Oignons</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Quatre Saisons</span>
                        <span class="menu-item__price">14,80€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Câpres, Fond d'Artichaut, Epaule de porc,
                            Champignons, Origan</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Végétarienne</span>
                        <span class="menu-item__price">14,90€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Champignons, Poivrons, Fond d'Artichaut,
                            Oignons</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Fruit de Mer</span>
                        <span class="menu-item__price">15,90€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Moules, Crevettes, Calamars</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Fromagère</span>
                        <span class="menu-item__price">14,80€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Fromage de chèvre, Fromage blanc</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Paysanne</span>
                        <span class="menu-item__price">15,70€</span>
                        <p class="menu-item__description">Tomate, Mozzarella, Oignons, Epaule, Pommes de terre,
                            Champignons</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Reine</span>
                        <span class="menu-item__price">13,90€</span>
                        <p class="menu-item__description">Crème fraiche, Mozzarella, Oeufs, Jambon, Oignons</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Pide Epinard / Nouveau</span>
                        <span class="menu-item__price">13,90€</span>
                        <p class="menu-item__description">Mozzarella, Epinard, Oignons, Oeuf</p>
                    </div>
                    <div class="menu-item">
                        <span class="menu-item__title">Pide Poulet / Nouveau</span>
                        <span class="menu-item__price">14,90€</span>
                        <p class="menu-item__description">Crème fraîche, Poulet, Oeuf, Poivrons</p>
                    </div>
                    <p class="menu-item__description"><strong>Nos Pizzas à emporter sont à 10 €</strong></p>
                </div>
            </div>
        </div>

        <div class="menu-group">
            <div class="menu-group__title" data-bs-toggle="collapse" data-bs-target="#dessertsCollapse">Desserts</div>
            <div class="collapse" id="dessertsCollapse">
                <div class="card card-body">

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#les-classiquesCollapse">Les Classiques</div>
                        <div class="collapse" id="les-classiquesCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Crème Brûlée Maison</span>
                                    <span class="menu-item__price">6,90€</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Moelleux au Chocolat</span>
                                    <span class="menu-item__price">6,90€</span>
                                    <p class="menu-item__description">et sa boule de glace vanille</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Mousse au Chocolat</span>
                                    <span class="menu-item__price">6,90€</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Café Gourmand</span>
                                    <span class="menu-item__price">6,90€</span>
                                    <p class="menu-item__description">1 pâtisserie, boule de glace au choix</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Baklava</span>
                                    <span class="menu-item__price">6,70€</span>
                                    <p class="menu-item__description">feuilleté au noix, sirop de sucre, chantilly</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Baklava avec Glace</span>
                                    <span class="menu-item__price">6,90€</span>
                                    <p class="menu-item__description">feuilleté au noix, sirop de sucre, chantilly, 1
                                        boule vanille</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Yaourt du Pays au Coulis de Miel</span>
                                    <span class="menu-item__price">6,90€</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Nougat Glacé</span>
                                    <span class="menu-item__price">6,90€</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Dessert du Jour</span>
                                    <span class="menu-item__price">6,90€</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#coupes-glaceesCollapse">Coupes Glacées</div>
                        <div class="collapse" id="coupes-glaceesCollapse">
                            <div class="card card-body">
                                <div class="menu-group">
                                    <div class="menu-group__title" data-bs-toggle="collapse"
                                        data-bs-target="#coupes-traditionnellesCollapse">Coupes Traditionnelles</div>
                                    <div class="collapse" id="coupes-traditionnellesCollapse">
                                        <div class="card card-body">
                                            <div class="menu-item">
                                                <span class="menu-item__title">Dame Blanche</span>
                                                <span class="menu-item__price">6,90€</span>
                                                <p class="menu-item__description">3 boules vanille, sauce chocolat,
                                                    chantilly</p>
                                            </div>
                                            <div class="menu-item">
                                                <span class="menu-item__title">Chocolat ou Café Liégeois</span>
                                                <span class="menu-item__price">6,90€</span>
                                                <p class="menu-item__description">2 boules café ou chocolat, 1 boule
                                                    vanille, sauce café ou sauce chocolat, chantilly</p>
                                            </div>
                                            <div class="menu-item">
                                                <span class="menu-item__title">Dolce Vita</span>
                                                <span class="menu-item__price">6,90€</span>
                                                <p class="menu-item__description">3 boules chocolat, 1 boule vanille
                                                    intense, pistache et ses morceaux, sauce chocolat</p>
                                            </div>
                                            <div class="menu-item">
                                                <span class="menu-item__title">Bounty</span>
                                                <span class="menu-item__price">6,90€</span>
                                                <p class="menu-item__description">3 boules chocolat et ses morceaux,
                                                    noix de coco, sauce chocolat</p>
                                            </div>
                                            <div class="menu-item">
                                                <span class="menu-item__title">Banana Split</span>
                                                <span class="menu-item__price">6,90€</span>
                                                <p class="menu-item__description">Banane coupée en deux, surmontée de
                                                    boules de glace, de sauce au chocolat, de crème chantilly et de
                                                    cerises confites</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="menu-group">
                                    <div class="menu-group__title" data-bs-toggle="collapse"
                                        data-bs-target="#coupes-alcooliseesCollapse">Coupes Alcoolisées</div>
                                    <div class="collapse" id="coupes-alcooliseesCollapse">
                                        <div class="card card-body">
                                            <div class="menu-item">
                                                <span class="menu-item__title">Coupe Colonel</span>
                                                <span class="menu-item__price">7,90€</span>
                                                <p class="menu-item__description">1 boule citron, vodka</p>
                                            </div>
                                            <div class="menu-item">
                                                <span class="menu-item__title">Punch des Glaces</span>
                                                <span class="menu-item__price">7,90€</span>
                                                <p class="menu-item__description">2 boules mandarine, 1 boule passion,
                                                    rhum</p>
                                            </div>
                                            <div class="menu-item">
                                                <span class="menu-item__title">Irish Coffee</span>
                                                <span class="menu-item__price">7,90€</span>
                                                <p class="menu-item__description">Vanille, Café, whisky</p>
                                            </div>
                                            <div class="menu-item">
                                                <span class="menu-item__title">After Eight</span>
                                                <span class="menu-item__price">7,90€</span>
                                                <p class="menu-item__description">2 boules Menthe chocolat et Get27</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="menu-group">
                        <div class="menu-group__title" data-bs-toggle="collapse"
                            data-bs-target="#votre-compositionsCollapse">Composez votre coupe</div>
                        <div class="collapse" id="votre-compositionsCollapse">
                            <div class="card card-body">
                                <div class="menu-item">
                                    <span class="menu-item__title">Sorbet</span>
                                    <p class="menu-item__description">Fruits de la passion, Citron, Fraise des bois,
                                        Framboise</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Glaces</span>
                                    <p class="menu-item__description">Vanille, Café, Chocolat, Caramel fleur de sel,
                                        Menthe-chocolat, Pistache, Cannelle</p>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Fruits de la passion 41% de fruits</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Coupe 1 boule</span>
                                    <span class="menu-item__price">2,20€</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Coupe 2 boules</span>
                                    <span class="menu-item__price">3,70€</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Coupe 3 boules</span>
                                    <span class="menu-item__price">4,60€</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Supplément Chantilly</span>
                                    <span class="menu-item__price">0,50€</span>
                                </div>
                                <div class="menu-item">
                                    <span class="menu-item__title">Supplément</span>
                                    <span class="menu-item__price">0,50€</span>
                                    <p class="menu-item__description">Sauce chocolat, sauce café ou coulis fruits rouges
                                        ou coulis fruits exotiques</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php include("footer.php"); ?>