-- Active: 1738686534022@@127.0.0.1@3333
/*

#####################Table#####################
_Categorie:60
_Sous_Categorie:67
_produit:78
_QuestionSecrete:98
_Client:106
_Panier:123
_Commande:135
_contient_produit_p:149
_contient_produit_c:163
_avis:177
_paiement:192
_Vendeur:207
_signaler:216


####################Trigger####################
trig_Commande:252
trig_Pannier:274
trig_id_client:295
trig_id_panier:324
trig_TVA_produit:348
trig_Moyenne_Note_produit:366
trig_Moyenne_Note_produit2:385
trig_Calcul_PrixTotal_produit1:404
trig_Calcul_PrixTotal_produit2:424
trig_Calcul_Total_Panier1:444
trig_Calcul_Total_Panier2:463
trig_Calcul_Total_Panier3:482
trig_Calcul_Signalement:500
trig_Commande_date:513
trig_id_avis:539
#####################View######################
panier:530
catalogue:541
---------------------------------------------------------------------------------------------------------------
*/

/*################################################################################################
######################################## CREATION DE LA BASE #####################################
##################################################################################################*/

drop schema alizon;
create schema alizon;
use alizon;
 /* ################################################################################################
######################################## CREATION DE TABLES ########################################
###################################################################################################*/

/* TABLE CATEGORIE */
CREATE TABLE _categorie (
  ID_Categorie int(11) auto_increment not null,
  Nom_Categorie varchar(50),
  constraint _Categorie_pk primary key (ID_Categorie)
);

/* TABLE SOUS CATEGORIE */
CREATE TABLE _sous_categorie (
  Id_Sous_Categorie int(11) auto_increment not null,
  Id_Categorie_Sup int(11) not null,
  nom varchar(50) not null,
  tva float not null,
  constraint Sous_Categorie_pk primary key (Id_Sous_Categorie),
  constraint _Sous_Categorie_Categorie foreign key (Id_Categorie_Sup)
    references _categorie(ID_Categorie)
);

/* TABLE PRODUIT */
CREATE TABLE _produit (
    ID_produit INT(11) AUTO_INCREMENT NOT NULL,
    Nom_produit VARCHAR(50),
    Prix_coutant DECIMAL(5 , 2 ),
    Prix_vente_HT NUMERIC(5 , 2 ),
    Prix_vente_TTC NUMERIC(5 , 2 ),
    Quantite_disponnible INT,
    Description_produit VARCHAR(10000),
    images1 VARCHAR(500),
    images2 VARCHAR(500),
    images3 VARCHAR(500),
    Moyenne_Note_produit INT(11),
    Id_Sous_Categorie INT(11) NOT NULL,
    ID_Vendeur INT NOT NULL,
    CONSTRAINT _produit_pk PRIMARY KEY (ID_produit),
    CONSTRAINT _produit_Sous_Categorie_fk FOREIGN KEY (Id_Sous_Categorie)
        REFERENCES _sous_categorie (Id_Sous_Categorie)
);

/* TABLE CLIENT */
CREATE TABLE _client(
  ID_Client int(11) auto_increment not null,
  nom_client varchar(50) not null,
  prenom_client varchar(50) not null,
  date_de_naissance date not null,
  email varchar(50) not null,
  mdp varchar(500) not null, 
  QuestionReponse varchar(500) not null,
  active integer DEFAULT 1,
  constraint _Client_pk primary key (ID_Client)
);

/* TABLE Adresse */
CREATE TABLE _adresse (
  ID_Adresse int(11) auto_increment not null,
  ID_Client int(11) not null,
  nom_de_rue varchar(50) not null, 
  complement varchar(50), 
  ville varchar(50) not null,
  code_postale varchar(10) not null,
  adresse_facturation BOOLEAN not null,
  constraint _Adresse_pk primary key (ID_Adresse),
  constraint _Adresse_Client_fk foreign key (ID_Client)
    references _client(ID_Client)
);

/* TABLE PANIER */
CREATE TABLE _panier (
  ID_Panier int(11) auto_increment not null,
  Prix_total_HT numeric(5,2),
  Prix_total_TTC numeric(5,2),
  ID_Client int(11),
  derniere_modif date,
  constraint _Panier_pk primary key (ID_Panier),
  constraint _Panier_Client_fk foreign key (ID_Client)
    references _client(ID_Client)
);

/* TABLE COMMANDE */
CREATE TABLE _commande (
  ID_Commande int(11) auto_increment not null,
  ID_Client int(11) not null,
  nom_de_rue_livraison varchar(50) not null, 
  complement_livraison varchar(50), 
  ville_livraison varchar(50) not null,
  code_postale_livraison varchar(10) not null,
  nom_de_rue_facturation varchar(50) not null, 
  complement_facturation varchar(50), 
  ville_facturation varchar(50) not null,
  code_postale_facturation varchar(10) not null,
  date_commande date ,
  date_livraison date,
  Duree_maximale_restante int,
  prix_total numeric(5,2),
  constraint _Commande_pk primary key (ID_Commande),
  constraint _Commande_Client_fk foreign key (ID_Client)
    references _client (ID_Client)
);

