<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_psp";

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$conn) {
    die("Database connection failed.");
}

?>