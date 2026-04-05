<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background: #f6f7fb;
            color: #111;
        }

        /* MAIN WRAPPER */
        .product-wrapper {
            width: 85%;
            max-width: none;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 20px;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 10px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        }

        /* IMAGE BOX */
        .product-image {
            width: 100%;
            aspect-ratio: 1/1;
            overflow: hidden;
            border-radius: 20px;
            background: #f3f4f7;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .product-image:hover {
            transform: scale(1.02);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* DETAILS */
        .product-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-details h1 {
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .price {
            font-size: 28px;
            color: #2f3375;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .desc {
            color: #555;
            line-height: 1.8;
            margin-bottom: 25px;
            max-width: 500px;
        }

        /* STOCK */
        .stock {
            font-weight: 600;
            margin-bottom: 25px;
            color: green;
        }

        /* QUANTITY */
        .qty {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .qty button {
            width: 35px;
            height: 35px;
            border: none;
            background: #eee;
            font-size: 18px;
            cursor: pointer;
            border-radius: 8px;
        }

        .qty input {
            width: 60px;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        /* BUTTON */
        .buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }

        .buy {
            background: #2f3375;
            color: white;
        }

        .buy:hover {
            background: gray;
            transform: translateY(-2px);
        }

        /* RATING */
        .rating {
            color: gold;
            margin-bottom: 15px;
        }

        /* RESPONSIVE */
        @media(max-width:992px) {
            .product-wrapper {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .product-details h1 {
                font-size: 28px;
            }
        }

        @media(max-width:600px) {
            .product-details h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <?php
    include 'header.php';
    ?>

    <!-- PRODUCT DETAIL -->
    <div class="product-wrapper">
        <?php
            include 'db.php';
            include 'functions.php';
            if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
                get_product_details($conn, (int) $_GET['id']);
            } else {
                echo "<p>Product not found.</p>";
            }
        ?>
    </div>


    <!-- FOOTER -->
    <footer>
        <?php
        include 'footer.php';
        ?>
    </footer>

</body>

</html>