/* TABLE CONTIENT PRODUIT PANIER */
CREATE TABLE _contient_produit_p (
  ID_Panier int(11) not null, -- Différent
  ID_produit int(11) not null,
  Quantite int(11),
  Prix_produit_commande_HT float not null,
  Prix_produit_commande_TTC float not null,
  constraint _contient_produit_p_pk primary key (ID_Panier,ID_produit),
  constraint _contient_produit_p_Panier_fk foreign key (ID_Panier)
    references _panier(ID_Panier) ON DELETE CASCADE, -- ON DELETE CASCADE delete les contitent produit d'un panier si le panier est delete
  constraint _contient_produit_p_produit_fk foreign key (ID_produit)
    references _produit(ID_produit)
);

/* TABLE CONTIENT PRODUIT COMMANDE */
CREATE TABLE _contient_produit_c (
  ID_Commande int(11) not null, -- Différent
  ID_produit int(11) not null,
  etat_produit_c VARCHAR(50),
  Quantite int(11),
  Prix_produit_commande_HT float not null,
  Prix_produit_commande_TTC float not null,
  constraint _contient_produit_c_pk primary key (ID_Commande,ID_produit),
  constraint _contient_produit_c_Commande_fk foreign key (ID_Commande)
    references _commande(ID_Commande),
  constraint _contient_produit_c_produit_fk foreign key (ID_produit)
    references _produit(ID_produit)
);

/* TABLE AVIS */
CREATE TABLE _avis (
  ID_Commentaire int(11) auto_increment not null,
  ID_Client int(11) not null,
  ID_produit int(11) not null,
  Note_produit int(11) not null,
  Commentaire varchar(500),
  Image_avis varchar(500),
  signalement int default 0,
  constraint _avis_pk primary key (ID_Commentaire),
   constraint _avis_produit_fk foreign key (ID_produit)
    references _produit(ID_produit),
  constraint _avis_Client_fk foreign key (ID_Client)
    references _client(ID_Client)
);

/* TABLE VENDEUR */
CREATE TABLE _vendeur (
  ID_Vendeur int(11) auto_increment not null,
  Nom_vendeur varchar(50) not null,
  Raison_sociale varchar(50) not null,
  Email varchar(50) not null,
  nom_de_rue varchar(50) not null, 
  complement varchar(50), 
  ville varchar(50) not null,
  code_postale varchar(10) not null,
  TVA varchar(50) not null,
  Siret varchar(50) not null,
  mdp varchar(100) not null,
  logo varchar(500),
  texte_Presentation varchar(10000),
  note varchar(1000),
  constraint _Vendeur_pk primary key (ID_Vendeur)
);

CREATE TABLE _reponse(
  ID_Commentaire int(11) not null,
  ID_Vendeur int(11),
  Commentaire varchar(500),
  constraint _reponse_pk primary key (ID_Commentaire),
   constraint _reponse_avis_fk foreign key (ID_Commentaire)
    references _avis(ID_Commentaire),
  constraint _reponse_Client_fk foreign key (ID_Vendeur)
    references _vendeur(ID_Vendeur)
);

/* TABLE paiement */
CREATE TABLE _paiement (
  ID_Commande int(11) not null,
  ID_Client int(11) not null,
  choix_type_paiement varchar(50) not null,
  numero_carte varchar(50) not null,
  date_carte date,
  cryptogramme int,
  constraint _paiement_pk primary key (ID_Commande,ID_Client),
  constraint _paiement_Commande_fk foreign key (ID_Commande)
    references _commande(ID_Commande),
  constraint _paiement_Client_fk foreign key (ID_Client)
    references _client(ID_Client)
);



/* TABLE SIGNALER*/
CREATE TABLE _signaler (
  ID_Signaleur int(11) not null,  
  ID_Commentaire int(11) not null,
  constraint _signaler_pk primary key (ID_Signaleur,ID_Commentaire),
  constraint _Posteur_fk foreign key (ID_Commentaire)
    references _avis(ID_Commentaire) ON DELETE CASCADE,
  constraint _Signaleur_fk foreign key (ID_Signaleur)
    references _client(ID_Client)
);


/* ##############################################################################################################
######################################## CREATION DE FONCTIONS & TRIGGER ########################################
#################################################################################################################*/

-- Declaration des delimiter pour les trigger important pour que la syntaxe de begin et end fonctionne
DELIMITER @@; 

/* -Lorsque le client creer un compte, le panier est créer
Ce trigger s'active lors de la creation d'une commande

Debut Boucle la boucle va parcourir tous les id produit de la table _produit pour verifier si il existe dans  _contient_produit_p
et de pouvoir les ajouter dans la table _contient_produit_c

Premierement le trigger recupere tous les produit du panier du client X dans des variable
@id_produit l'identifiant des produit
@Quantite la quantite acheter
@Prix_produit_commande_HT le prix des produits X hors taxe
@Prix_produit_commande_TTC le prix des produits X avec taxe

Deuxiement il insert dans la table _contient_produit_c le produit X si il existe dans le panier du client X

Fin de boucle

Aprés avoir insert dans _contient_produit_c le trigger suprime le pannier du client Xalizon
*/
CREATE TRIGGER trig_Commande3
after INSERT on _commande
FOR EACH ROW
BEGIN
set @i =1 ;
while @i <= (select max(id_produit) from _produit) do
	set @id_produit = (select id_produit from _contient_produit_p where _contient_produit_p.ID_Panier in (select ID_Panier from _panier where ID_Client = new.ID_Client) and _contient_produit_p.id_produit =@i);
	set @Quantite = (select Quantite from _contient_produit_p where _contient_produit_p.ID_Panier in (select ID_Panier from _panier where ID_Client = new.ID_Client) and _contient_produit_p.id_produit =@i);
	set @Prix_produit_commande_HT = (select Prix_produit_commande_HT from _contient_produit_p where _contient_produit_p.ID_Panier in (select ID_Panier from _panier where ID_Client = new.ID_Client) and _contient_produit_p.id_produit =@i);
	set @Prix_produit_commande_TTC = (select Prix_produit_commande_TTC from _contient_produit_p where _contient_produit_p.ID_Panier in (select ID_Panier from _panier where ID_Client = new.ID_Client) and _contient_produit_p.id_produit =@i);
	if @id_produit is not null then
		INSERT INTO _contient_produit_c(ID_Commande,id_produit, etat_produit_c, quantite,Prix_produit_commande_HT,Prix_produit_commande_TTC)VALUES(new.Id_Commande,@id_produit, "acceptee",@Quantite,@Prix_produit_commande_HT,@Prix_produit_commande_TTC);
	END IF;
	set @i = @i+1;
