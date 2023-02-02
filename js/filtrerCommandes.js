/*############# FONCTIONS #######################*/

/**
 * DESCRIPTION
 *  Permet de selectionner toutes commandes de n'importe quelle etat
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function myFunctionTous() {
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
     td = tr[i].getElementsByTagName("td")[3];
     if (td) {
            tr[i].style.display = "";
       }
    }

    let btn = document.querySelector(".tous");
    ajouterActive(btn);
}

/**
 * DESCRIPTION
 *  Permet de selectionner toutes commandes en cours
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function myFunctionEnCours() {

    var filter = "EN COURS";
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];

        if (td) {
        txtValue = td.innerText;
        if (txtValue.toUpperCase() == filter) {
            tr[i].style.display = "";
        } 
        else {
            tr[i].style.display = "none";
            }
        }
    }

    let btn = document.querySelector(".encours");
    ajouterActive(btn);
}

/**
 * DESCRIPTION
 *  Permet de selectionner toutes commandes en attente
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function myFunctionEnAttente() 
{

    var filter = "EN ATTENTE";
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
     td = tr[i].getElementsByTagName("td")[3];

     if (td) {
        txtValue = td.innerText;
        console.log(filter)
        if (txtValue.toUpperCase() === filter) {
            tr[i].style.display = ""; 
        } 
        else {
          tr[i].style.display = "none";
            }
       }
    }

    let btn = document.querySelector(".attente");
    ajouterActive(btn);
}



/**
 * DESCRIPTION
 *  Permet de selectionner toutes commandes terminee
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function myFunctionTerminer() {

    var filter = "TERMINÉE";
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
     td = tr[i].getElementsByTagName("td")[3];
     if (td) {
        txtValue = td.innerText;
        if (txtValue.toUpperCase() == filter) {
            tr[i].style.display = "";
        } 
        else {
          tr[i].style.display = "none";
            }
       }
    }

    let btn = document.querySelector(".terminé");
    ajouterActive(btn);
}


/**
 * DESCRIPTION
 *  Permet de selectionner toutes commandes anuler
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function myFunctionAnnuler() {

    var filter = "ANNULER";
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
     td = tr[i].getElementsByTagName("td")[3];
     if (td) {
        txtValue = td.innerText;
        if (txtValue.toUpperCase() == "ANNULER") {
            tr[i].style.display = "";
        } 
        else {
          tr[i].style.display = "none";
            }
       }
    }

    let btn = document.querySelector(".annuler");
    ajouterActive(btn);
}

/**
 * DESCRIPTION
 *  Change le style du bouton de selection des etat en cours
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function ajouterActive(ajout_bouton){

    var bouton = document.querySelector(".filtreCommande .active")
    bouton.classList.remove("active")

    ajout_bouton.classList.add("active");
}


/**
 * DESCRIPTION
 *  appel les fontion de trie sur les prix et modifie l'affichage des icon de trie
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortPrice(){ 

    if (priceset == 0){
        document.getElementById("priceicon").className = "fas fa-sort-numeric-down";
        
        //reset sort
        document.getElementById("Nameicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Dateicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Etaticon").className = "fas fa-sort";
        nameset=0;

        sortTablePriceCroissant();
        priceset =1;
    }
    else if (priceset == 1) {
        document.getElementById("priceicon").className = "fas fa-sort-numeric-down-alt";

        //reset sort
        document.getElementById("Nameicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Dateicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Etaticon").className = "fas fa-sort";
        nameset=0;

        sortTablePriceDecroissant();
        priceset = 2;
    }
    else{
        document.getElementById("priceicon").className = "fas fa-sort";
        sortTableCommande();
        priceset=0;
    }
}

var nameset=0;

/**
 * DESCRIPTION
 *  appel les fontion de trie sur les nom du client et modifie l'affichage des icon de trie
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortName(){  
   
    if (nameset == 0){
        document.getElementById("Nameicon").className = "fas fa-sort-alpha-down";

        //reset sort
        document.getElementById("priceicon").className = "fas fa-sort";
        priceset=0;
        document.getElementById("Dateicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Etaticon").className = "fas fa-sort";
        nameset=0;

        sortTableNameAlpha();
        nameset =1;
    }
    else if (nameset == 1) {
        document.getElementById("Nameicon").className = "fas fa-sort-alpha-down-alt";

        //reset sort
        document.getElementById("priceicon").className = "fas fa-sort";
        priceset=0;
        document.getElementById("Dateicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Etaticon").className = "fas fa-sort";
        nameset=0;

        sortTableNameDealpha();
        nameset = 2;
    }
    else{
        document.getElementById("Nameicon").className = "fas fa-sort";
        sortTableCommande();
        nameset=0;
    }
}

var dateset=0;

/**
 * DESCRIPTION
 *  appel les fontion de trie sur les date et modifie l'affichage des icon de trie
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortDate(){  
   
    if (dateset == 0){
        document.getElementById("Dateicon").className = "fas fa-sort-amount-down-alt";
        
        //reset sort
        document.getElementById("priceicon").className = "fas fa-sort";
        priceset=0;
        document.getElementById("Nameicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Etaticon").className = "fas fa-sort";
        nameset=0;

        sortTableDateNewFirst();
        dateset =1;
    }
    else if (dateset == 1) {
        document.getElementById("Dateicon").className = "fas fa-sort-amount-down";

        //reset sort
        document.getElementById("priceicon").className = "fas fa-sort";
        priceset=0;
        document.getElementById("Nameicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Etaticon").className = "fas fa-sort";
        nameset=0;

        sortTableDateOldFirst();
        dateset = 2;
    }
    else{
        document.getElementById("Dateicon").className = "fas fa-sort";
        sortTableCommande();
        dateset=0;
    }
}


var etatset=0;

/**
 * DESCRIPTION
 *  appel les fontion de trie sur les etat et modifie l'affichage des icon de trie
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortEtat(){  
   
    if (etatset == 0){
        document.getElementById("Etaticon").className = "fas fa-sort-amount-down-alt";
        
        //reset sort
        document.getElementById("priceicon").className = "fas fa-sort";
        priceset=0;
        document.getElementById("Nameicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Dateicon").className = "fas fa-sort";
        nameset=0;

        sortTableEttatde();
        etatset =1;
    }
    else if (etatset == 1) {
        document.getElementById("Etaticon").className = "fas fa-sort-amount-down";

        //reset sort
        document.getElementById("priceicon").className = "fas fa-sort";
        priceset=0;
        document.getElementById("Nameicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Dateicon").className = "fas fa-sort";
        nameset=0;

        sortTableEttat();
        etatset = 2;
    }
    else{
        document.getElementById("Etaticon").className = "fas fa-sort";
        sortTableCommande();
        etatset=0;
    }
}

/**
 * DESCRIPTION
 *  appel les fontion de trie sur les id et modifie l'affichage des icon de trie
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function reset(){
        document.getElementById("priceicon").className = "fas fa-sort";
        priceset=0;
        document.getElementById("Nameicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Dateicon").className = "fas fa-sort";
        nameset=0;
        document.getElementById("Etaticon").className = "fas fa-sort";
        nameset=0;

        sortTableCommande();
}


/**
 * DESCRIPTION
 *  trie dans l'odre decroissant les ligne du tableau commande en fonction du prix
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTablePriceDecroissant() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = parseInt(rows[i].getElementsByTagName("TD")[5].getElementsByTagName("p")[0].innerHTML);
            y = parseInt(rows[i+1].getElementsByTagName("TD")[5].getElementsByTagName("p")[0].innerHTML);
        if (x < y) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}




/**
 * DESCRIPTION
 *  trie dans l'odre croissant les ligne du tableau commande en fonction du prix
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTablePriceCroissant() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = parseInt(rows[i].getElementsByTagName("TD")[5].getElementsByTagName("p")[0].innerHTML);
            y = parseInt(rows[i+1].getElementsByTagName("TD")[5].getElementsByTagName("p")[0].innerHTML);
        if (x > y) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre de la plus ancienne les ligne du tableau commande en fonction de la date
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableDateOldFirst() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = moment(rows[i].getElementsByTagName("TD")[2].innerHTML, "DD/MM/YYYY").toDate();
            y = moment(rows[i+1].getElementsByTagName("TD")[2].innerHTML, "DD/MM/YYYY").toDate();
            if (x > y) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        }
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre de la moins anciene les ligne du tableau commande en fonction de la date
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableDateNewFirst() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = moment(rows[i].getElementsByTagName("TD")[2].innerHTML, "DD/MM/YYYY").toDate();
            y = moment(rows[i+1].getElementsByTagName("TD")[2].innerHTML, "DD/MM/YYYY").toDate();
        if (x < y) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre alphabétique les ligne du tableau commande en fonction du nom du client
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableNameAlpha() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("TD")[1];
        y = rows[i + 1].getElementsByTagName("TD")[1];
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre alphabétique inverse les ligne du tableau commande en fonction du nom du client
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableNameDealpha() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("TD")[1];
        y = rows[i + 1].getElementsByTagName("TD")[1];
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre croissant les ligne du tableau commande en fonction de id
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableCommande() {
var table, rows, switching, i, x, y, shouldSwitch;
table = document.getElementById("myTable");
switching = true;
while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("TD")[0];
        y = rows[i + 1].getElementsByTagName("TD")[0];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre annuler, en attente, en cours, terminer les ligne du tableau commande en fonction de etat
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableEttat() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[3];
            y = rows[i + 1].getElementsByTagName("TD")[3];
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre terminer, en cours, en attente, annuler les lignes du tableau commande en fonction de etat
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableEttatde() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[3];
            y = rows[i + 1].getElementsByTagName("TD")[3];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}



/**
 * DESCRIPTION
 *  trie dans l'odre alphabétique les ligness du tableau produit de catalogue en fonction du nom des produit
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableNameProducts() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable produits");
    
    switching = true;
    while (switching) {
    switching = false;
    rows = table.rows;
    
    for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].querySelector("td > a");
        y = rows[i + 1].querySelector("td > a");
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }

    let btn_tri = document.querySelector(".nom_produit + i");
    btn_tri.className = "fa-solid fa-sort-up";
}

/**
 * DESCRIPTION
 *  trie dans l'odre alphabétique inverse les lignes du tableau produit de catalogue en fonction du nom des produit
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableNameProductsDecroissant() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable produits");
    
    switching = true;
    while (switching) {
    switching = false;
    rows = table.rows;
    
    for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].querySelector("td > a");
        y = rows[i + 1].querySelector("td > a");
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }

    let btn_tri = document.querySelector(".nom_produit + i");
    btn_tri.className = "fa-solid fa-sort-down";
}

var triNom = true;

/**
 * DESCRIPTION
 *  appel les fontion de trie sur les nom du produit et modifie l'affichage des icon de trie
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function SortNameProduits(){
    
    resetBtnTri()

    if(triNom){
        sortTableNameProducts();
        triNom = false;
    }
    else{
        sortTableNameProductsDecroissant();
        triNom = true;
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre croissant les ligne du tableau produit de catalogue en fonction de id
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableCommandeProduits() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable produits");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
    }

    let btn_tri = document.querySelector(".id_produit + i");
    btn_tri.className = "fa-solid fa-sort-up";
}

/**
 * DESCRIPTION
 *  trie dans l'odre decroissant les ligne du tableau produit de catalogue en fonction de id
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTableCommandeProduitsDecroissant() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable produits");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
    }

    let btn_tri = document.querySelector(".id_produit + i");
    btn_tri.className = "fa-solid fa-sort-down";

}

/**
 * DESCRIPTION
 *  appel les fontion de trie sur l id du produit et modifie l'affichage des icon de trie
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
var triId = true;
function SortTableProduitsTri(){

    resetBtnTri()

    if(triId){
        sortTableCommandeProduits();
        triId = false;

    }
    else{
        sortTableCommandeProduitsDecroissant();
        triId= true;
    }
}

/**
 * DESCRIPTION
 *  trie dans l'odre croissant les ligne du tableau produit de catalogue en fonction du prix
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTablePriceProduits(index) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable produits");

    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = parseInt(rows[i].querySelectorAll("td > p")[index-2].innerHTML);
            y = parseInt(rows[i+1].querySelectorAll("td > p")[index-2].innerHTML);

        if (x > y) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
    switch(index){

        case 2 : 
            let btn_tri_prixHT = document.querySelector(".prixHT_produit + i");
            btn_tri_prixHT.className = "fa-solid fa-sort-up";
            break;
        case 3 :
            let btn_tri_prixTTC = document.querySelector(".prixTTC_produit + i");
            btn_tri_prixTTC.className = "fa-solid fa-sort-up";
            break;
        case 4:
            let btn_tri_stock = document.querySelector(".stock_produit + i");
            btn_tri_stock.className = "fa-solid fa-sort-up";
            break;          
    }


}

/**
 * DESCRIPTION
 *  trie dans l'odre decroissant les ligne du tableau produit de catalogue en fonction du prix
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function sortTablePriceProduitsDecroissant(index) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable produits");

    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = parseInt(rows[i].querySelectorAll("td > p")[index -2].innerHTML);
            y = parseInt(rows[i+1].querySelectorAll("td > p")[index -2].innerHTML);

        if (x < y) {
            shouldSwitch = true;
            break;
        }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }

    switch(index){

        case 2 : 
            let btn_tri_prixHT = document.querySelector(".prixHT_produit + i");
            btn_tri_prixHT.className = "fa-solid fa-sort-down";
            break;
        case 3 :
            let btn_tri_prixTTC = document.querySelector(".prixTTC_produit + i");
            btn_tri_prixTTC.className = "fa-solid fa-sort-down";
            break;
        case 4:
            let btn_tri_stock = document.querySelector(".stock_produit + i");
            btn_tri_stock.className = "fa-solid fa-sort-down";
            break;          
    }
}

var SortPriceTri = true

/**
 * DESCRIPTION
 *  appel les fontion de trie sur le prix du produit et modifie l'affichage des icon de trie
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function SortPrice(index){

    resetBtnTri();

    if(SortPriceTri){

        sortTablePriceProduits(index)
        SortPriceTri =false;
    } else{
        sortTablePriceProduitsDecroissant(index)
        SortPriceTri = true;
    }
}

/**
 * DESCRIPTION
 *  remet les bouton tri a leur affichage initiale
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function resetBtnTri(){

    let tab_Btn_tri = document.querySelectorAll(".catalogue i");
    
    tab_Btn_tri.forEach(btn_tri => {
        btn_tri.className = "fa-solid fa-sort";
    });
}

// Boutons dynamiques
let nb_en_cours = document.querySelectorAll(".Etats-Encours");
let btn_en_cours = document.querySelector(".encours")
btn_en_cours.innerHTML = "En Cours (" +(nb_en_cours.length) + ")";

let nb_en_attente = document.querySelectorAll(".Etats-EnAttente");
let btn_en_attente = document.querySelector(".attente")
btn_en_attente.innerHTML = "En Attente (" +(nb_en_attente.length) + ")";

let nb_terminee = document.querySelectorAll(".Etats-Termine");
let btn_terminee = document.querySelector(".terminé")
btn_terminee.innerHTML = "Terminée (" +(nb_terminee.length) + ")";

let nb_annuler = document.querySelectorAll(".Etats-Annuler");
let btn_annuler = document.querySelector(".annuler")
btn_annuler.innerHTML = "Annuler (" +(nb_annuler.length) + ")";

let nb_commandes = document.querySelectorAll("tr");
let btn_tous = document.querySelector(".tous");
btn_tous.innerHTML = "Tous (" + (nb_en_cours.length+nb_en_attente.length+nb_terminee.length+nb_annuler.length) + ")";


// onglets de la page 
let btn_catalogue = document.querySelector(".catalogue-vendeur");
btn_catalogue.addEventListener("click", ouverture_onglet_catalogue);

let btn_commandes = document.querySelector(".commandes-vendeur");
btn_commandes.addEventListener("click", ouverture_onglet_commandes)

/**
 * DESCRIPTION
 *  Cache la parti commande du vendeur et affiche le ajout dans le catalogue en changer le sytle d'ativiter de bouton
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function ouverture_onglet_catalogue()
{
    let btn_active = document.querySelector(".active")
    btn_active.classList.remove("active")
    btn_catalogue.classList.add("active")

    let onglet_affiche = document.querySelector(".affiche")
    onglet_affiche.classList.remove("affiche")
    onglet_affiche.classList.add("cache")

    let onglet_catalogue = document.querySelector(".catalogue")
    onglet_catalogue.classList.remove("cache")
    onglet_catalogue.classList.add("affiche")
}

/**
 * DESCRIPTION
 *  affiche la parti commande du vendeur et cache le ajout dans le catalogue en changer le sytle d'ativiter de bouton
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function ouverture_onglet_commandes()
{
    let btn_active = document.querySelector(".active")
    btn_active.classList.remove("active")
    btn_commandes.classList.add("active")

    let onglet_affiche = document.querySelector(".affiche")
    onglet_affiche.classList.remove("affiche")
    onglet_affiche.classList.add("cache")

    let onglet_commandes = document.querySelector(".commandes")
    onglet_commandes.classList.remove("cache")
    onglet_commandes.classList.add("affiche")
}

/**
 * DESCRIPTION
 *  change le style css en display table-row
 * 
 * PARAMETRES
 *  void
 * 
 * RETRURN
 *  void
 * 
 */
