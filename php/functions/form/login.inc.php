<?php
include("./../session.php");
include("./../functions.php");

// Si le mail existe
if (isset($_POST["email"])) {

    $connected = connexion($_POST["email"], $_POST["pwd"]);

    /**
     * Tableau $connected
     * ['res']
     * ['id_client']
     * ['statut_active']
     *
     */

    // Si l'identifiant est valide
    if ($connected[0]) {

        // Si le Compte n'est pas desactivé
        if ($connected[2] == 1) {
            $_SESSION["id_client"] = $connected[1];
            header("Location: ../../index.php?connected");
            exit();
        } else {
            header("Location: ../../login.php?error=userdisabled");
            exit();
        }
    } else {
        header("Location: ../../login.php?error=wrongid");
        exit();
    }
} else {
    header("Location: ../../login.php?error=unknowerror");
    exit();
}
