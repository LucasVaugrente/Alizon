<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

<header class="header-vendeur">
            <!-- TITRE ALIZON -->
        <a href="index.php" title="Accueil" class="logo">
            <img src="../img/logo2.0.png" alt="Logo Alizon" title="Logo Alizon" width='200' class="img_logo">
        </a>

        <nav class="nav-vendeur">

            <div>
                <i class="fa-solid fa-table-columns fa-xl"></i>
                <a href="vendeur.php"><p>Dashboard</p></a>
            </div>
            <hr>
            <div class="commandes-vendeur">
                <i class="fa-solid fa-bag-shopping fa-xl"></i>
                <a href="vendeur.php"><p>Commandes</p></a>
                
            </div>

            <div class="catalogue-vendeur active">
            <i class="fa-solid fa-folder-open fa-xl"></i>
                <a href="vendeur.php"><p>Catalogue</p></a>
            </div>

            <form action="header_vendeur.php" method="post">
                <div class="deconnexion-vendeur">
                    <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                    <input type="submit" value="Se déconnecter" name="deco_vendeur">
                </div>
            </form>

            <?php
                if(isset($_POST["deco_vendeur"]))
                {
                    header("Location: ./index.php");
                    exit();
                }
            ?>
        </nav>
</header> 