function Affiche(num) {
    var elements= document.querySelectorAll("tr[id='commande"+num+"']");
    for (let i = 0; i < elements.length; i++) {
        elements[i].className ="Detailaffiche";
    }
    header =document.getElementById("headerP");
    header.className="Detailaffiche en-teteP";
   
    
}

/**
 * DESCRIPTION
 *  change le style css en display none
 * 
 * PARAMETRES
 *  num (int) : numero de la commande
 * 
 * RETRURN
 *  void
 * 
 */
function Cacher(num) {
    var elements= document.querySelectorAll("tr[id='commande"+num+"']");
    for (let i = 0; i < elements.length; i++) {
        elements[i].className ="Detailcache";
    }
    header =document.getElementById("headerP");
    header.className="Detailcache en-teteP";
}

var detailP=true;
/**
 * DESCRIPTION
 *  affiche ou cache les detail d'une commande en n'affichant que celle si sur la page
 * 
 * PARAMETRES
 *  num (int) : numero de la commande
 * 
 * RETRURN
 *  void
 * 
 */
function detailProduit(num){  
   
    if (detailP){
        Affiche(num)
        
        element = document.querySelector(".filtreCommande");
        element.style.display = "none";


        const th = document.getElementById("en-tete");
        const icons = th.querySelectorAll("i");
        icons.forEach(icon => {
            icon.style.display = "none";
        });

        tableP = document.getElementById("myTable");
        rows = tableP.querySelectorAll("tr");
        rows.forEach(row => {
            if (row.id !== ("c"+num)) {
                console.log("c"+num);
                row.style.display = "none";
            }
        })
        
        document.getElementById("en-tete").style.display= "table-row";

        detailP =false
    }
    else{
        Cacher(num)

        element = document.querySelector(".filtreCommande");
        element.style.display = "flex";

        const icons = document.getElementsByTagName("i");
        for (let i = 0; i < icons.length; i++) {
          icons[i].style.display = "var(--fa-display,inline-block)";
        }

        tableP = document.getElementById("myTable");
        rows = tableP.querySelectorAll("tr");
        rows.forEach(row => {
            if (row.id !== ("c"+num)) {
                console.log("c"+num);
                row.style.display = "table-row";
            }

        element = document.querySelector(".filtreCommande");
        })
        
        detailP =true;

    }
}