END WHILE;
DELETE from _panier where ID_Client = New.ID_Client;
INSERT INTO _panier (id_client,prix_total_ht,prix_total_ttc)VALUES(new.id_client,0.00,0.00);
END;
@@;

/* -Lors de la creation d'un client 
Lors de la creation d'un nouveau client le trigger lui assigne un nouveau pannier
*/
CREATE TRIGGER trig_Pannier
after INSERT on _client
FOR EACH ROW
BEGIN
INSERT INTO _panier (id_client,prix_total_ht,prix_total_ttc)VALUES(new.id_client,0.00,0.00);
END;
@@;

/* -Lors de la creation d'un client 
Ce trigger verifie si des id ont etais liberer avant auto_increment

Les variables:
@i idClient tester 
@modif bolean qui verifie si un client a reçu sont ID

Debut boucle la boucle continuras tant que @i n'est pas arriver au plus grand @id de la classe _Client ou quand le bolean modif sera a true

Si le nombre de client pour ID_Client @i = 0 alors id est libre et le set dans le new.CLIENT

Fin boucle
*/
CREATE TRIGGER trig_id_client
before INSERT on _client
FOR EACH ROW
BEGIN
set @i =1;
set @modif =0;
while @i< (select max(ID_Client) from _client) && @modif = 0 do
	if (select count(*) from _client where Id_Client = @i) = 0 then
		set New.Id_Client = @i;
		set @modif =1;
	end if;
	set @i= @i+1;
end while;
END;
@@;

/* -Lors de la creation d'un panier 
Ce trigger verifie si des id ont etais liberer avant auto_increment

Les variables:
@i idPanier tester 
@modif bolean qui verifie si un panier a reçu sont ID

Debut boucle la boucle continuras tant que @i n'est pas arriver au plus grand @id de la classe _panier ou quand le bolean modif sera a true

Si le nombre de panier pour ID_Panier @i = 0 alors id est libre et le set dans le new.panier

Fin boucle
*/
CREATE TRIGGER trig_id_panier
before INSERT on _panier
FOR EACH ROW
BEGIN
set @i =1;
set @modif =0;
while @i< (select max(ID_Panier) from _panier) && @modif = 0 do
	if (select count(*) from _panier where Id_Panier = @i) = 0 then
		set New.Id_Panier = @i;
		set @modif =1;
	end if;
	set @i= @i+1;
end while;
END;
@@;

/* -Lors de la creation d'un produit
Ce trigger Calcul le prix avec taxe d'un produit

variables:
@tva_n recupere la tva du produit X par son Id_Sous_Categorie

set Prix_vente_TTC avec le resultat de la formule de calcule de Prix TTC : (PrixHT*TVA)+PRIXHT
*/
CREATE TRIGGER trig_TVA_produit
before INSERT on _produit
FOR EACH ROW
BEGIN 
set @tva_n := (SELECT tva from _sous_categorie where _sous_categorie.Id_Sous_Categorie = new.Id_Sous_Categorie); 
set new.Prix_vente_TTC := (@tva_n*new.prix_vente_ht) + new.prix_vente_ht;
END;
@@;

/* -Lors de la creation d'un avis
Ce trigger calcule la moyenne d'un produit lorsque qu'un avis est ajouter

Variables:
@somme somme des notes donner par les clients
@compte Nombre de clients ayant donner une note

mes a jour dans la table _produit Moyenne_Note_produit @somme/@compte pour le produit X
*/
CREATE TRIGGER trig_Moyenne_Note_produit
after INSERT on _avis
FOR EACH ROW
BEGIN
set @somme := (select sum(Note_produit) from _avis WHERE new.ID_produit = ID_produit);
set @compte := (select count(Note_produit) from _avis WHERE new.ID_produit = ID_produit);
UPDATE _produit SET Moyenne_Note_produit = (@somme/@compte) WHERE new.ID_produit = ID_produit;
END;
@@;

/* -Lors de la suppresion d'un avis
Ce trigger calcule la moyenne d'un produit lorsque qu'un avis est suprimer

Variables:
@somme somme des notes donner par les clients
@compte Nombre de clients ayant donner une note

mais a jour dans la table _produit Moyenne_Note_produit @somme/@compte pour le produit X
*/
CREATE TRIGGER trig_Moyenne_Note_produit2
after delete on _avis
FOR EACH ROW
BEGIN
set @somme := (select sum(Note_produit) from _avis WHERE old.ID_produit = ID_produit);
set @compte := (select count(Note_produit) from _avis WHERE old.ID_produit = ID_produit);
UPDATE _produit SET Moyenne_Note_produit = (@somme/@compte) WHERE old.ID_produit = ID_produit;
END;
@@;

