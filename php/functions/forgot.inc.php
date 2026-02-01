<?php
include("./session.php");
include("./functions.php");

if (isset($_POST["nvmdp"])) {

    $res = recuperer_mdp($_POST["reponse"], $_POST["nvmdp"], $_GET["email"]);

    if ($res === "unknowemail") {
        header("Location: ../forgot_password.php?error=unknowemail");
        exit;
    } elseif ($res === "errorquestion") {
        header("Location: ../forgot_password.php?error=errorquestion");
        exit;
    } else {
        header("Location: ../forgot_password.php?pwdswitched");
        exit;
    }
}
