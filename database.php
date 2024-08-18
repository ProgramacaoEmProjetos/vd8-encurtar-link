<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "shortlink1";

/*
CREATE TABLE links (
id BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
redirect VARCHAR(512) NOT NULL,
alias VARCHAR(50) UNIQUE NOT NULL,
created DATETIME NOT NULL)
*/

/// https://www.youtube.com/@ProgramacaoemProjetos
/// https://www.youtube.com/watch?v=3GDHW6J480k
/// https://laragon.org/download/index.html
/// https://www.php.net/manual/pt_BR/langref.php

function create_db_connection() {
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}


function find_shortlink($alias) {
    $conn = create_db_connection();

    $redirect_link = "";

    // prepare and bind
    $stmt = $conn->prepare("SELECT redirect FROM links WHERE alias = ? AND created >= DATE_ADD(NOW(), INTERVAL -1 MONTH);");
    $stmt->bind_param("s",$alias);
    $stmt->execute();

    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()) {
        $redirect_link = $row['redirect'];
    }

    $stmt->close();
    $conn->close();
    
    return $redirect_link;
}

function generate_alias() {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
}

function create_shortlink($redirect, $alias) {

    $created = date("Y-m-d H:i:s");
    if(empty($alias)) {
        $alias = generate_alias();
    } else {
        $alias = str_replace(' ', '_', $alias);

        if(!empty(find_shortlink($alias))) {
            return "erro1";
        }
    }

    $conn = create_db_connection();

    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO links (redirect, alias, created) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $redirect, $alias, $created);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
    return $protocol . $_SERVER['SERVER_NAME'] . '/' . $alias;
}