/* -Lors de l' ajout d'un produit dans le panier
Ce trigger calcule le prix totale TCC et HT du produit avec la quantite

Variables:
@prixht prix total ht
@prixttc prix total ttc

set les nouveaux totaux dans _contient_produit_p
*/
CREATE TRIGGER trig_Calcul_PrixTotal_produit1
BEFORE INSERT ON _contient_produit_p
FOR EACH ROW
BEGIN
set @prixht := (SELECT prix_vente_ht FROM _produit WHERE _produit.id_produit = NEW.id_produit);
set @prixttc := (SELECT prix_vente_ttc FROM _produit WHERE _produit.id_produit = NEW.id_produit);
set new.Prix_produit_commande_HT := @prixht*new.quantite;
set new.Prix_produit_commande_TTC := @prixttc*new.quantite;
END;
@@;

/* -Lors d'une modification d'un produit dans le panier
Ce trigger calcule le prix totale TCC et HT avec la quantite

Variables:
@prixht prix total ht
@prixttc prix total ttc

set les nouveaux totaux dans _contient_produit_p
*/
CREATE TRIGGER trig_Calcul_PrixTotal_produit2
BEFORE UPDATE ON _contient_produit_p
FOR EACH ROW
BEGIN
set @prixht := (SELECT prix_vente_ht FROM _produit WHERE _produit.id_produit = NEW.id_produit);
set @prixttc := (SELECT prix_vente_ttc FROM _produit WHERE _produit.id_produit = NEW.id_produit);
set new.Prix_produit_commande_HT := @prixht*new.quantite;
set new.Prix_produit_commande_TTC := @prixttc*new.quantite;
END;
@@;

/* -Lors de l' ajout d'un produit dans le panier
Ce trigger calcule le prix totale TCC et HT du panier

Variables:
@Somprixht prix total ht
@Somprixttc prix total ttc

set les nouveaux totaux dans _panier
*/
CREATE TRIGGER trig_Calcul_Total_Panier1
after INSERT on _contient_produit_p
FOR EACH ROW
BEGIN
SET @Somprixht := (SELECT sum(prix_produit_commande_ht) FROM _contient_produit_p WHERE id_panier = NEW.id_panier);
SET @Somprixttc := (SELECT sum(prix_produit_commande_ttc) FROM _contient_produit_p WHERE id_panier = NEW.id_panier);
UPDATE _panier SET prix_total_ht = @Somprixht, prix_total_ttc = @Somprixttc, derniere_modif = NOW() WHERE id_panier = NEW.id_panier;
END;
@@;

/* -Lors de modification d'un produit dans le panier
Ce trigger calcule le prix totale TCC et HT du panier

Variables:
@Somprixht prix total ht
@Somprixttc prix total ttc

set les nouveaux totaux dans _panier
*/
CREATE TRIGGER trig_Calcul_Total_Panier2
after update on _contient_produit_p
FOR EACH ROW
BEGIN
SET @Somprixht := (SELECT sum(prix_produit_commande_ht) FROM _contient_produit_p WHERE id_panier = NEW.id_panier);
SET @Somprixttc := (SELECT sum(prix_produit_commande_ttc) FROM _contient_produit_p WHERE id_panier = NEW.id_panier);
UPDATE _panier SET prix_total_ht = @Somprixht, prix_total_ttc = @Somprixttc, derniere_modif = NOW() WHERE id_panier = NEW.id_panier;
END;
@@;

/* -Lors de la suppresion d'un produit dans le panier
Ce trigger calcule le prix totale TCC et HT du panier

Variables:
@Somprixht prix total ht
@Somprixttc prix total ttc

set les nouveaux totaux dans _panier
*/
CREATE TRIGGER trig_Calcul_Total_Panier3
after delete on _contient_produit_p
FOR EACH ROW
BEGIN
SET @Somprixht := (SELECT sum(prix_produit_commande_ht) FROM _contient_produit_p WHERE id_panier = old.id_panier);
SET @Somprixttc := (SELECT sum(prix_produit_commande_ttc) FROM _contient_produit_p WHERE id_panier = old.id_panier);
UPDATE _panier SET prix_total_ht = @Somprixht, prix_total_ttc = @Somprixttc, derniere_modif = NOW() WHERE id_panier = old.id_panier;
END;
@@;

/* -Lors de l'ajout d'un signalment
Ce trigger compte le nombre de signalement

Variables:
@nbs nombre de signalement avant l'ajout du nouveau

set les total de signalement dans avis
*/
CREATE trigger trig_Calcul_Signalement
after insert on _signaler
FOR EACH ROW
BEGIN
set @nbs = (select signalement from _avis where ID_Commentaire = new.ID_Commentaire);
UPDATE _avis SET signalement = @nbs+1   where ID_Commentaire = new.ID_Commentaire;
END;
@@;

/* -Lors de l'ajout d'une commande
Ce trigger automatise les date de livraison

Variable:
@date date courrante
*/
CREATE trigger trig_Commande_date
before insert on _commande
for each row
BEGIN
set @date = (SELECT curdate());
set new.date_commande = @date;
set new.date_livraison = (select date_sub(curdate(),interval -30 day));
set new.Duree_maximale_restante = (SELECT DATEDIFF(new.date_livraison, new.date_commande));
set new.prix_total = (select sum(Prix_produit_commande_TTC) from _contient_produit_p where _contient_produit_p.ID_Panier in (select ID_Panier from _panier where ID_Client = new.ID_Client));
END;
@@;

