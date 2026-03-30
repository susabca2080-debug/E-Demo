<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_practice";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>