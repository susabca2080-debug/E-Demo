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


/* ===== FOOTER ===== */
footer{
    background:#0f0f1a;
    color:#ccc;
    padding:80px 70px;
}
.footer-grid{
    max-width:1200px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:45px;
}
footer h4{
    color:white;
    margin-bottom:20px;
}
footer ul{
    list-style:none;
}
footer ul li{
    margin-bottom:12px;
    font-size:14px;
}
.copy{
    text-align:center;
    margin-top:55px;
    font-size:14px;
    color:#aaa;
}

/* ===== RESPONSIVE ===== */
@media(max-width:992px){
    .product-grid{
        grid-template-columns:repeat(2,1fr);
    }
}
@media(max-width:600px){
    nav{
        justify-content:center;
        gap:20px;
    }
    nav ul{
        flex-wrap:wrap;
        justify-content:center;
    }
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


<!-- FOOTER -->
<footer>
    <div class="footer-grid">
        <div>
            <h4>Services</h4>
            <ul>
                <li>Web Development</li>
                <li>App Development</li>
                <li>Digital Marketing</li>
            </ul>
        </div>
        <div>
            <h4>Social</h4>
            <ul>
                <li>Facebook</li>
                <li>Instagram</li>
                <li>Twitter</li>
            </ul>
        </div>
        <div>
            <h4>Quick Links</h4>
            <ul>
                <li>Home</li>
                <li>Products</li>
                <li>Contact</li>
            </ul>
        </div>
        <div>
            <h4>Contact</h4>
            <ul>
                <li>Kathmandu, Nepal</li>
                <li>info@gmail.com</li>
                <li>98XXXXXXXX</li>
            </ul>
        </div>
    </div>

    <div class="copy">
        ©️ 2026 My Ecom. All Rights Reserved.
    </div>
</footer>

</body>
</html>