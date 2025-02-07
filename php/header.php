<?php
include("fonctions/databaseConnexion.php");
include("fonctions/page_cookies.php");
require_once("fonctions/fonctions.php");

/*############### MENU DE CATEGORIES DYNAMIQUES ###############*/
$sth = $dbh->prepare("SELECT nom_categorie, nom as nom_Souscategorie FROM $schema._categorie INNER JOIN $schema._sous_categorie ON id_categorie_sup = id_categorie");
$sth->execute();
$res = $sth->fetchAll();

$liste_SousCategories = array();
foreach ($res as $categorie) {
  $liste_SousCategories[$categorie['nom_Souscategorie']] = $categorie['nom_categorie'];
}

$sth = $dbh->prepare("SELECT nom_categorie FROM $schema._categorie");
$sth->execute();
$res = $sth->fetchAll();
$liste_Categories = array();

foreach ($res as $categorie) {
  array_push($liste_Categories, $categorie['nom_categorie']);
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

<link rel='stylesheet' type='text/css' href='../css/style.css'>
<link rel='stylesheet' type='text/css' href='../css/header.css'>
<link rel='stylesheet' type='text/css' href='../css/catalogue.css'>
<link rel='stylesheet' type='text/css' href='../css/compte_client.css'>
<link rel='stylesheet' type='text/css' href='../css/cookies.css'>
<link rel='stylesheet' type='text/css' href='../css/footer.css'>
<link rel='stylesheet' type='text/css' href='../css/home.css'>
<link rel='stylesheet' type='text/css' href='../css/gestion_comptes.css'>
<link rel='stylesheet' type='text/css' href='../css/import_catalogue.css'>
<link rel='stylesheet' type='text/css' href='../css/login.css'>
<link rel='stylesheet' type='text/css' href='../css/paiement.css'>
<link rel='stylesheet' type='text/css' href='../css/panier.css'>
<link rel='stylesheet' type='text/css' href='../css/produit.css'>
<link rel='stylesheet' type='text/css' href='../css/vendeur.css'>

<div class='sticky-header'>
  <div class="haut_de_page">

    <a href="index.php" title="Accueil" class="logo">
      <img src="../img/logo2.0.png" alt="Logo alizon" title="Logo alizon" width='200' class="img_logo">
    </a>

    <form action="catalogue.php" method="GET" class="search-box">
      <input type="search" name="terme" class="search-txt" placeholder="Rechercher..." required>
      <button class="search-btn" type="submit">
        <i class="fas fa-search"></i>
      </button>
    </form>

    <div class="logos">
      <div class="search-btn-tel" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
        <p class="texte_img_search">Chercher</p>
      </div>

      <?php
      // Si le client se déconnecte
      if (isset($_POST['deco'])) {

        $_SESSION['id_client'] = null;
        setcookie("id_panier", "");
        $_SESSION['deco'] = $_POST['deco'];

        if (substr($_SERVER["SCRIPT_FILENAME"], -9) === "index.php") {

          echo "<div class='alert deco no_bootstrap'>
                  <i class='fa-regular fa-circle-check fa-2x'></i>
                  <p>Vous êtes déconnecté </p>
                </div>";
        } else {
          echo "<div class='alert deco'>
                  <i class='fa-regular fa-circle-check fa-2x'></i>
                  <p>Vous êtes déconnecté </p>
                </div>";
        }
      }
      ?>

      <!-- VERIFICATION SI L'INTERNAUTE EST CONNECTE OU NON -->
      <?php

      // SI LE CLIENT EST CONNECTE
      if (isset($_SESSION['id_client'])) {
        $lien = "monCompte.php";
        $nom_client = infos_Client($_SESSION["id_client"])["nom_client"];
        $prenom_client = infos_Client($_SESSION["id_client"])["prenom_client"];
        echo "<div class='logo_compte' id='logo_c'>
                <i class='fa-solid fa-user'></i>
                <p class='texte_img_compte'>Compte</p>
              </div>
              <div class='bloc-compte'>
              <div class='nom_compte'>
                <i class='fa-solid fa-circle-user'></i>
                <h3>" . $prenom_client . " " . $nom_client . "</h3>
              </div>
              <hr>
              <a href='$lien'>Mon compte</a>
              <form action='#' method='post'>
                <input name='deco' type='submit' value='Se Déconnecter'>
              </form>
            </div>";
      } else {
        echo "<div class='logo_compte' id='logo_c'>
                <i class='fa-solid fa-user'></i>
                <p class='texte_img_compte'>Compte</p>
                <div class='bloc-compte nonco'>
                  <a href='connexion.php'>S'inscrire</a>
                  <a href='inscription.php'>Se Connecter</a>
                </div>
              </div>";
      }
      ?>

      <a href="panier.php" class="logo_panier" id="logo_p">
        <i class="fa-solid fa-bag-shopping"></i>
        <p class="texte_img_panier">Panier</p>
        
        <?php
        if (isset($_COOKIE["id_panier"])) {
          $nb_articles = nb_articles_panier($_COOKIE["id_panier"]);
          if ($nb_articles > 0) {
            echo "<div class='nb_articles_panier'>
                    $nb_articles
                  </div>";
          }
        }

        ?>
      </a>
    </div>
  </div>

  <!-- BARRE DE NAVIGATION -->
  <div class="navbar">
    <!-- MENU BUGER FORMAT PC-->
    <div class="topnav">
      <ul class="topnav--left">
        <li class="header tel">
          <div class="menu-btn">
            <div class="menu-btn__lines"></div>
          </div>
          <ul class="menu-items">
            <li class="dropdown">
              <a href="#" class="menu-item expand-btn">Catégories</a>
              <ul class="dropdown-menu expandable">
                <?php foreach ($liste_Categories as $categorie): ?>
                  <li class="dropdown dropdown-right">
                    <a href="#" class="menu-item expand-btn">
                      <?php echo $categorie; ?>
                      <i class="fas fa-angle-right"></i>
                    </a>
                    <ul class="menu-right expandable">
                      <?php foreach ($liste_SousCategories as $SousCategorie => $SupCategorie): ?>
                        <?php if ($SupCategorie == $categorie): ?>
                          <li><a href="catalogue.php?terme=<?php echo str_replace(' ', "_", $SousCategorie); ?>"><?php echo $SousCategorie; ?></a></li>
                        <?php endif; ?>
                      <?php endforeach; ?>

                    </ul>
                  </li>
                <?php endforeach; ?>


              </ul>
            </li>
          </ul>
        </li>
        <li class="header">
          <div class="menu-btn">
            <div class="menu-btn__lines"></div>
          </div>
          <ul class="menu-items">
            <li class="mega-menu2">
              <a href="#" class="menu-item expand-btn">Catégories</a>
              <div class="mega-menu expandable">
                <div class="content">
                  <div class="col">

                    <section class="section-links1">
                      <h2><?php echo $liste_Categories[0]; ?></h2>
                      <ul class="mega-links">
                        <?php foreach ($liste_SousCategories as $SousCategorie => $SupCategorie): ?>
                          <?php if ($SupCategorie == $liste_Categories[0]): ?>
                            <li><a href="catalogue.php?categorie=<?php echo str_replace(' ', "_", $SupCategorie); ?>&Scategorie=<?php echo str_replace(' ', "_", $SousCategorie); ?>"><?php echo $SousCategorie; ?></a></li>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </ul>
                    </section>

                  </div>
                  <?php foreach ($liste_Categories as $categorie): ?>
                    <?php if ($categorie != $liste_Categories[0]): ?>
                      <div class="col">
                        <section>
                          <h2><?php echo $categorie; ?></h2>
                          <ul class="mega-links">
                            <?php foreach ($liste_SousCategories as $SousCategorie => $SupCategorie): ?>
                              <?php if ($SupCategorie == $categorie): ?>
                                <li><a href="catalogue.php?categorie=<?php echo str_replace(' ', "_", $SupCategorie); ?>&Scategorie=<?php echo str_replace(' ', "_", $SousCategorie); ?>"><?php echo $SousCategorie; ?></a></li>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </ul>
                        </section>
                      </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
              </div>
            </li>
          </ul>
        </li>
        <li class="v-line"></li>
        <li><a href="">Meilleures Ventes</a></li>
        <li><a href="">Promotions</a></li>
      </ul>

      <div class="topnav--right">
        <a href="">Le Club</a>
        <a href="">Bons Plans</a>
      </div>
    </div>
  </div>
</div>

<script>
  /*############### ANIMATION MENU DE CATEGORIES ###############*/
  const menuBtn = document.querySelector(".menu-btn");
  const menuItems = document.querySelector(".menu-items");
  const expandBtn = document.querySelectorAll(".expand-btn");

  // humburger toggle
  menuBtn.addEventListener("click", () => {
    menuBtn.classList.toggle("open");
    menuItems.classList.toggle("open");
  });

  // mobile menu expand
  expandBtn.forEach((btn) => {
    btn.addEventListener("click", () => {
      btn.classList.toggle("open");
    });
  });

  let btn_compte = document.querySelector(".logo_compte");
  let bloc_compte = document.querySelector(".bloc-compte");

  btn_compte.addEventListener("click", function(event) {
    bloc_compte.classList.toggle("actif");
    bloc_compte.classList.remove("nonactif");
    event.stopPropagation();
  });

  document.addEventListener("click", function(event) {
    if (!btn_compte.contains(event.target)) {
      bloc_compte.classList.remove("actif");
      bloc_compte.classList.add("nonactif");
    }
  })
</script>