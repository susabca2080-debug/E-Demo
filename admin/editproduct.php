<?php
include '../db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('location:../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:viewproduct.php');
    exit();
}

$id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$description = isset($_POST['product_description']) ? trim($_POST['product_description']) : '';
$price = isset($_POST['product_price']) ? (float)$_POST['product_price'] : 0;
$name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
$quantity = isset($_POST['product_quantity']) ? (int)$_POST['product_quantity'] : 0;
$image = isset($_POST['current_image']) ? trim($_POST['current_image']) : '';

if ($id <= 0 || $description === '' || $name === '' || $price <= 0 || $quantity < 0) {
    die("All fields are required.");
}

if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $newImage = basename($_FILES['product_image']['name']);
    $targetPath = "../image/" . $newImage;
    if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath)) {
        die("Image upload failed.");
    }
    $image = $newImage;
}

$stmt = $conn->prepare("UPDATE product SET description=?,price=?, name=?, quantity=?, image=? WHERE id=?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sdsisi", $description, $price, $name, $quantity, $image, $id);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$stmt->close();
header('location:viewproduct.php');
exit();

?>