/* -Lors de la creation d'un panier 
Ce trigger verifie si des id ont etais liberer avant auto_increment
Et que le client n'a pas déjà donnes son avis

Les variables:
@i idcommentaire tester 
@modif bolean qui verifie si un avis a reçu sont ID

Debut boucle la boucle continuras tant que @i n'est pas arriver au plus grand @id de la classe _avis ou quand le bolean modif sera a true

Si le nombre de panier pour ID_Commentaire @i = 0 alors id est libre et le set dans le new.avis

Fin boucle
*/
CREATE TRIGGER trig_id_avis
before INSERT on _avis
FOR EACH ROW
BEGIN
set @i =1;
set @modif =0;
if (select count(*) from _avis where ID_Client=new.ID_Client and ID_produit = new.ID_produit) = 0 then
while @i< (select max(ID_Commentaire) from _avis) && @modif = 0 do
	if (select count(*) from _avis where ID_Commentaire = @i) = 0 then
		set New.ID_Commentaire = @i;
		set @modif =1;
	end if;
	set @i= @i+1;
end while;
else
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Cette personne a déjà donner son avis !';
End if;
END;
@@;

/* ###############################################################################################
######################################## CREATION DE VUES ########################################
##################################################################################################*/

CREATE OR REPLACE View panier AS
SELECT nom_produit,images1, images2, images3, _contient_produit_p.id_produit,nom_categorie,quantite_disponnible,quantite,prix_total_ttc, prix_produit_commande_ttc, Nom_vendeur as vendeur , description_produit, _panier.id_panier, prix_vente_ttc, _sous_categorie.nom as nom_SouCategorie  FROM _contient_produit_p 
INNER JOIN _produit ON _produit.id_produit = _contient_produit_p.id_produit
INNER JOIN _sous_categorie ON _sous_categorie.Id_Sous_Categorie = _produit.id_sous_categorie
INNER JOIN _categorie ON _categorie.id_categorie = _sous_categorie.Id_categorie_sup
INNER JOIN _vendeur ON _vendeur.id_vendeur = _produit.id_vendeur
INNER JOIN _panier ON _contient_produit_p.id_panier = _panier.id_panier;




CREATE OR REPLACE View catalogue AS
SELECT id_produit, nom_produit, prix_vente_ht, prix_vente_ttc, quantite_disponnible, description_produit, images1, images2, images3,ID_Vendeur, nom as nom_souscategorie, nom_categorie, moyenne_note_produit FROM _produit
INNER JOIN _sous_categorie ON _sous_categorie.Id_Sous_Categorie = _produit.id_sous_categorie
INNER JOIN _categorie ON _categorie.id_categorie = _sous_categorie.id_categorie_sup;



/* ###################################################################################################
######################################## INSERTION DE DONNEES ########################################
######################################################################################################*/

insert into _vendeur (Nom_vendeur,Raison_sociale,Email,nom_de_rue,complement,ville,code_postale,TVA,Siret,mdp,logo,texte_Presentation,note) values ('Totale','TotaleProduit', 'totale@gmail.com', '1 rue des potillé',NULL,'Ecommoy',72220, 'FR59542051180','542051180','277 474 277 605 426 312 407 268 442 605 117 426 23 471 474 442','img1','TOTAL est la 4ème compagnie de denrée alimentaire Bretonne (sur la base de la capitalisation boursière). aval ( trading et transport maritime de produits alimentaires et de produits agricoles, distribution).','Totale est une entreprise Bretonne totalement écologique, qui cultivie des produits BIO sans pesticide');
insert into _vendeur (Nom_vendeur,Raison_sociale,Email,nom_de_rue,complement,ville,code_postale,TVA,Siret,mdp,logo,texte_Presentation,note) values ('Alpinne','AlpinneCorp', 'alpinne@gmail.com', '24 rue des voitures',NULL,'Le mans',72220, 'FR34489786343','489786343','605 426 224 117 384 384 312 407 268 442 605 117 426 23 471 474 442','img1','Notre entreprise Alpine, appelée "Alpes Gourmandes", est spécialisée dans la vente de produits alimentaires de qualité issus de la région alpine. Nous travaillons en étroite collaboration avec des producteurs locaux pour offrir à nos clients des produits frais, savoureux et écologique','Alpine est une entreprise dynamique qui se dévoue à fournir des produits alimentaires de qualité supérieure à ses clients. En se concentrant sur les ingrédients locaux, Alpine offre des produits frais et de saison qui répondent aux normes les plus élevées en matière de qualité et de durabilité.');
insert into _vendeur (Nom_vendeur,Raison_sociale,Email,nom_de_rue,complement,ville,code_postale,TVA,Siret,mdp,logo,texte_Presentation,note) values ('Picardddd','PicardIndustrie', 'pica@gmail.com', '11 rue des surgelés',NULL,'Paris',75000, 'FR31784939688','784939688',' 224 117 471 605 407 268 442 605 117 426 23 471 474 442','img1','Picard est une entreprise bien établie dans le domaine des produits surgelés, qui se distingue par son large choix de produits de qualité. Avec plus de 1 000 produits différents, Picard offre une variété de plats, de desserts et de collations pour répondre aux besoins de ses clients.','Picard est une entreprise qui se dévoue à fournir des produits de qualité exceptionnelle à ses clients. Grâce à sa large sélection de produits,picardddd offre une grande variété de denrée pour tous les goûts et tous les besoins.');
insert into _vendeur (Nom_vendeur,Raison_sociale,Email,nom_de_rue,complement,ville,code_postale,TVA,Siret,mdp,logo,texte_Presentation,note) values ('LVP','LuisPasViton', 'lVP@gmail.com', 'Zone industrielle des peupliers','Batiment D','Marseille',13000, 'FR15347662454','347662454','426 189 567 407 268 442 605 117 426 23 471 474 442','img1','LuisPasViton est une entreprise renommée dans le domaine alimentaire, qui se dévoue à fournir des produits de qualité exceptionnelle à ses clients. Grâce à leur expertise en matière de luxe, Louis Vuitton offre une gamme de produits culinaires haut de gamme, qui allient qualité et raffinement.','LuisPasViton est une entreprise qui se dévoue à fournir une expérience gastronomique de luxe à ses clients. Grâce à leur savoir-faire et leur engagement envers la qualité, ils proposent une gamme de produits alimentaires haut de gamme qui allient saveurs raffinées et ingrédients de qualité exceptionnelle.');

