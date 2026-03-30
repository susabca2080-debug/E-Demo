<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
elseif (($_SESSION['user_role'] ?? '') !== 'user') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 24px;">
    <h1>User Page</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>.</p>
    <p><a href="index.php">Go to Home</a> | <a href="logout.php">Logout</a></p>
</body>
</html>