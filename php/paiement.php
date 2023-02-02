<?php 
    include("fonctions/Session.php");
    include("fonctions/fonctions.php");

    $result = infos_paiement($_COOKIE["id_panier"]);
    /** Tableau result contenant des tableau avec les param suivant :
     * [ID_Produit]
     * [ID_Panier]
     * [Quantite] 
     * [Prix_produit_commande_HT]
     * [Prix_produit_commande_TTC]
     * [Nom_produit]
     * [Prix_coutant]
     * [Prix_vente_HT]
     * [Prix_vente_TTC]
     * [Quantite_disponnible]
     * [Description_produit]
     * [images1]
     * [images2]
     * [images3]
     * [Moyenne_Note_Produit]
     * [Id_Sous_Categorie]
     * [ID_Vendeur]
     **/

    $prixTotal = prix_total_paiement($_COOKIE["id_panier"])["Prix_total_TTC"];
    
    $infos_cli = infos_cli($_SESSION["id_client"]);
    /**Tableau $infos_cli
     * [ID_Client]
     * [nom_client]
     * [prenom_client]
     * [adresse_livraison]
     * [adresse_facturation]
     * [date_de_naissance]
     * [email]
     * [mdp] 
     * [QuestionReponse]
     * [active]
    */
    
    if(isset($_POST['cardnumber'])){
        header("Location: confirmation.php?adrLivraison=".$_POST['adrLivraison']);
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réglement de la commande</title>

</head>
<body>
    <?php include("header.php"); ?>

    <main class="paiement">
        <h1>Récapitulatif de paiement</h1>
        <div class="carte_paiement">
            <section>
                <article class="carte_livraison">
                    <hr>
                    <aside><a href="monCompte.php">Modifier</a></aside>
                    <p>Adresse de facturation : <?php echo $infos_cli["adresse_facturation"] . "\n" ; ?></p>
                    <div class="adr_livraison_enr">
                        <input id="checkBoxLivraisonAdress" type="checkbox" checked>
                        <label> Utiliser l'adresse de livraison enregistrée</label>
                    </div>
                    <p id="SameLivraisonAdress">Adresse de Livraison : <?php echo $infos_cli["adresse_livraison"] . "\n" ; ?></p>
                    <p id="TexteLivraisonAdress">Adresse de Livraison : <input id="InputLivraisonAdress" type="text"></p>
                    <p>Destinataire : <?php echo $infos_cli["nom_client"] . "\n" . $infos_cli["prenom_client"]; ?></p>
                    <p>Email : <?php echo $infos_cli["email"];?></p>
                </article>

                <article class="carte_methode_paiement">
                    <hr>
                    <h2>Méthodes de paiement</h2>

                    <div class="btn-cb">
                        <i class="fa-solid fa-credit-card fa-xl"></i>
                        <p>Carte Bancaire</p>
                    </div>
                </article>

                <article class="CarteBancaire cache">
                    <div class="fermer-blocCB">
                        <i class="fa-solid fa-square-xmark fa-2x"></i>
                    </div>
                    <div class="col-75">
                        <div class="conteneur">
                            <form method="post" onsubmit="return VerificationCarteBleu();">
                                <div class="ligne">
                                    <div class="col-50">
                                    <div class="erreur_co">
                                        <p class="texte_erreur_co texte_erreur_cardnumber"></p>
                                        <p class="texte_erreur_co texte_erreur_dateCB"></p>
                                    </div>
                                        <h3>Paiement</h3>
                                        <label for="fname">Cartes acceptées</label>
                                        <div class="icon-conteneur">
                                            <i class="fa-brands fa-cc-visa"></i>
                                            <i class="fa-brands fa-cc-mastercard"></i>
                                            <i class="fa-brands fa-cc-stripe"></i>
                                            <i class="fa-brands fa-cc-jcb"></i>
                                            <i class="fa-brands fa-cc-discover"></i>
                                            <i class="fa-brands fa-cc-diners-club"></i>
                                            <i class="fa-brands fa-cc-amex"></i>
                                        </div>

                                        <label for="cname">Nom sur la carte</label>
                                        <input type="text" id="cname" name="cardname" placeholder="John More Doe" required>
                                    
                                        <label for="ccnum">Numéro de carte de crédit <i id="TypeCbPayement" class=""></i></label>
                                        <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" maxlength="19" required>

                                        <label for="expdate">Date d'expiration</label>
                                        <input type="month" id="dateCB" name="dateCB" placeholder="01/2023" required>
                                        
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="352" required>
                                        <input type="text" id="adrCommande" value="<?php echo $infos_cli["adresse_facturation"]; ?>" name="adrLivraison" >
                                    </div>
                                </div>
                                
                                
                                <input type="submit" id="BtnValiderPaiement" value="Valider le paiement" class="btn" >
                            </form>
                        </div>
                    </div>
                </article>
            </section>

            <aside class="carte_commande">
                <h2>Récapitulatif de la commande</h2>
                <h3><?php echo "Commande n°" . nb_commandes()+1; ?></h3>
                <div class="carte_commande--recap">
                    <p><?php echo sizeof($result);?> article(s)</p>
                    <p><?php echo $prixTotal." €";?></p>
                </div>
                <hr>
                <div class="carte_commande--recap">
                    <p>Livraison</p>
                    <p>offerte</p>
                </div>
                <hr>
                <div class="carte_commande--total">
                    <h4>Total : </h4>
                    <h4><?php echo $prixTotal." €";?></h4>
                </div>
                <aside>
                    En passant votre commande, Vous acceptez les <a href="#">Conditions générales de ventes</a> de Alizon.
                </aside>
            </aside>
        </div>
    </main>
    <footer>
        <?php include("footer.php"); ?>
        <script>
        /**######################################## ADRESSE DE LIVRAISON ########################################**/
        // RECUPERATION DES ELEMENTS HTML
        var checkBoxLivraisonAdress = document.getElementById("checkBoxLivraisonAdress");
        var SameLivraisonAdress = document.getElementById("SameLivraisonAdress");
        var InputLivraisonAdress = document.getElementById("InputLivraisonAdress");
        var TexteLivraisonAdress = document.getElementById("TexteLivraisonAdress");
        var adrCommande = document.getElementById("adrCommande");

        // CHAMPS D'ADRESSE CACHE PAR DEFAULT
        adrCommande.style.display = "none";
        TexteLivraisonAdress.style.display = "none";
        
        checkBoxLivraisonAdress.addEventListener("change", function(event){    
            if (!checkBoxLivraisonAdress.checked){
                //Bloc découvert si l'adresse de livraison est saisie manuellement
                SameLivraisonAdress.style.display = "none";
                TexteLivraisonAdress.style.display = "block";

                //recupération de l'adresse a prendre en compte
                adrCommande.value = InputLivraisonAdress.value;
            } else {
                //Bloc caché si la meme adresse de facturation est utilisé
                TexteLivraisonAdress.style.display = "none";
                SameLivraisonAdress.style.display = "block";

                //recupération de l'adresse a prendre en compte
                adrCommande.value = "<?php echo $infos_cli["adresse_facturation"]; ?>"; 
            }
        });

        InputLivraisonAdress.addEventListener("blur", function(event){    
            adrCommande.value = InputLivraisonAdress.value;
        });

        /**######################################## CARTE BANCAIRE ########################################**/
        // RECUPERATION DES ELEMENTS HTML
        var btnCB = document.querySelector(".btn-cb");
        var blocPaiement = document.querySelector(".CarteBancaire");
        var CroixPaiement = document.querySelector(".fermer-blocCB");

        btnCB.addEventListener("click", ouvrirBlocPaiement);
        CroixPaiement.addEventListener("click", fermerBlocPaiement);

        function ouvrirBlocPaiement(){
            blocPaiement.classList.remove("cache");
            btnCB.classList.add("cache");
        }

        function fermerBlocPaiement(){
            blocPaiement.classList.add("cache");
            btnCB.classList.remove("cache");
        }

    </script>
        <script src="../js/paiement.js"></script>
    </footer>
</body>

</html>

