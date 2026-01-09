<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pytho");

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Produk tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $product['name']; ?> - Phyto Detail</title>
    <style>
        .detail-container {
            display: flex;
            padding: 40px;
            gap: 50px;
            background: white;
            min-height: 100vh;
        }
        .detail-img {
            width: 400px;
            height: 400px;
            object-fit: contain;
            background: #f9f9f9;
            border-radius: 20px;
        }
        .detail-info h1 { font-size: 32px; margin-bottom: 10px; }
        .price-tag { font-size: 24px; color: #62a72b; font-weight: bold; margin: 20px 0; }
        .description { line-height: 1.6; color: #666; margin-bottom: 30px; }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #2ecc71; font-weight: bold; }
    </style>
</head>
<body>
    <div class="detail-container">
        <div>
            <img src="Assets/Image/<?php echo $product['image']; ?>" class="detail-img" alt="">
        </div>
        
        <div class="detail-info">
            <p style="color: #888; text-transform: uppercase;"><?php echo $product['category']; ?></p>
            <h1><?php echo $product['name']; ?></h1>
            <p><?php for($i=0; $i<$product['rating']; $i++) echo "⭐"; ?> (<?php echo $product['reviews']; ?> Reviews)</p>
            
            <div class="price-tag">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>
            
            <div class="description">
                <h3>Tentang Produk</h3>
                <p>Tanaman <?php echo $product['name']; ?> ini adalah pilihan terbaik untuk mempercantik ruangan Anda. Tanaman ini mudah dirawat dan memberikan kesegaran alami di dalam rumah atau kantor.</p>
            </div>

            <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" style="text-decoration: none;">
                <div class="btn-share" style="padding: 15px 40px; text-align: center; display: inline-block;">Tambah ke Keranjang</div>
            </a>
        </div>
    </div>
</body>
</html>