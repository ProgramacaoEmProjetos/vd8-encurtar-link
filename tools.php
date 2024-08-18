<?php

function redirect_back() {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function redirect_home() {
    header('Location: ' . $protocol . $_SERVER['SERVER_NAME']);
}

function redirect_to($link) {
    header('Location: ' . $link);
}