insert into _vendeur (Nom_vendeur,Raison_sociale,Email,nom_de_rue,complement,ville,code_postale,TVA,Siret,mdp,logo,texte_Presentation,note) values ('Kribi', 'KribiCorp','Kribi@gmail.com', '7 Rue Jean Marie',NULL,'Plounévézels',29270, 'FR17327652457','276183130','407 277 474 277 474 277 605 277 605','img1','Bienvenue chez Le Kribi, votre destination de choix pour des vêtements de Bretagne de haute qualité. Nous sommes une entreprise fièrement bretonne, spécialisée dans la vente de vêtements inspirés de la culture et des traditions de notre belle région.Notre collection de vêtements pour hommes, femmes et enfants est conçue avec soin pour offrir un confort optimal tout en mettant en avant le patrimoine breton. Nous proposons des designs modernes et élégants, ainsi que des pièces plus traditionnelles qui célèbrent les symboles et les légendes de la Bretagne.Chez Le Kribi, nous sommes attachés à la qualité de nos produits et à la satisfaction de nos clients. Nous travaillons avec des fournisseurs locaux pour garantir que nos vêtements sont fabriqués avec les meilleurs matériaux et les techniques les plus avancées. Nous sommes également engagés dans des pratiques éthiques et durables pour préserver notre environnement.Nous sommes fiers de faire partie de la communauté bretonne et sommes heureux de partager notre passion pour notre culture à travers nos vêtements. Nous espérons que vous trouverez chez Le Kribi des pièces qui vous accompagneront avec fierté dans votre quotidien.',"Nous sommes heureux de vous annoncer que notre entreprise, Le Kribi, se spécialise désormais dans la vente de vêtements bretons. Notre passion pour la Bretagne et son patrimoine nous a poussés à créer une collection unique qui saura satisfaire vos besoins en matière de mode et d'authenticité.");



INSERT INTO _client (nom_client, prenom_client, date_de_naissance, email, mdp, QuestionReponse) VALUES ('Portier', 'Loane', '2003-12-15', 'paprika@gmail.com', '224 605 224 321 117 19 605 407 268 442 605 117 426 23 471 474 442', 'Gardeur');
INSERT INTO _client (nom_client, prenom_client, date_de_naissance, email, mdp, QuestionReponse) VALUES ('Titouan', 'Laughren', '2002-05-24', 'TitouanRobe@gmail.com', '548 117 277 474 3 605 384 669 474 501 312 407 268 442 605 117 426 23 471 474 442', 'Rennes');
INSERT INTO _client (nom_client, prenom_client, date_de_naissance, email, mdp, QuestionReponse) VALUES ('Maincent', 'Oscar', '2003-01-05', 'OscarMaincent@gmail.com', '548 117 277 474 3 605 384 669 474 501 312 407 268 442 605 117 426 23 471 474 442', 'Saint-Martin');
INSERT INTO _client (nom_client, prenom_client, date_de_naissance, email, mdp, QuestionReponse) VALUES ('Demany', 'Theo', '2003-10-01', 'TheoDemany@gmail.com', '548 261 312 474 68 312 442 605 384 386 407 268 442 605 117 426 23 471 474 442', 'Audi');

INSERT into _adresse (ID_Client,nom_de_rue, complement, ville, code_postale, adresse_facturation) values (1,"1 Rue édouard Branly",NULL,"Lannion","22300",TRUE);
INSERT into _adresse (ID_Client,nom_de_rue, complement, ville, code_postale, adresse_facturation) values (1,"11 chemin de traverse",NULL,"Guingamp","22200",TRUE);
INSERT into _adresse (ID_Client,nom_de_rue, complement, ville, code_postale, adresse_facturation) values (2,"45 Avenue Fosh","11e arrondissement","Paris","75111",TRUE);
INSERT into _adresse (ID_Client,nom_de_rue, complement, ville, code_postale, adresse_facturation) values (3,"29 rue cherbourg","3e Arrondissement","Paris","75003",TRUE);
INSERT into _adresse (ID_Client,nom_de_rue, complement, ville, code_postale, adresse_facturation) values (4,"Résidence de la haute rive","Batiment D","Lannion","22300",TRUE);


