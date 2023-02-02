<?php
    error_reporting(0);
    include("fonctions/Session.php");
    include("fonctions/fonctions.php");
    
    $catalogue = null;
    
    //Ajout au panier du produit
    if(isset($_POST['ajoutPanier'])) {
        ajoutPanier($_GET['id_produit'], 1);
    }
    //Initialisation des valeurs min et max
    $min = 2.38;
    $max = 400;



     // Recherche par Mot Clés
     $terme = $_GET["terme"];

    // Changement des valeurs min et max du filtre
    if (isset($_GET['Min'])OR isset($_GET['Max'])){
        $min = $_GET['Min'];
        $max = $_GET['Max'];
    }
   
    
   
    $catalogue = filtre_prix();
    /** 
     ** Tableau $catalogue
     *   ['nom_categorie']
     *   ['nom_produit']          
     *   ['prix_vente_ht']
     *   ['prix_vente_ttc']
     *   ['quantite_disponnible']
     *   ['description_produit']
     *   ['id_produit']   
     *   ['images1']
     *   ['images2']
     *   ['images3']
     *   ['nom_souscategorie']
     *   ['moyenne_note_produit']
     *
     */


    if(isset($terme) AND (strlen($terme) != 0)) {
        $terme = strtolower($terme);
        if(strlen($terme) <= 3) {
            $terme = ucfirst($terme);
        }if(isset($_GET['Min'])OR isset($_GET['Max'])){
            $catalogue = filtre_prix();
        }else{
            $catalogue = donnees_catalogue_mot_cles($terme);
        }
        
    }else {
        $catalogue = donnees_catalogue($terme);
    
    }
    echo '<script> document.cookie = "lienPage=; expires=Thu, 01 Jan 1970 00:00:00 UTC" </script>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
    <body>
        <header>
            <?php
                if(isset($_SESSION["id_admin"])){
                    include('header_admin.php');
                }
                else { 
                    include('header.php');
                }
            ?>
        </header>
        <?php if(isset($_GET["produitajouté"]))
        {
            
            echo "<div class='alert ajouterpanier'>";
            echo "<i class='fa-regular fa-circle-check fa-2x'></i>";
            echo "<p>Produit Ajouté</p>";
            echo "</div>";
        }
        ?>

        <main class="main-catalogue">
            <section class = "haut_catalogue">
                
                <?php 
                //Permet d'afficher un text différents selon la catégorie choisie
                if(sizeof($catalogue) == 0) { 
                    if(isset($_GET['Min'])OR isset($_GET['Max'])){
                        echo "<p class='erreur'>Aucun produit entre  ".$min."€ et ".$max."€"."</p>";
                    }else{
                        echo "<p class='erreur'>Aucun résultat pour ".str_replace('_',' ',$terme)."</p>"; 
                    } 
                }
                else { 
                    if(isset($_GET['Min'])OR isset($_GET['Max'])){
                        echo "<p class='trouve'>".sizeof($catalogue)." résultats trouvés entre ".$min."€ et ".$max."€"."</p>";
                    }else if(sizeof($catalogue) == 1) {
                        echo "<p class='trouve'>1 résultat pour ".str_replace('_',' ',$terme)."</p>";
                    } else {
                        echo "<p class='trouve'>".sizeof($catalogue)." résultats trouvés ".str_replace('_',' ',$terme)."</p>";
                    }
                }
                ?>
                <div id="sorting-options">
                    <details class="detailTri">
                        <summary class="triTitre"><h2>Trier par </h2></summary>
                      
                            <div>
                                <button id="ascending-sort" class ="boutonTri" onclick="sortProducts('asc', event)">Prix croissant</button>
                            </div>
                            <div>
                                <button id="descending-sort" class ="boutonTri"onclick="sortProducts('desc', event)">Prix décroissant</button> 
                            </div>  
                       
                  
                    </details>
                    
                </div>
            </section>
            
            <section class = "milieu_catalogue">
                <div class="liste-filtre">
                    <div class="titre-filtre">
                        <h1>Filtrer par Catégories</h1>
                    </div>
                    <form name="filters" method="get">
                        <div class="categorie-catalogue">

                            <details class="details1">
                                <summary class="categorie"><h2>Epicerie</h2></summary>
                                
                                <!-- Liste des sous-catégories -->
                                <div class="sous-categorie" for="Gateaux">
                                    <label for="Gateaux" class="sous-categorie-catalogue">Gateaux</label>
                                    <input name="Gateaux" type="checkbox"  id = "Gateaux" onchange = "checkFiltre('Gateaux')">
                                </div>
                                <div class="sous-categorie" for="Déjeuner">
                                    <label for="Déjeuner" class="sous-categorie-catalogue">Déjeuner</label>
                                    <input name="Déjeuner" type="checkbox" id="Déjeuner" onchange = "checkFiltre('Déjeuner')">
                                </div>
                            </details>

                            <details class="details2">

                                <summary class="categorie"><h2>Vêtements</h2></summary>

                                <!-- Liste des sous-catégories -->
                                <div class="sous-categorie" for="Pull">
                                    <label for="Pull" class="sous-categorie-catalogue">Pull</label>
                                    <input name="Pull" type="checkbox" id="Pull" onchange = "checkFiltre('Pull')">
                                </div>
                                <div class="sous-categorie" for="Pantalon">
                                    <label for="Pantalon" class="sous-categorie-catalogue">Pantalon</label>
                                    <input name="Pantalon" type="checkbox" id="Pantalon" onchange = "checkFiltre('Pantalon')">
                                </div>
                                <div class="sous-categorie" for="Vêtements de pluie">
                                    <label for="Vêtements de pluie" class="sous-categorie-catalogue">Vêtements de pluie</label>
                                    <input name="Vêtements de pluie" type="checkbox" id="Vêtements de pluie" onchange = "checkFiltre('Vêtements de pluie')">
                                </div>
                            </details>

                            <details class="details3">
                                <summary class="categorie"><h2>Souvenirs</h2></summary>

                                <!-- Liste des sous-catégories -->
                                <div class="sous-categorie" for="Poster">
                                    <label for="Poster" class="sous-categorie-catalogue">Poster</label>
                                    <input name="Poster" type="checkbox" id="Poster" onchange = "checkFiltre('Poster')">
                                </div>
                                <div class="sous-categorie" for="Carte postale">
                                    <label for="Carte postale" class="sous-categorie-catalogue">Carte postale</label>
                                    <input name="Carte postale" type="checkbox" id="Carte postale" onchange = "checkFiltre('Carte postale')">
                                </div>
                                <div class="sous-categorie" for="Portes clefs">
                                    <label for="Portes clefs" class="sous-categorie-catalogue">Portes clefs</label>
                                    <input name="Portes clefs" type="checkbox" id="Portes clefs" onchange = "checkFiltre('Portes clefs')">
                                </div>
                            </details>

                            <details class="details4">
                                <summary class="categorie"><h2>Produits frais</h2></summary>

                                <!-- Liste des sous-catégories -->
                                <div class="sous-categorie" for="Viande">
                                    <label for="Viande" class="sous-categorie-catalogue">Viande</label>
                                    <input name="Viande" type="checkbox" id="Viande" onchange = "checkFiltre('Viande')">
                                </div>
                                <div class="sous-categorie" for="Poisson">
                                    <label for="Poisson" class="sous-categorie-catalogue">Poisson</label>
                                    <input name="Poisson" type="checkbox" id="Poisson" onchange = "checkFiltre('Poisson')">
                                </div>
                            </details>
                        </div>

                        <form class="range_container" method = "get" name = "FiltrePrix" id = "FiltrePrix">
                            <div class="sliders_control">
                                <input id="fromSlider" type="range" value="<?php echo "$min"?>" min="0" max="500" onchange = "checkFiltre(null)"/>
                                <input id="toSlider" type="range" value="<?php echo "$max"?>" min="0" max="500" style ="z-index: 0;" onchange = "checkFiltre(null)"/>
                            </div>
                            <div class="form_control">
                                <div class="form_control_container">
                                    <div class="form_control_container__time">Min</div>
                                    <input class="form_control_container__time__input" type="number" id="fromInput" value="<?php echo "$min"?>" min="0" max="500" onchange = "checkFiltre(null)"/>
                                </div>
                                <div class="form_control_container">
                                    <div class="form_control_container__time">Max</div>
                                    <input class="form_control_container__time__input" type="number" id="toInput" value="<?php echo "$max"?>" min="0" max="500" onchange = "checkFiltre(null)"/>
                                </div>
                            </div>
                        </form>

                        <form action="catalogue.php" method="Get" class="form_suppr_filtres">
                            <button class="normal-button rouge supprimer-filtre">Supprimer tous les filtres</button>
                        </form>
                        
                    </form>

                </div>
                <div class = "article_cat" >
                    <?php foreach ($catalogue as $produit):?> 
                        <div class="carte_produit_ajout <?php echo $produit["nom_souscategorie"]; ?>">
                        
                            <a class="carte_produit_lien" href="produit.php?idProduit=<?php echo $produit["id_produit"]; ?>">
                                <img src="<?php echo str_replace(' ', "_","../img/catalogue/Produits/".$produit['id_produit']."/img1.jpg" );?>" alt="photo du produit">
                            </a>
                            <h3><?php echo $produit["nom_produit"]; ?></h3>
                            <div class="prix_avis">
                                <div class="stars">
                                <?php
                                //Pour afficher les étoiles de notations
                                    for ($i = 0; $i < $produit['moyenne_note_produit'] ; $i++)
                                    {
                                        echo '<i class="fa fa-star gold"></i>';
                                    }
                                    for ($i = 0; $i < 5-$produit['moyenne_note_produit']; $i++){
                                        echo '<i class="fa fa-star grey"></i>';
                                    }
                                    
                                    ?>
                                    
                                </div>
                                <h4><?php echo $produit["prix_vente_ttc"]."€";?></h4>
                            </div>
                            <div class="carte_produit_ajout--boutons__panier">
                                <form id = "formAction" action="catalogue.php?<?php echo 'id_produit='.$produit["id_produit"].'&terme='.$terme; ?>&produitajouté" method="POST" >
                                    <button type='submit' class = "ajoutPanier" name='ajoutPanier'>Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                        <div class="block-CatalogueVide">
                            <h1 class="titre-panierVide">Aucun produit disponible avec les critères sélectionnés</h1>
                    
                                <div class="block-texte_panierVide">
                                <img src="../img/catalogueVide.png" alt="Catalogue vide" title="Catalogue vide" width="350" height="300px">
                                   
                                </div>
                        </div>
                </div>
            </Section>


        </main>
        <footer>
            <?php include("footer.php"); ?>
        </footer>
    </body>
