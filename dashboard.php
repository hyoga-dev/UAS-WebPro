<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$namaUser = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Phyto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="overflow: hidden;">
    <div id="content">  
        <div id="content-header">
            <div id="welcome">
                <h1>Welcome to Phyto</h1>
                <p>Hello <?php echo htmlspecialchars($namaUser); ?>, welcome back! </p>
            </div>
            <div id="header-navigation">
                <div class="cart"><a href="cart.php">cart</a> </div>
            </div>
        </div>
        
        <div id="content-navigation">
            <nav>
                <a href="shop.php" target="dashboard-content" class="active" onclick="makeActive(this)">Shop</a>
                </nav>
        </div>
        
        <iframe src="shop.php" name="dashboard-content" frameborder="0" width="100%" ></iframe>
    </div>

    <script>
        function makeActive(element) {
            const currentActive = document.querySelector('nav a.active');
            
            if (currentActive) {
                currentActive.classList.remove('active');
            }
            
            element.classList.add('active');
        }
    </script>
</body>
</html>