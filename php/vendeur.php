<?php
    include("fonctions/fonctions.php");
    include("fonctions/carte_produit.php");
    include("fonctions/Session.php");

    if(isset($_POST['annule'])) {
        echo "ANNULE";
        update_etat_commande($_GET['num_commande'], "annule");
    }

    if(isset($_POST['en_cours'])) {
        echo "EN COURS";
        update_etat_commande($_GET['num_commande'], "en cours");
    }

    if(isset($_POST['en_attente'])) {
        echo "ATTENTE";
        update_etat_commande($_GET['num_commande'], "en attente");
    }

    if(isset($_POST['finie'])) {
        echo "FINIE";
        update_etat_commande($_GET['num_commande'], "finie");
    }

    $commandes = afficher_commandes_vendeur();
    /** Tableau $commandes
     * ['ID_Client']
     * ['nom_client']
     * ['prenom_client']
     * ['date_commande']
     * ['etat_commande']
     * ['adresse_livraison']
     * ['prix_total']
     */

    $produits = infos_produits();
    /** Tableau $produits
     * ['ID_Produit']
     * ['Nom_produit']
     * ['Prix_vente_HT']
     * ['Prix_vente_TTC']
     * ['Quantite_disponnible']
     * ['Moyenne_Note_Produit']
     * ['ID_Produit
     * ['Nom_produit']
     * ['Prix_coutant']
     * ['Prix_vente_HT']
     * ['Prix_vente_TTC']
     * ['Quantite_disponnible']
     * ['Description_produit']
     * ['images1']
     * ['images2']
     * ['images3']
     * ['Moyenne_Note_Produit ']
     * ['Id_Sous_Categorie ']
     * ['ID_Vendeur']
     */

    $_SESSION["vendeur"] = true;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendeur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="header-vendeur">
            <!-- TITRE ALIZON -->
            <a href="index.php" title="Accueil" class="logo">
                <img src="../img/logo2.0.png" alt="Logo Alizon" title="Logo Alizon" width='200' class="img_logo">
            </a>

            <nav class="nav-vendeur">

                <div class="dashboard-vendeur">
                    <i class="fa-solid fa-table-columns fa-xl"></i>
                    <p>Dashboard</p>
                </div>
                <hr>
                <div class="commandes-vendeur active">
                    <i class="fa-solid fa-bag-shopping fa-xl"></i>
                    <p>Commandes</p>
                </div>

                <div class="catalogue-vendeur">
                <i class="fa-solid fa-folder-open fa-xl"></i>
                    <p>Catalogue</p>
                </div>
                
                <form action="header_vendeur.php" method="post">
                    <div class="deconnexion-vendeur">
                        <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                        <input type="submit" value="Se déconnecter" name="deco_vendeur">
                    </div>
                </form>
            </nav>

            <div class="block_nom_vendeur">
                <h4>Compte Vendeur</h4>
                <p class="nom_vendeur">Lucas Vaugrente</p>
            </div>
            
    </header> 

    <main class="main-vendeur">

        <!--<section>
            <h1>Aperçu Général</h1>
            <p>Nombre de ventes</p>
            <p>Chiffre d'affaires d'Alizon</p>
            <p>Nombre de produits</p>
            <p>Ventes de la semaine</p>
            <p>Produits épuisés</p>
        </section>!-->
        <section class="commandes affiche">
            <h1>Commandes</h1>
            <hr>
            <div class=filtreCommande>
                <a class="tous active" onclick="myFunctionTous()" href="javascript:void(0);">Tous (4)</a>
                <a class="encours" onclick="myFunctionEnCours()" href="javascript:void(0);">En Cours (1)</a>
                <a class="attente" onclick="myFunctionEnAttente()" href="javascript:void(0);">En Attente (1)</a>
                <a class="terminé" onclick="myFunctionTerminer()" href="javascript:void(0);">Terminée (1)</a>
                <a class="annuler" onclick="myFunctionAnnuler()" href="javascript:void(0);">Annulée (1)</a>
            </div>

            <table id="myTable">
                <tr class="en-tete" id="en-tete">
                    <th><a  onclick="reset()" href="javascript:void(0);">N° </a></th>
                    <th><a  onclick="sortName()" href="javascript:void(0);">Client <i id="Nameicon" class="fas fa-sort"></i></a></th>
                    <th><a  onclick="sortDate()" href="javascript:void(0);">Date <i id="Dateicon" class="fas fa-sort"></i></a></th>
                    <th><a  onclick="sortEtat()" href="javascript:void(0);">Etats <i id="Etaticon" class="fas fa-sort"></i></a></th>
                    <th>Facturation</th>
                    <th><a  onclick="sortPrice()"  href="javascript:void(0);">Total <i id="priceicon" class="fas fa-sort"></i></a></th>
                </tr>

                <?php
                    for($i = 0 ; $i < count($commandes) ; $i++)
                    {
                        if($commandes[$i]["etat_commande"] == 'en cours')
                        {
                            $commande = $commandes[$i];
                            
                            echo "<tr class=cursor onclick=detailProduit(".($i+1).") href=javascript:void(0)". " id=c".($i+1).">";
                            echo "<td class=sort>#0" . $i+1 . "</th>";
                            echo "<td class=sort>" . "\n" . $commande["prenom_client"]. "\n" . $commande["nom_client"] . "</tf>";
                            echo "<td class=sort>" . dateFr($commande["date_commande"]) . "</th>";
                            echo "<td class=sort><div class='Etats-Encours'>En Cours</div></th>";
                            echo "<td class=sort>" . $commande["adresse_livraison"] . "</th>";
                            echo "<td class='prixtab sort'>" . "<p>" . $commande["prix_total"] . "</p>" . "\n€" . "</th>";
                            echo "</tr>";
                        }
                        elseif($commandes[$i]["etat_commande"] == 'finie')
                        {
                            $commande = $commandes[$i];
                            echo "<tr class=cursor onclick=detailProduit(".($i+1).") href=javascript:void(0)". " id=c".($i+1).">";
                            echo "<td class=sort>#0" . $i+1 ."</td>";
                            echo "<td class=sort>" . "\n" . $commande["prenom_client"]. "\n" . $commande["nom_client"] . "</td>";
                            echo "<td class=sort>" . dateFr($commande["date_commande"]) . "</td>";
                            echo "<td class=sort><div class='Etats-Termine'>Terminée</div>";
                            echo "<td class=sort>" . $commande["adresse_livraison"] . "</td>";
                            echo "<td class='prixtab sort'>" . "<p>" . $commande["prix_total"] . "</p>" . "\n€" . "</td>";
                            echo "</tr>";
                        }
                        elseif($commandes[$i]["etat_commande"] == 'en attente')
                        {
                            $commande = $commandes[$i];
                            echo "<tr class=cursor onclick=detailProduit(".($i+1).") href=javascript:void(0)". " id=c".($i+1).">";
                            echo "<td class=sort>#0" . $i+1 . "</td>";
                            echo "<td class=sort>" . "\n" . $commande["prenom_client"]. "\n" . $commande["nom_client"] . "</td>";
                            echo "<td class=sort>" . dateFr($commande["date_commande"]) . "</td>";
                            echo "<td class=sort><div class='Etats-EnAttente'>En Attente</div></td>";
                            echo "<td class=sort>" . $commande["adresse_livraison"] . "</td>";
                            echo "<td class='prixtab sort'>" . "<p>" . $commande["prix_total"] . "</p>" . "\n€" . "</td>";
                            echo "</tr>";
                        }
                        else
                        {
                            $commande = $commandes[$i];
                            echo "<tr class=cursor onclick=detailProduit(".($i+1).") href=javascript:void(0)". " id=c".($i+1).">";
                            echo "<td class=sort>#0" . $i+1 . "</td>";
                            echo "<td class=sort>" . "\n" . $commande["prenom_client"]. "\n" . $commande["nom_client"] . "</td>";
                            echo "<td class=sort>" . dateFr($commande["date_commande"]) . "</td>";
                            echo "<td class=sort><div class='Etats-Annuler'>Annuler</div></td>";
                            echo "<td class=sort>" . $commande["adresse_livraison"] . "</td>";
                            echo "<td class='prixtab sort'>" . "<p>" . $commande["prix_total"] . "</p>" . "\n€" . "</td>";
                            echo "</tr>";
                        }
                        

                    }
                   
                ?>
                
            </table>
            <table id="tableauP">
            <?php
                
                
                    echo "<tr id=headerP"." class='Detailcache en-teteP'>";
                    echo "<th>"."ID Produit"."</th>";
                    echo "<th>"."Nom produit"."</th>";
                    echo "<th>"."Quantité"."</th>";
                    echo "<th class='prixtab'>"."Prix"."</th>";
                    echo "</tr>";
                    for($i = 0 ; $i < count($commandes) ; $i++)
                    {
                        $produit = afficher_produit_vendeur($i+1);
                        /** Tableau $produit
                        * ['ID_Commande']
                        * ['ID_Produit']
                        * ['Nom_produit']
                        * ['Quantite']
                        * ['Prix_produit_commande_TTC']
                        */
                        

                        for($j = 0 ; $j< count($produit) ; $j++)
                        {
                        echo "<tr id=commande".($i+1)." class='Detailcache'>";
                        echo "<td>".$produit[$j]["ID_Produit"]."</td>";
                        echo "<td>".$produit[$j]["Nom_produit"]."</td>";
                        echo "<td>".$produit[$j]["Quantite"]."</td>";
                        echo "<td class='prixtab'>".$produit[$j]["Prix_produit_commande_TTC"]."€"."</td>";
                        echo "</tr>";
                        }
            
                    }
            ?>
            </table>

        </section>

        <section class="catalogue cache">
            <h1>Importer un catalogue</h1>
            <hr>
            <div class="block-ajoutCatalogue">
                <h3>Déposez un fichier csv</h3>
                <div id="drop-area">
                    <form enctype="multipart/form-data" action="insert_catalogue.php" method="post">
                        <div class="input-row">
                            <input class="importCSV" type="file" name="file" id="file" accept=".csv" pattern="\.csv" onchange="handleFiles(this.files)">
                            <div id="gallery"></div>
                            <button type="submit" id="submit" name="import">Importer</button>
                        </div>
                    </form>
                </div>
            </div>
            <h1>Liste des produits</h1>
            <hr>

            <table id="myTable produits">
                <tr class="en-tete">
                    <th>
                        <a  onclick="SortTableProduitsTri()" href="javascript:void(0);" class="id_produit">N°</a>
                        <i class="fa-solid fa-sort"></i>
                    </th>
                    <th>
                        <a  onclick="SortNameProduits()"  href="javascript:void(0);" class="nom_produit">Nom</a>
                        <i class="fa-solid fa-sort"></i>
                    </th>
                    <th>
                        <a  onclick="SortPrice(2)" href="javascript:void(0);" class="prixHT_produit">Prix HT</a>
                        <i class="fa-solid fa-sort"></i>
                    </th>
                    <th>
                        <a  onclick="SortPrice(3)" href="javascript:void(0);" class="prixTTC_produit">Prix TTC</a>
                        <i class="fa-solid fa-sort"></i>
                    </th>
                    <th>
                        <a onclick="SortPrice(4)" href="javascript:void(0);" class="stock_produit">Stock</a>
                        <i class="fa-solid fa-sort"></i>
                    </th>
                    <th>
                        <a  onclick="SortPrice(5)" href="javascript:void(0);" class="avis_produit">Avis (Sur 5)</a>
                    </th>
                </tr>
                
                <?php 
                    foreach($produits as $produit){

                        echo "<tr>";
                        if ($produit["ID_Produit"] < 10){
                            echo "<td>0" . $produit["ID_Produit"] . "</td>";
                        }
                        else
                        {
                            echo "<td>" . $produit["ID_Produit"] . "</td>";
                        }
                        echo "<td>" . "<a href =produit.php?idProduit=" . $produit["ID_Produit"]. ">" . $produit["Nom_produit"] ."</a> </td>";
                        echo "<td>" . "<p>" . $produit["Prix_vente_HT"] . "</p>" . " €" . "</td>";
                        echo "<td>" . "<p>" . $produit["Prix_vente_TTC"] . "</p>" ." €" . "</td>";
                        echo "<td>" . "<p>" . $produit["Quantite_disponnible"] . "</p>" . "</td>";
                        if ($produit["Moyenne_Note_Produit"] == ''){
                            echo "<td> Aucun Avis </td>";
                        }else{
                            echo "<td>" . $produit["Moyenne_Note_Produit"] . "</td>";
                        }

                        echo "</tr>";
                    }
                ?>
            </table>                

        </section>
    </main>
