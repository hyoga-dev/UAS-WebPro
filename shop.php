<?php
$conn = mysqli_connect("localhost", "root", "", "pytho");

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Shop - Phyto</title>
</head>
<body>
    <div id="shop">
        <div id="banner">
            <div>
                <h1>GET 25% OFF </h1>
                <p>Share your referral code and get discount!    </p>
                <div class="btn-share">Share</div>
                <a href="#">
                    <div id="square">ha</div>
                </a>
            </div>
            <img src="Assets/Image/thumb-up.png" id="Timage" alt="Thumb up Image">
        </div>

        <div id="filter">
            <div class="btn-filter" onclick="makeActive(this)">Popular</div>
            <div class="btn-filter" onclick="makeActive(this)">Newest</div>
            <div class="btn-filter" onclick="makeActive(this)">Price</div>
        </div>

        <div id="product-container">
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { 
            ?>
                <div class="product">
                    <img src="Assets/Image/<?php echo $row['image']; ?>" class="product-img" alt="<?php echo $row['name']; ?>">
                    <div class="product-detail">
                        <p><?php echo $row['name']; ?></p>
                        <p>
                            <?php 
                            for($i=0; $i<$row['rating']; $i++) echo "⭐"; 
                            echo " (" . $row['reviews'] . ")";
                            ?>
                        </p>
                        <div style="display: flex;  margin-top: 16px;">
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

    <script>
        function makeActive(element) {
            const links = document.querySelectorAll('#filter div');
            links.forEach(link => {
                link.classList.remove('active');
            });
            element.classList.add('active');
        }
    </script>
</body>
</html>