function tronquerAdr() {
    // Récupérer la table en utilisant l'ID "myTable"
    let table = document.getElementById("myTable");
    
    // Récupérer toutes les balises td dans la table
    let tdElements = table.getElementsByTagName("td");
    
    // Boucle à travers toutes les balises td
    for (let i = 0; i < tdElements.length; i++) {
      let td = tdElements[i];
      
      // Enregistrer le texte original de la balise td
      let originalText = td.textContent;
      
      // Si la longueur du texte de la balise td est supérieure à 30 et qu'il n'y a pas de balise div à l'intérieur
      if (td.textContent.length > 30 && !td.getElementsByTagName("div").length) {
        // Tronquer le texte de la balise td à 30 caractères et ajouter "..."
        td.textContent = td.textContent.substring(0, 30) + "...";
        
        // Ajouter un écouteur d'événement "click" à la balise td
        td.addEventListener("click", function() {
          // Si le contenu de la balise se termine par "..."
          if (td.textContent.endsWith("...")) {
            // Réinitialiser le contenu de la balise avec le texte original
            td.textContent = originalText;
          } else {
            // Tronquer le contenu de la balise à 30 caractères et ajouter "..."
            td.textContent = td.textContent.substring(0, 30) + "...";
          }
        });
      }
    }
  }
  
tronquerAdr()



