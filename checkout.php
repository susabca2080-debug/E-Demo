<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$sql = "SELECT * FROM carts WHERE user_id = " . (int) $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);

$cart_items = [];
$grand_total = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total = $row['product_price'] * $row['quantity'];
        $row['total'] = $total;
        $grand_total += $total;
        $cart_items[] = $row;
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ecom</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        

        /* CHECKOUT CONTAINER */

        .checkout-container {
            width: 85%;
            margin: auto;
            margin-top: 130px;
            margin-bottom: 120px;
        }

        .checkout-wrapper {
            display: flex;
            gap: 40px;
            width: 100%;
        }

        /* SHIPPING FORM */

        .checkout-form {
            width: 50%;
            background: white;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .checkout-form h2 {
            margin-bottom: 20px;
        }

        .checkout-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .checkout-form input,
        .checkout-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* ORDER SUMMARY */

        .order-summary {
            width: 50%;
            background: white;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .order-summary h2 {
            margin-bottom: 20px;
        }

        .order-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-summary th,
        .order-summary td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .order-summary th:last-child,
        .order-summary td:last-child {
            text-align: right;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* PAYMENT */

        .payment-method h3 {
            margin-bottom: 10px;
        }

        .payment-method label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 5px;
        }

        /* BUTTON */

        .place-btn {
            background: #3498db;
            border: none;
            color: white;
            padding: 12px;
            width: 180px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .place-btn:hover {
            background: #2980b9;
        }



        

        /* ===== RESPONSIVE ===== */

        @media(max-width:768px) {

            .checkout-container {
                width: 92%;
            }

            .checkout-wrapper {
                flex-direction: column;
            }

            .checkout-form,
            .order-summary {
                width: 100%;
            }

            nav {
                justify-content: center;
                gap: 20px;
            }

            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media(max-width:500px) {

            .footer-grid {
                grid-template-columns: 1fr;
            }

        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <nav>

       <?php include 'header.php'; ?>
    </nav>

    <!-- CHECKOUT SECTION -->

    <div class="checkout-container">

        <!-- SHIPPING DETAILS -->
        <form action="shipping.php" method="post">

            <div class="checkout-wrapper">

                <div class="checkout-form">
                    <h2>Shipping Details</h2>

                    <label>Full Name</label>
                    <input type="text" name="fullname" placeholder="Enter your full name" required>

                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email address" required>

                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter your phone number" required>

                    <label>Address</label>
                    <textarea name="address" rows="4" placeholder="Enter full delivery address" required></textarea>

                  
                </div>


            <!-- ORDER SUMMARY -->

            <div class="order-summary">

                <h2>Order Summary</h2>

                <table>

                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>

                    <?php if (count($cart_items) > 0) { ?>
                        <?php foreach ($cart_items as $item) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td><?php echo (int) $item['quantity']; ?></td>
                                <td> Rs <?php echo number_format((float) $item['total'], 2); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3">Your cart is empty.</td>
                        </tr>
                    <?php } ?>

                </table>
                <div class="total">
                    Grand Total : Rs <?php echo number_format((float) $grand_total, 2); ?>
                </div>


                

                <div class="payment-method">

                    <h3>Payment Method</h3>

                    <label>
                        <input type="radio" name="payment" value="cod" checked> Cash on Delivery (COD)
                    </label>

                    <label>
                        <input type="radio" name="payment" value="esewa">
                        <img src="image/esewa.png" alt="eSewa" style="height:50px; width:100px; vertical-align: middle;">
                    </label>

                </div>

                <br>
                <button type="submit" class="place-btn">Place Order</button>

            </div>

            </div>


            <!-- // Hidden fields to pass order details to shipping.php -->

            <?php $transaction_uuid = uniqid(); 
            $total_amount=$grand_total; 
            ?>
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
            <input type="hidden" name="transaction_uuid" value="<?php echo $transaction_uuid; ?>">
        </form>

    </div>


    <!-- FOOTER -->

    <footer>
<?php include 'footer.php'; ?>
    </footer>

</body>

</html>