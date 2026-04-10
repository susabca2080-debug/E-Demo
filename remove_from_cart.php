<?php
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    include 'db.php';
    session_start();

    $delete_sql = "DELETE FROM carts WHERE product_id = $product_id and user_id = " . (int) $_SESSION['user_id'];
    mysqli_query($conn, $delete_sql);

    header("Location: cart.php");
}