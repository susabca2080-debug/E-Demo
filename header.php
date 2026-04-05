<?php

    session_start();

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root {
    --header-bg: #0f2d3a;
    --header-bg-soft: #1d4657;
    --header-accent: #f4b942;
    --header-text: #f7fbfd;
    --header-muted: #c5d5dd;
}

.site-header {
    background: linear-gradient(120deg, var(--header-bg), var(--header-bg-soft));
    padding: 18px 6vw;
    box-shadow: 0 8px 24px rgba(6, 22, 30, 0.24);
}

.site-header .nav-wrap {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
}

.site-logo {
    color: var(--header-text);
    text-decoration: none;
    font-size: 28px;
    letter-spacing: 0.5px;
    font-weight: 700;
}

.site-nav {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 14px;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.site-nav a {
    color: var(--header-text);
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    padding: 8px 10px;
    border-radius: 10px;
    transition: background-color 0.2s ease, color 0.2s ease;
}

.site-nav a:hover {
    background: rgba(255, 255, 255, 0.14);
}

.welcome-chip {
    font-size: 14px;
    font-weight: 700;
    color: var(--header-muted);
    padding: 8px 12px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 999px;
}

.cart-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--header-accent);
    color: #1f2a2f;
    border-radius: 999px;
    font-size: 16px;
}

.cart-link:hover {
    background: #ffd27a;
    color: #1f2a2f;
}

.logout-btn,
.dashboard-btn {
    border: 1px solid rgba(255, 255, 255, 0.22);
}

@media (max-width: 780px) {
    .site-header {
        padding: 16px 18px;
    }

    .site-header .nav-wrap {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }

    .site-logo {
        text-align: center;
    }

    .site-nav {
        justify-content: center;
    }
}
</style>

<header class="site-header">
    <div class="nav-wrap">
        <a class="site-logo" href="index.php">My Ecom</a>

        <ul class="site-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php#products">Products</a></li>
            <li><a href="contact.php">Contact</a></li>

            <?php if (isset($_SESSION['user_email'])): ?>
                <li class="welcome-chip">Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Guest'); ?></li>
                <li><a class="cart-link" href="cart.php" title="View Cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a class="dashboard-btn" href="admin/dashboard.php">Dashboard</a></li>
                <li><a class="logout-btn" href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>
