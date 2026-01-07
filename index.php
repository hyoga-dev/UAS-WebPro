<?php
session_start();

// Cek apakah user sudah login, jika belum lempar ke halaman login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phyto Store - Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="wrapper">
        
        <div id="sidebar">
            <h1>Phyto Store</h1>
            
            <nav>
                <a href="dashboard.php" target="content" class="selected" onclick="makeActive(this)">Dashboard</a>
                <a href="myOrder.php" target="content" onclick="makeActive(this)">My Orders</a>
                <a href="logout.php" style="color: #ff4d4d;">Logout</a>
            </nav>

            <h2>Categories</h2>

            <label class="custom-container">
                <input type="checkbox" checked="checked">
                <span class="checkmark"></span>
                Gardening
            </label>
            <label class="custom-container">
                <input type="checkbox" checked="checked">
                <span class="checkmark"></span>
                Plants
            </label>
            <label class="custom-container">
                <input type="checkbox" checked="checked">
                <span class="checkmark"></span>
                Seeds
            </label>
            <label class="custom-container">
                <input type="checkbox" checked="checked">
                <span class="checkmark"></span>
                Planters
            </label>
        </div>

        <iframe src="dashboard.php" name="content" frameborder="0" width="100%" id="i-content"></iframe>
    </div>

    <script>
        function makeActive(element) {
            const currentActive = document.querySelector('nav a.selected');
            
            if (currentActive) {
                currentActive.classList.remove('selected');
            }
            
            element.classList.add('selected');
        }
    </script>
</body>
</html>