INSERT into _categorie (nom_categorie) values ('Epicerie');
INSERT into _categorie (nom_categorie) values ('Boissons');
INSERT into _categorie (nom_categorie) values ('Vêtements');
INSERT into _categorie (nom_categorie) values ('Souvenirs');
INSERT into _categorie (nom_categorie) values ('Produits frais');


INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(1,'Gateaux',0.10);
INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(1,'Déjeuner',0.10);

INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(2,'Soda',0.10);
INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(2,'Jus de fruits',0.10);
INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(2,'Boissons alcoolisés',0.20);

INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(3,'Pull',0.20);
INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(3,'Vêtements de pluie',0.20);
INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(3,'Accessoires',0.20);

INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(4,'Bolée',0.20);
INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(4,'Cartes postales',0.20);
INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(4,'Portes clefs',0.20);

INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(5,'Poissons',0.0550);
INSERT INTO _sous_categorie(id_categorie_sup,nom,tva) VALUES(5,'Viande',0.0550);


INSERT INTO _produit( `Nom_produit`, `Prix_coutant`, `Prix_vente_HT`, `Prix_vente_TTC`, `Quantite_disponnible`, `Description_produit`, `images1`, `images2`, `images3`, `Moyenne_Note_produit`, `Id_Sous_Categorie`, `ID_Vendeur`) VALUES
("Kouign-amann", "5.00", "8.50", "10.20", 71, "Le véritable kouign-amann breton, croustillant à l'extérieur et fondant à l'intérieur, préparé avec du beurre AOP et une touche de sucre caramélisé.", "img1.jpg", "img2.jpg", "img3.jpg", 5, 1, 3),
("Quatre-Quarts", "2.50", "4.50", "5.40", 35, "Un gâteau moelleux et généreux, fait à parts égales de beurre, sucre, farine et œufs pour une texture authentique et savoureuse.", "img1.jpg", "img2.jpg", NULL, 5, 1, 3),
("Miel Breton toutes fleurs", "7.00", "12.00", "13.50", 120, "Miel artisanal de Bretagne, récolté avec soin par des apiculteurs locaux. Texture onctueuse et arômes floraux riches.", "img1.jpg", "img2.jpg", "img3.jpg", NULL, 2, 2),
("Beurre salé", "1.80", "3.50", "4.20", 55, "Beurre demi-sel fermier au goût authentique, idéal pour accompagner vos tartines ou pour la cuisine.", "img1.jpg", "img2.jpg", "img3.jpg", NULL, 2, 2),
("Caramel au beurre salé", "3.50", "6.50", "7.80", 90, "Caramel artisanal au beurre salé, crémeux et riche en goût. Parfait pour les crêpes, glaces ou à déguster à la cuillère !", "img1.jpg", "img2.jpg", NULL, NULL, 2, 1),
("Crêpe Dentelle cœur cacao noisette", "1.50", "3.00", "3.60", 148, "Fine et croustillante, cette crêpe dentelle renferme un délicieux cœur fondant au cacao et aux noisettes.", "img1.jpg", "img2.jpg", "img3.jpg", NULL, 2, 4),
("Cola bien frais - 2,5L", "1.50", "2.99", "3.59", 380, "Une boisson gazeuse rafraîchissante au goût intense, idéale pour accompagner vos repas et moments de détente.", "img1.jpg", "img2.jpg", "img3.jpg", NULL, 3, 4),
("Breizh Thé - 1,5L", "0.50", "1.20", "1.44", 210, "Thé glacé naturel à la pêche, avec une infusion authentique de thé noir pour une saveur rafraîchissante.", "img1.jfif", NULL, NULL, NULL, 3, 1),
("Breizh Agrume - 1,5L", "0.60", "1.40", "1.68", 126, "Boisson pétillante aux agrumes avec des fines bulles et un goût délicatement fruité.", "img1.jpg", NULL, NULL, NULL, 3, 1),
("Breizh Cola - 1,5L", "0.55", "1.10", "1.32", 367, "Cola breton original, à la recette unique pour un goût authentique et rafraîchissant.", "img1.jfif", NULL, NULL, NULL, 3, 1),
("Breizh lim' - 1,5L", "0.45", "0.99", "1.19", 94, "Limonade bretonne artisanale, au goût frais et légèrement acidulé.", "img1.webp", NULL, NULL, NULL, 3, 1),
("Jus de Pomme Tradition - 1,6L", "1.80", "3.80", "4.56", 80, "Jus de pomme pur, issu de vergers bretons. Pressé à froid pour conserver toutes ses saveurs.", "img1.jpg", NULL, NULL, NULL, 4, 4),
("Jus de Pommes qui pétille - 75cl", "1.50", "3.50", "4.20", 46, "Jus de pommes pétillant, parfait pour célébrer les petites et grandes occasions !", "img1.jpg", "img2.jpg",NULL, NULL, 4, 1),
("Liqueur de fraise de Plougastel - 70cl", "12.00", "18.50", "22.20", 24, "Liqueur artisanale aux fraises de Plougastel, une explosion de saveurs fruitées et sucrées.", "img1.jpg", NULL, NULL, NULL, 5, 4),
("Breizh Whisky - 70cl", "22.00", "34.00", "40.80", 28, "Whisky breton équilibré, entre malt et grain, vieilli en fûts de chêne pour une saveur unique.", "img1.jpg", "img2.jpg", "img3.jpg", NULL, 5, 4),
("Armorik Tradition BIO - 70cl", "28.00", "42.00", "50.40", 17, "Whisky breton bio, aux notes fruitées et épicées, élaboré avec du malt issu de l'agriculture biologique.", "img1.jpg", "img2.jpg", "img3.jpg", NULL, 5, 4),
("Bottes de pluie", "10.00", "18.00", "21.60", 89, "Bottes en caoutchouc robustes et imperméables, idéales pour affronter la pluie bretonne.", "img1.jpg", "img2.jpg", NULL, NULL, 7, 5),
("Bob circuit Paul Ricard", "12.00", "20.00", "24.00", 0, "Bob officiel du circuit Paul Ricard, idéal pour se protéger du soleil lors des événements automobiles.", "img1.jpg", "img2.jpg", NULL, NULL, 8, 1),
("Bolée triskell marron sans anse", "3.50", "6.00", "7.20", 45, "Bolée traditionnelle en grès, parfaite pour déguster du cidre.","img1.jpg", "img2.jpg", NULL, NULL, 9, 2),
("Bolée sans anse 'Poisson noir'", "3.50", "6.00", "7.20", 68, "Bolée artisanale en grès, au décor poisson noir, idéale pour les amateurs de cidre.", "img1.jpg", "img2.jpg", NULL, NULL, 9, 2),
("Porte-clé Breton", "1.20", "2.50", "3.00", 100, "Porte-clé en métal avec motif triskell, symbole emblématique de la Bretagne.", "img1.jpg", NULL, NULL, NULL, 11, 2),
("Maquereau, poivron jaune et piment d'Espelette", "5.00", "8.50", "10.20", 350, "Maquereau breton aux saveurs relevées, préparé avec du poivron jaune et du piment d'Espelette.", "img1.jpg", "img2.jpg", NULL, NULL, 12, 1),
("Montre bretonne", "60.00", "120.00", "144.00", 50, "Montre élégante avec motif hermine bretonne, alliant tradition et modernité.", "img1.jpg", NULL, NULL, NULL, 8, 3);





