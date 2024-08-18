<?php

session_start();

require_once('database.php');
require_once('tools.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST["srclink"])) {
        $_SESSION["error"] = "Forneça um link para ser encurtado!";
        redirect_back();
        return;
    }
    $redirect = $_POST["srclink"];
    $alias = isset($_POST["endlink"]) ? $_POST["endlink"] : '';

    $shortlink = create_shortlink($redirect, $alias);

    if($shortlink == "erro1") {
        $_SESSION["error"] = "O final personalizado já está em uso!";
        redirect_back();
        return;
    }

    $_SESSION["shortlink"] = $shortlink;

    redirect_back();
}