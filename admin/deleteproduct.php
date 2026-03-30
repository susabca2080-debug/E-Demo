<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../db.php";

session_start();
if (($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit;
}
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];


    $sql ="DELETE FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error); 
    }
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
        header("Location: viewproduct.php");
        exit;
    } else {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();


}