</html>

<script>
//Fonction pour le filtre du prix

/**
     * Description : 
     * met à jour la valeur du curseur "from" et du champ de saisie "from" en fonction de la valeur du champ de saisie "to"
     * 
     * 
     * ¨Pas de return
     * 
     */
    function controlFromInput(fromSlider, fromInput, toInput, controlSlider) {
        const [from, to] = getParsed(fromInput, toInput);
        fillSlider(fromInput, toInput, '#C6C6C6', '#FFB703', controlSlider);
        if (from > to) {
            fromSlider.value = to;
            fromInput.value = to;
        } else {
            fromSlider.value = from;
        }
    }
    /**
     * Description : 
     * met à jour la valeur du curseur "to" et du champ de saisie "to" en fonction de la valeur du champ de saisie "from"
     * 
     * 
     * ¨Pas de return
     * 
     */
        
    function controlToInput(toSlider, fromInput, toInput, controlSlider) {
        const [from, to] = getParsed(fromInput, toInput);
        fillSlider(fromInput, toInput, '#C6C6C6', '#FFB703', controlSlider);
        setToggleAccessible(toInput);
        if (from <= to) {
            toSlider.value = to;
            toInput.value = to;
        } else {
            toInput.value = from;
        }
    }
    /**
     * Description : 
     * met à jour la valeur du champ de saisie "from" en fonction de la valeur du curseur "from"
     * 
     * 
     * ¨Pas de return
     * 
     */
        

    function controlFromSlider(fromSlider, toSlider, fromInput) {
        const [from, to] = getParsed(fromSlider, toSlider);
        fillSlider(fromSlider, toSlider, '#C6C6C6', '#FFB703', toSlider);
        if (from > to) {
            fromSlider.value = to;
            fromInput.value = to;
        } else {
            fromInput.value = from;
        }
    }
     /**
     * Description : 
     * met à jour la valeur du champ de saisie "to" en fonction de la valeur du curseur "to"
     * 
     * 
     * ¨Pas de return
     * 
     */
        

    function controlToSlider(fromSlider, toSlider, toInput) {
        const [from, to] = getParsed(fromSlider, toSlider);
        fillSlider(fromSlider, toSlider, '#C6C6C6', '#FFB703', toSlider);
        setToggleAccessible(toSlider);
        if (from <= to) {
            toSlider.value = to;
            toInput.value = to;
        } else {
            toInput.value = from;
            toSlider.value = from;
        }
    }
 /**
     * Description : 
     * retourne un tableau de deux valeurs entières parsées à partir des valeurs actuelles des champs de saisie ou des curseurs
     * 
     * 
     * 
     * 
     */
        
    function getParsed(currentFrom, currentTo) {
    const from = parseInt(currentFrom.value, 10);
    const to = parseInt(currentTo.value, 10);
    return [from, to];
    }
     /**
     * Description : 
     *  remplit les curseurs avec des couleurs en fonction de la plage de filtre sélectionnée
     * 
     * 
     * ¨Pas de return
     * 
     */
        

    function fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
        const rangeDistance = to.max-to.min;
        const fromPosition = from.value - to.min;
        const toPosition = to.value - to.min;
        controlSlider.style.background = `linear-gradient(
        to right,
        ${sliderColor} 0%,
        ${sliderColor} ${(fromPosition)/(rangeDistance)*100}%,
        ${rangeColor} ${((fromPosition)/(rangeDistance))*100}%,
        ${rangeColor} ${(toPosition)/(rangeDistance)*100}%, 
        ${sliderColor} ${(toPosition)/(rangeDistance)*100}%, 
        ${sliderColor} 100%)`;
    }
     /**
     * Description : 
     * mgère l'affichage des curseurs en fonction de la valeur actuelle de la cible
     * 
     * 
     * ¨Pas de return
     * 
     */
        

    function setToggleAccessible(currentTarget) {
        const toSlider = document.querySelector('#toSlider');
        if (Number(currentTarget.value) <= 0 ) {
            toSlider.style.zIndex = 2;
        } else {
            toSlider.style.zIndex = 0;
        }
    }
    //définies pour les éléments de l'interface utilisateur (curseurs et champs de saisie), qui sont ensuite utilisées 
    //pour gérer les événements d'entrée et mettre à jour les valeurs de l'interface utilisateur
    const fromSlider = document.querySelector('#fromSlider');
    const toSlider = document.querySelector('#toSlider');
    const fromInput = document.querySelector('#fromInput');
    const toInput = document.querySelector('#toInput');
    fillSlider(fromSlider, toSlider, '#C6C6C6', '#FFB703', toSlider);
    setToggleAccessible(toSlider);

    fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
    toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);
    fromInput.oninput = () => controlFromInput(fromSlider, fromInput, toInput, toSlider);
    toInput.oninput = () => controlToInput(toSlider, fromInput, toInput, toSlider);


   
    //Pour avoir un tableau avec tous les éléments
    var tabElem = [];
    var elem = document.getElementsByClassName("carte_produit_ajout");
    //console.log(elem);
    for (var i = 0; i < elem.length;i++){
        tabElem[i]=elem[i];
        //console.log(tabElem[i]);
        
    }
    //Tab pour garder en mémoire les checkbox
    var checkboxTab = [];
   
        
    
    //savoir si une case a été coché
   

    /**
     * Description : 
     * Permet selon les filtres choisis d'afficher les produits correspondants
     * 
     * Parametres :
     * elem (String): Sous-catégorie que l'on souhaite filtrer
     * 
     * 
     * ¨Pas de return
     * 
     */
    function checkFiltre(elem){        
        // Si on filtre avec la slide barre on n'insère pas d'élément donc ça rentre dans la condition
        if (elem == null){
            if (checkboxTab.length ==0){
                //Si aucune catégorie n'a été choisie et donc tous les produits sont à l'écran
                var cartes = document.getElementsByClassName("carte_produit_ajout");
                for (let indexCat=0;indexCat<cartes.length;indexCat++){
                    //On vas chercher le prix du produit
                    var prix = cartes[indexCat].childNodes[5].childNodes[3].innerHTML;
                    //On enlève si prix a virgule
                    prix = prix.slice(0, -1);
                    let pointenmoins = prix.indexOf(".");
                    if (pointenmoins != null){
                        if ((prix.slice(pointenmoins-2,pointenmoins)) != ""){
                            prix = prix.slice(pointenmoins-2,pointenmoins);
                        }
                        else{
                            prix = prix.slice(pointenmoins-1,pointenmoins);
                        }
                    }   
                    intPrix = parseInt(prix);
                    intFromSlider = parseInt(fromSlider.value);
                    intToSlider = parseInt(toSlider.value);
                    //Compare le produit à la slide barre et l'affiche s'il est dedans
                    if ((intPrix >= intFromSlider) && (intPrix <= intToSlider)){
                        cartes[indexCat].style.display = "block";
                    } else{
                        cartes[indexCat].style.display = "none";
                    }
                } 
                
            }else{
                //Si une catégorie a été choisi, quand on touche au slider ça rentre ici
                for (let j =0; j<checkboxTab.length;j++ ){
                    let tabCat = document.getElementsByClassName(checkboxTab[j].id);
                    for (let indexCat = 0; indexCat < tabCat.length;indexCat++){
                        var prix = tabCat[indexCat].childNodes[5].childNodes[3].innerHTML;
                        prix = prix.slice(0, -1);
                        let pointenmoins = prix.indexOf(".");
                        if (pointenmoins != null){
                            if ((prix.slice(pointenmoins-2,pointenmoins)) != ""){
                                prix = prix.slice(pointenmoins-2,pointenmoins);
                            }
                            else{
                                prix = prix.slice(pointenmoins-1,pointenmoins);
                            }
                        }   
                        intPrix = parseInt(prix);
                        intFromSlider = parseInt(fromSlider.value);
                        intToSlider = parseInt(toSlider.value);
                        if ((intPrix >= intFromSlider) && (intPrix <= intToSlider)){
                            
                            tabCat[indexCat].style.display = "block";
                        } else{
                            tabCat[indexCat].style.display = "none";
                        }
                    }
                }
            }
        }else{
            //Pour les checkBox et filtrer les produits
            let checkbox = document.getElementById(elem);
            if(checkbox.checked){
                checkboxTab.push(checkbox);
            }else{
                let value = checkboxTab.indexOf(checkbox);
                checkboxTab.splice(value,1);
            }
            
            let allElem = document.getElementsByClassName("carte_produit_ajout");
                    

            for (let i = 0; i < allElem.length; i++) {
                allElem[i].style.display = "none";
            }

            for (let j =0; j<checkboxTab.length;j++ ){
                let tabCat = document.getElementsByClassName(checkboxTab[j].id);
                for (let indexCat = 0; indexCat < tabCat.length;indexCat++){
                    var prix = tabCat[indexCat].childNodes[5].childNodes[3].innerHTML;
                    prix = prix.slice(0, -1);
                    let pointenmoins = prix.indexOf(".");
                    if (pointenmoins != null){
                        if ((prix.slice(pointenmoins-2,pointenmoins)) != ""){
                            prix = prix.slice(pointenmoins-2,pointenmoins);
                        }
                        else{
                            prix = prix.slice(pointenmoins-1,pointenmoins);
                        }
                    }

                    intPrix = parseInt(prix);
                    intFromSlider = parseInt(fromSlider.value);
                    intToSlider = parseInt(toSlider.value);
                    
                    if ((intPrix >= intFromSlider) && (intPrix <= intToSlider)){
                       
                        tabCat[indexCat].style.display = "block";
                    } 
                }
                let pElement = document.getElementsByClassName("classname")[0];
                
            }

            //pour quand une catégorie a été coché, si elle est décoché que ça réaffiche tous
            var sousCat = document.getElementsByClassName("sous-categorie");
            var boolC = false;
            for (let catchecked =0;catchecked<sousCat.length;catchecked++){
                if(sousCat[catchecked].getElementsByTagName('input')[0].checked){
                    boolC = true;
                }   
            }
            if(!boolC){
                var cartes = document.getElementsByClassName("carte_produit_ajout");
                for (let i =0;i<cartes.length;i++){
                    cartes[i].style.display = "block";
                } 
            }
        }

        // Si on a filtré mais il n'y a aucun produit à l'écran, ça affiche une image et un texte l'indiquant au client
        var boolAff = false;
        var vide = document.getElementsByClassName("block-CatalogueVide")[0];
        var sousCat = document.getElementsByClassName("carte_produit_ajout");
        vide.style.display = "none";
   
        for(var i = 0; i < sousCat.length; i++) {
            if(sousCat[i].style.display == "block"){
                boolAff = true;
            }
        }
        if (boolAff ===false){
            vide.style.display = "flex";
            
        }else{
            vide.style.display = "none";
          
        }
        boolAff = false;
    }
    
    var vide = document.getElementsByClassName("block-CatalogueVide")[0];
    vide.style.display = "none";


    /**
     * Description : 
     * Permet de trier les produits en croissant décroissant
     * 
     * Parametres :
     * order (String): croissant/décroissant -> indique comment on veut trier
     * 
     * 
     * ¨Pas de return
     * 
     */
    
    function sortProducts(order) {
        var products = document.getElementsByClassName("carte_produit_ajout");

        var sortedProducts = Array.prototype.slice.call(products).sort(function(a, b) {
            var priceA = parseFloat(a.childNodes[5].childNodes[3].innerHTML);
   
            var priceB = parseFloat(b.childNodes[5].childNodes[3].innerHTML);
    
            if (order === "asc") {
                return priceA - priceB;
                }else {
                return priceB - priceA;
            }
        });
        var parent = document.getElementsByClassName("article_cat")[0];
        
        for (var i = 0; i < sortedProducts.length; i++) {
            parent.appendChild(sortedProducts[i]);
        }
        triActif(event)
    }
       

    function triActif(e){

        let btnsTri = document.getElementsByClassName("boutonTri")

        for(i = 0 ; i < btnsTri.length ; i++){
            btnsTri[i].classList.remove("actif")
        }

        let trichoisi = e.target
        trichoisi.classList.add("actif");
    }
    

    
    

</script>
