<?php
$conn = mysqli_connect("localhost", "root", "", "pytho");

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$order_query = "";

switch ($sort) {
    case 'popular':
        $order_query = "ORDER BY reviews DESC"; 
        break;
    case 'price_low':
        $order_query = "ORDER BY price ASC"; 
        break;
    case 'price_high':
        $order_query = "ORDER BY price DESC"; 
        break;
    case 'newest':
    default:
        $order_query = "ORDER BY id DESC"; 
        break;
}

$query = "SELECT * FROM products $order_query";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Shop - Phyto</title>
    <style>
        #filter a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <div id="shop">
        <div id="banner">
            <div>
                <h1>GET 25% OFF </h1>
                <p>Share your referral code and get discount!</p>
                <div class="btn-share">Share</div>
                <a href="#"><div id="square">ha</div></a>
            </div>
            <img src="Assets/Image/thumb-up.png" id="Timage" alt="Thumb up Image">
        </div>

        <div id="filter">
            <a href="shop.php?sort=popular">
                <div class="btn-filter <?php echo $sort == 'popular' ? 'active' : ''; ?>">Popular</div>
            </a>
            <a href="shop.php?sort=newest">
                <div class="btn-filter <?php echo $sort == 'newest' ? 'active' : ''; ?>">Newest</div>
            </a>
            
            <?php if ($sort == 'price_low'): ?>
                <a href="shop.php?sort=price_high">
                    <div class="btn-filter active">Price: Low to High ↑</div>
                </a>
            <?php elseif ($sort == 'price_high'): ?>
                <a href="shop.php?sort=price_low">
                    <div class="btn-filter active">Price: High to Low ↓</div>
                </a>
            <?php else: ?>
                <a href="shop.php?sort=price_low">
                    <div class="btn-filter">Price</div>
                </a>
            <?php endif; ?>
        </div>

        <div id="product-container">
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { 
            ?>
                <div class="product">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                        <img src="Assets/Image/<?php echo $row['image']; ?>" class="product-img" alt="<?php echo $row['name']; ?>">
                    </a>
                    <div class="product-detail">
                        <a href="product_detail.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: inherit;">
                            <p style="font-weight: bold; cursor: pointer;"><?php echo $row['name']; ?></p>
                        </a>
                        <p>
                            <?php 
                            for($i=0; $i<$row['rating']; $i++) echo "⭐"; 
                            echo " (" . $row['reviews'] . ")";
                            ?>
                        </p>
                        <div style="display: flex; margin-top: 16px;">
                            <p style="font-size: 16px;">Rp. <?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                            <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                <div class="btn-chart">add to chart</div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
                } 
            } else {
                echo "<p>Belum ada produk tersedia.</p>";
            }
            ?>
        </div>
    </div>

    </body>
</html>