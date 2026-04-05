<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Ecom</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Segoe UI",sans-serif;
}

body{
    background:#f4f6fb;
}


/* ===== HERO (PROFESSIONAL) ===== */
.hero{
        background:linear-gradient(135deg,#6a5acd,#8b7bff);

    padding:130px 20px;
    text-align:center;
    color:white;
}
.hero h1{
    font-size:62px;
    letter-spacing:1px;
}
.hero p{
    margin:18px auto;
    font-size:20px;
    max-width:650px;
    opacity:0.95;
}
.hero-buttons{
    margin-top:35px;
}
.hero-buttons button{
    padding:15px 38px;
    font-size:16px;
    border-radius:30px;
    border:none;
    cursor:pointer;
    margin:0 10px;
}
.hero-buttons .primary{
    background:white;
    color:#3b3f8c;
    font-weight:600;
}
.hero-buttons .secondary{
    background:transparent;
    color:white;
    border:2px solid white;
}
.hero-buttons button:hover{
    transform:translateY(-2px);
}

/* ===== PRODUCTS ===== */
.products{
    padding:80px 70px;
}
.products h2{
    text-align:center;
    margin-bottom:55px;
    font-size:34px;
}
.product-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:35px;
}
.card{
    background:#fff;
    border-radius:16px;
    padding:22px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-10px);
}
.card img{
    width:100%;
    height:220px;
    object-fit:contain;
    background:#f4f6fb;
    border-radius:12px;
}
.card h3{
    margin:18px 0 10px;
    font-size:20px;
}
.card p{
    font-size:14px;
    color:#666;
}
.price{
    margin:15px 0;
    font-size:18px;
    font-weight:bold;
    color:#3b3f8c;
}
.card button{
    padding:12px 28px;
    background:#3b3f8c;
    color:white;
    border:none;
    border-radius:25px;
    cursor:pointer;
}
.card button:hover{
    background:#2f3375;
}



/* ===== RESPONSIVE ===== */
@media(max-width:992px){
    .product-grid{
        grid-template-columns:repeat(2,1fr);
    }
}
@media(max-width:600px){
    
    
    .product-grid{
        grid-template-columns:1fr;
    }
    .hero h1{
        font-size:42px;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<?php
include 'header.php';
?>

<!-- HERO -->
<section class="hero">
    <h1>Online Shopping Made Easy</h1>
    <p>Discover premium products, trusted quality and unbeatable prices — all in one place.</p>
    <div class="hero-buttons">
        <button class="primary">Shop Now</button>
        <button class="secondary">Explore</button>
    </div>
</section>

<!-- PRODUCTS -->
<section class="products" id="products">
    <h2>Our Products</h2>

    <div class="product-grid">
        <?php
        include 'db.php';
        include 'functions.php';
        
        if ($conn) {
            get_products($conn);
        } else {
            echo "<p>Error: Unable to connect to database</p>";
        }
        ?>
    </div>  
</section>

<!-- FOOTER -->
<footer>
    <?php
    include 'footer.php';
    ?>
</footer>

</body>
</html>