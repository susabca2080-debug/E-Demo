<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];

if (isset($_GET['product_id'])) {
    // Product comes from Add to Cart link: cart.php?product_id=...
    $product_id = (int) $_GET['product_id'];

    if ($product_id > 0) {
        $product_sql = "SELECT id, name, image, price FROM product WHERE id = $product_id";
        $product_result = mysqli_query($conn, $product_sql);
        $row = mysqli_fetch_assoc($product_result);

        if ($row) {
            // Check whether this user already has the same product in cart.
            // If it exists, we only increase quantity instead of inserting a new row.
            $check_sql = "SELECT id FROM carts WHERE user_id = $user_id AND product_id = $product_id";
            $check_result = mysqli_query($conn, $check_sql);

            if ($check_result && mysqli_num_rows($check_result) > 0) {
                // Same product already exists for this user -> quantity + 1
                $update_sql = "UPDATE carts SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
                mysqli_query($conn, $update_sql);
            } else {
                // Product is not in cart yet -> create a new cart row with quantity = 1
                $row['name'] = mysqli_real_escape_string($conn, $row['name']);
                $row['image'] = mysqli_real_escape_string($conn, $row['image']);
                $row['price'] = (float) $row['price'];

                $insert_sql = "INSERT INTO carts (user_id, product_id, product_image, product_name, product_price, quantity)
                               VALUES ($user_id, $product_id, '{$row['image']}', '{$row['name']}', {$row['price']}, 1)";
                mysqli_query($conn, $insert_sql);
            }
        }
    }

    header("Location: cart.php");
    exit;
}
// its for handling quantity increase/decrease from cart page
if (isset($_GET['cart_action'])) {
    $action = $_GET['cart_action'];
    $parts = explode(':', $action);
    /**
     * Validates that the input contains exactly two parts, then assigns:
     * - the first part as the item type
     * - the second part as the product ID (cast to integer)
     */

    if (count($parts) === 2) {
        $type = $parts[0];
        $product_id = (int) $parts[1];

        if ($product_id > 0 && $type === 'inc') {
            $update_sql = "UPDATE carts SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
            mysqli_query($conn, $update_sql);
        } elseif ($product_id > 0 && $type === 'dec') {
            // Decrease quantity by 1, but not less than 1
            $update_sql = "UPDATE carts SET quantity = GREATEST(quantity - 1, 1) WHERE user_id = $user_id AND product_id = $product_id";
            mysqli_query($conn, $update_sql);
        }
    }

    header("Location: cart.php");
    exit;
}
// Fetch cart items for display

$cart_items = [];
$total = 0;

// $cart_sql = "SELECT c.product_id, c.quantity,
//                     p.image AS product_image,
//                     p.name AS product_name,
//                     p.price AS product_price
//              FROM carts c
//              INNER JOIN product p ON c.product_id = p.id
//              WHERE c.user_id = $user_id
//              ORDER BY c.id DESC";
$cart_sql = "SELECT product_id, product_image, product_name, product_price, quantity FROM carts WHERE user_id = $user_id ORDER BY id DESC";
$cart_result = mysqli_query($conn, $cart_sql);

if ($cart_result) {
    while ($item = mysqli_fetch_assoc($cart_result)) {
        $cart_items[] = $item;
        $total += ((float) $item['product_price']) * ((int) $item['quantity']);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .cart-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-details h3 {
            margin-bottom: 10px;
        }

        .cart-item-details p {
            margin-bottom: 5px;
        }

        .cart-item-details .price {
            font-weight: bold;
            color: #2f3375;
        }

        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 30px;
            color: #2f3375;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="cart-container">
        <h2>Your Shopping Cart</h2>

        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <a href="viewdetail.php? id=<?php echo (int) $item['product_id']; ?>">
                        <img src="image/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                    </a>
                    <div class="cart-item-details">
                        <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                    <a
                                        href="cart.php?cart_action=dec:<?php echo (int) $item['product_id']; ?>"
                                        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border: 1px solid #d1d5db; border-radius: 9999px; text-decoration: none; cursor: pointer; color: #111;">-</a>
                                    <span class="min-w-[1.5rem] text-center text-sm font-semibold"><?php echo (int) $item['quantity']; ?></span>
                                    <a
                                        href="cart.php?cart_action=inc:<?php echo (int) $item['product_id']; ?>"
                                        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border: 1px solid #d1d5db; border-radius: 9999px; text-decoration: none; cursor: pointer; color: #111;">+</a>
                        </div>
                        <p class="price">Price: $<?php echo number_format((float) $item['product_price'], 2); ?></p>
                        <a href="remove_from_cart.php?product_id=<?php echo (int) $item['product_id']; ?>" style="color: #ef4444; font-size: 14px;">Remove</a>  
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="total">Total: $<?php echo number_format($total, 2); ?></div>
            <a href="checkout.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px;float: right; background: #3b82f6; color: white; border-radius: 6px; text-decoration: none;">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
<!-- //just counting the cart items  -->
    <?php  $_SESSION['cart_count'] = count($cart_items); ?>

    <?php include 'footer.php'; ?>
</body>
</html>
