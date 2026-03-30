<?php


session_start();
include '../db.php';

if (isset($_POST['submit'])) {
    $name = trim($_POST['product_name']);
    $description = trim($_POST['product_description']);
    $price = (int) $_POST['product_price'];
    $quantity = (int) $_POST['product_quantity'];

    if (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
        echo "Image upload failed.";
    } else {
        // $image = basename($_FILES['product_image']['name']); i had change this with ablve two line and it start working
        $file_ext = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
        $image = "product_" . time() . "_" . rand(1000, 9999) . "." . $file_ext;
        $img_location = $_FILES['product_image']['tmp_name'];
        $upload_location = __DIR__ . "/../image/" . $image;

        if (move_uploaded_file($img_location, $upload_location)) {
            $sql = "INSERT INTO product (name, description, price, quantity, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                echo "Prepare failed: " . $conn->error;
            } 
            else 
            {
                $stmt->bind_param("ssiis", $name, $description, $price, $quantity, $image);

                if ($stmt->execute()) {
                    header("Location: viewproduct.php");
                    exit;
                } else {
                    echo "Execute failed: " . $stmt->error;
                }

                $stmt->close();
            }
        } 
        else 
        {
            echo "Failed to move uploaded image.";
        }
    }
}

$conn->close();
?>