INSERT INTO _panier(Prix_total_HT,Prix_total_TTC,ID_Client)VALUES(0,0,1);
INSERT INTO _panier(Prix_total_HT,Prix_total_TTC,ID_Client)VALUES(0,0,2);
INSERT INTO _panier(Prix_total_HT,Prix_total_TTC,ID_Client)VALUES(0,0,3);
INSERT INTO _panier(Prix_total_HT,Prix_total_TTC,ID_Client)VALUES(0,0,4);


INSERT INTO _contient_produit_p(id_panier,id_produit,quantite)VALUES(1,1,10);
INSERT INTO _contient_produit_p(id_panier,id_produit,quantite)VALUES(1,3,2);
INSERT INTO _contient_produit_p(id_panier,id_produit,quantite)VALUES(2,4,5);
INSERT INTO _contient_produit_p(id_panier,id_produit,quantite)VALUES(4,1,12);
INSERT INTO _contient_produit_p(id_panier,id_produit,quantite)VALUES(4,10,3);
INSERT INTO _contient_produit_p(id_panier,id_produit,quantite)VALUES(1,2,5);
INSERT INTO _contient_produit_p(id_panier,id_produit,quantite)VALUES(2,8,7);
INSERT INTO _contient_produit_p(id_panier,id_produit,quantite)VALUES(2,2,3);


INSERT INTO _commande(ID_Client, nom_de_rue_livraison, complement_livraison, ville_livraison, code_postale_livraison, nom_de_rue_facturation, complement_facturation, ville_facturation, code_postale_facturation)
VALUES(1, '1 Rue édouard Branly',NULL,'Lannion','22300','1 Rue des écoles',NULL,'Liez','85420');




INSERT INTO _avis (ID_Client, ID_produit, Note_produit, Commentaire, Image_avis) VALUES ('1', '1', '5', 'Très bon produit, le prix est pas très élevé pas sa qualité', NULL);
INSERT INTO _avis (ID_Client, ID_produit, Note_produit, Commentaire, Image_avis) VALUES ('2', '1', '4', 'Très apprécié ce produit qui me fait ravivé les papilles !', NULL);
INSERT INTO _avis (ID_Client, ID_produit, Note_produit, Commentaire, Image_avis) VALUES ('3', '6', '2', 'Pas aimé du tous ! Trop chère pour la qualité, et il y avait trop de chocolat', NULL);
INSERT INTO _avis (ID_Client, ID_produit, Note_produit, Commentaire, Image_avis) VALUES ('1', '2', '3', 'Moyen, je ne pense pas racheter ce produit car ça ne ma pas fait réver', NULL);
INSERT INTO _avis (ID_Client, ID_produit, Note_produit, Commentaire, Image_avis) VALUES ('2', '6', '4', 'Bien aimé, le chocolat est onctueux, et la pate crocante !', NULL);
INSERT INTO _avis (ID_Client, ID_produit, Note_produit, Commentaire, Image_avis) VALUES ('3', '1', '5', 'Parfait ! La livraison était rapide, et le produit était comme la photo', NULL);



INSERT INTO _signaler(ID_Commentaire,ID_Signaleur) VALUES(1,1);
INSERT INTO _signaler(ID_Commentaire,ID_Signaleur) VALUES(1,2);
INSERT INTO _signaler(ID_Commentaire,ID_Signaleur) VALUES(2,3);
INSERT INTO _signaler(ID_Commentaire,ID_Signaleur) VALUES(1,4);


INSERT INTO _reponse(ID_Commentaire, ID_Vendeur, Commentaire) VALUES ('3', '1', "Merci pour votre commentaire.");