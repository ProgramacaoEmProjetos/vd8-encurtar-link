<?php

session_start();

require_once('database.php');
require_once('tools.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $alias = str_replace('/', '', $_SERVER['REQUEST_URI']);

    if(empty($alias)) {
        $_SESSION["error"] = "Não é um link curto!";
        redirect_home();
        return;
    }

    $redirect_link = find_shortlink($alias);

    if(empty($redirect_link)) {
        $_SESSION["error"] = "Não é um link encurtado válido!";
        redirect_home();
        return;
    }

    redirect_to($redirect_link);
}