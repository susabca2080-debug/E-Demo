
<?php
function get_products($conn) {
    $sql = "SELECT id, name, description, price, quantity, image FROM product ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "<p>Unable to load products right now.</p>";
        return;
    }

    if (mysqli_num_rows($result) === 0) {
        echo "<p>No products available.</p>";
        return;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $productName = htmlspecialchars($row['name']);
        $description = htmlspecialchars($row['description']);
        $price = number_format((float) $row['price'], 2);
        $productImage = htmlspecialchars($row['image']);

        echo "
            <div class='card'>
                <img src='image/{$productImage}' alt='{$productName}'>
                <h3>{$productName}</h3>
                <p>{$description}</p>
                <div class='price'>NRs {$price}</div>
                <div style='display: flex; margin: 50px; margin-top: 10px;'>
                <a href='cart.php?product_id={$row['id']}' style='padding: 12px 28px; background: #3b3f8c; color: white; border: none; border-radius: 25px; text-decoration: none;'>Add to Cart</a>
                <a href='viewdetail.php?id={$row['id']}' style='margin-left: 10px; padding: 12px 28px; background: #3b3f8c; color: white; border: none; border-radius: 25px; text-decoration: none;'>View Details</a>
                </div>
            </div>
        ";
    }
}

function get_product_details($conn, $productId) {
    $sql = "SELECT id, name, description, price, quantity, image FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<p>Unable to load product right now.</p>";
        return;
    }
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        echo "<p>Product not found.</p>";
        $stmt->close();
        return;
    }

    $row = $result->fetch_assoc();
    $productName = htmlspecialchars($row['name']);
    $description = htmlspecialchars($row['description']);
    $price = number_format((float) $row['price'], 2);
    $productImage = htmlspecialchars($row['image']);

    echo "<div class='product-image'>
        <img src='image/{$productImage}' alt='{$productName}'>
    </div>
    <div class='product-details'>
        <h1>{$productName}</h1>
        <div class='price'>NRs {$price}</div>
        <div class='desc'>{$description}</div>
        <div class='stock'>In Stock: {$row['quantity']}</div>
        <div class='qty'>
            <button>-</button>
            <input type='text' value='1' readonly>
            <button>+</button>
        </div>
        <div class='buttons'>
            <button class='btn buy'>Buy Now</button>
                <a href='cart.php?product_id={$row['id']}' style='padding: 12px 28px; background: #3b3f8c; color: white; border: none; border-radius: 25px; text-decoration: none;'>Add to Cart</a>
        </div>
    </div>";

    $stmt->close();
}




?>
