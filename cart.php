<?php
session_start();
$total_bayar = 0;

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['action'] == 'add') {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } elseif ($_GET['action'] == 'reduce') {
        if ($_SESSION['cart'][$id]['quantity'] > 1) {
            $_SESSION['cart'][$id]['quantity'] -= 1;
        } else {
            unset($_SESSION['cart'][$id]); 
        }
    }
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>My Cart</title>
    <style>
        .qty-btn {
            padding: 2px 8px;
            background: #eee;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            font-weight: bold;
        }
        .qty-btn:hover { background: #ddd; }
        .qty-input {
            width: 40px;
            text-align: center;
            border: none;
            background: transparent;
        }
    </style>
</head>
<body style="overflow-x: hidden;">
    <div id="content">
        <div id="cart-header">
            <h1>My Cart</h1>
        </div>

        <div id="cart-item-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 35%;">Produk</th>
                        <th>Harga Satuan</th>
                        <th>Kuantitas</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <?php foreach ($_SESSION['cart'] as $id => $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total_bayar += $subtotal;
                        ?>
                        <tr style="padding-top: 26px;">
                            <td>
                                <div class="product-detail-container">
                                    <img src="Assets/Image/<?php echo $item['image']; ?>" alt="" width="100px">
                                    <div><?php echo $item['name']; ?></div>
                                </div>
                            </td>
                            <td class="harga-satuan">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                            <td class="kuantitas">
                                <a href="cart.php?action=reduce&id=<?php echo $id; ?>" class="qty-btn">-</a>
                                <input type="text" class="qty-input" value="<?php echo $item['quantity']; ?>" readonly>
                                <a href="cart.php?action=add&id=<?php echo $id; ?>" class="qty-btn">+</a>
                            </td>
                            <td class="total-harga">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            <td>
                                <a href="remove_cart.php?id=<?php echo $id; ?>" style="color: red; text-decoration: none; font-weight: bold;">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold; padding: 20px;">Total yang harus dibayar:</td>
                            <td colspan="2" style="font-weight: bold; font-size: 1.2em; color: #2ecc71;">
                                Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 50px;">
                                <h3>Keranjang belanja kosong.</h3>
                                <a href="dashboard_frame/shop.php" style="color: #2ecc71;">Ayo belanja sekarang!</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if (!empty($_SESSION['cart'])): ?>
                <div style="margin-top: 20px; text-align: right; padding-right: 20px; padding-bottom: 50px;">
                    <a href="checkout.php" class="btn-share" style="text-decoration: none; display: inline-block; cursor: pointer;">Checkout Sekarang</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>