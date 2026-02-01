<?php
include("./../session.php");
include("./../functions.php");

// Si le mail existe
if (isset($_POST["email"])) {

    $connected = connexion_vendeur($_POST["email"], $_POST["pwd"]);
    /**
     * Tableau $connected
     * ['res']
     * ['id_client']
     * ['statut_active']
     *
     */

    // Si l'identifiant est valide
    if ($connected[0]) {
        $_SESSION["vendeur"] = $connected;
        header("Location: ../../vendor.php");
    } else {
        header("Location: ../../login-vendor.php?error=wrongid");
        exit();
    }
} else {
    header("Location: ../../login-vendor.php?error=unknowerror");
    exit();
}