</body>
<script src="../js/filtrerCommandes.js"></script>
<script>
    let btn_Commandes_en_cours = document.querySelectorAll(".Etats-Encours");
    let btn_Commandes_Terminees = document.querySelectorAll(".Etats-Termine");
    let btn_Commandes_en_attente = document.querySelectorAll(".Etats-EnAttente");
    let btn_Commandes_annulees = document.querySelectorAll(".Etats-Annuler");
    let block_Changer1 = document.querySelector(".block_changer_etat1");
    let block_Changer2 = document.querySelector(".block_changer_etat2");
    let block_Changer3 = document.querySelector(".block_changer_etat3");
    let block_Changer4 = document.querySelector(".block_changer_etat4");


    btn_Commandes_en_cours.forEach(row => {
        row.addEventListener("mouseenter", () => {
            block_Changer1.style.display = "block";
        });

        row.addEventListener("mouseleave", () => {
            block_Changer1.style.display = "none";
        });
    });

    btn_Commandes_Terminees.forEach(row => {
        row.addEventListener("mouseenter", () => {
            block_Changer2.style.display = "block";
        });

        row.addEventListener("mouseleave", () => {
            block_Changer2.style.display = "none";
        }); 
    });

    btn_Commandes_en_attente.forEach(row => {
        row.addEventListener("mouseenter", () => {
            block_Changer3.style.display = "block";
        });

        row.addEventListener("mouseleave", () => {
            block_Changer3.style.display = "none";
        }); 
    });

    btn_Commandes_annulees.forEach(row => {
        row.addEventListener("mouseenter", () => {
            block_Changer4.style.display = "block";
        });

        row.addEventListener("mouseleave", () => {
            block_Changer4.style.display = "none";
        }); 
    });

    
    block_Changer1.addEventListener("mouseenter", () => {
        block_Changer1.style.display = "block";
    }); 

    block_Changer2.addEventListener("mouseenter", () => {
        block_Changer2.style.display = "block";
    }); 

    block_Changer3.addEventListener("mouseenter", () => {
        block_Changer3.style.display = "block";
    }); 

    block_Changer4.addEventListener("mouseenter", () => {
        block_Changer4.style.display = "block";
    }); 

    block_Changer1.addEventListener("mouseleave", () => {
        block_Changer1.style.display = "none";
    }); 

    block_Changer2.addEventListener("mouseleave", () => {
        block_Changer2.style.display = "none";
    }); 

    block_Changer3.addEventListener("mouseleave", () => {
        block_Changer3.style.display = "none";
    }); 

    block_Changer4.addEventListener("mouseleave", () => {
        block_Changer4.style.display = "none";
    }); 

</script>

</script><script src="https://momentjs.com/downloads/moment.min.js"></script>
</html>

