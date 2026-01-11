<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pytho");

// Proteksi: Jika keranjang kosong atau belum login, arahkan balik
if (!isset($_SESSION['login']) || empty($_SESSION['cart'])) {
    header("Location: dashboard_frame/shop.php");
    exit;
}

$total_barang = 0;
$total_bayar = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_barang += $item['quantity'];
    $total_bayar += ($item['price'] * $item['quantity']);
}

// Biaya pengiriman statis (Contoh)
$ongkir = 15000;
$grand_total = $total_bayar + $ongkir;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Phyto</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            padding: 40px;
            background-color: #fcfcfc;
            min-height: 100vh;
        }
        .checkout-box {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .product-list-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .product-list-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #555;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px dashed #eee;
            font-size: 1.2em;
            font-weight: bold;
            color: #2ecc71;
        }
        .btn-confirm {
            width: 100%;
            padding: 15px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-confirm:hover { background-color: #27ae60; }
        .address-section input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="left-side">
            <a href="cart.php" style="text-decoration: none; color: #888;">← Kembali ke Keranjang</a>
            <h1 style="margin: 20px 0;">Konfirmasi Pesanan</h1>
            
            <div class="checkout-box address-section">
                <h3>Informasi Pengiriman</h3>
                <p style="color: #888; font-size: 0.9em;">Mohon isi alamat lengkap Anda.</p>
                <form id="checkoutForm" action="process_checkout.php" method="POST">
                    <input type="text" name="nama_penerima" placeholder="Nama Penerima" required value="<?php echo $_SESSION['user_name']; ?>">
                    <input type="text" name="telepon" placeholder="Nomor Telepon" required>
                    <textarea name="alamat" style="width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #ddd; border-radius: 8px;" rows="4" placeholder="Alamat Lengkap (Jalan, Blok, No. Rumah)" required></textarea>
            </div>

            <div class="checkout-box" style="margin-top: 20px;">
                <h3>Produk yang Dipesan</h3>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <div class="product-list-item">
                    <img src="Assets/Image/<?php echo $item['image']; ?>" alt="">
                    <div style="flex-grow: 1;">
                        <h4 style="margin: 0;"><?php echo $item['name']; ?></h4>
                        <p style="margin: 5px 0; color: #888;"><?php echo $item['quantity']; ?> x Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></p>
                    </div>
                    <div style="font-weight: bold;">
                        Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="right-side">
            <div class="checkout-box" style="position: sticky; top: 40px;">
                <h3>Ringkasan Pembayaran</h3>
                <div style="margin-top: 20px;">
                    <div class="summary-row">
                        <span>Total Harga (<?php echo $total_barang; ?> Barang)</span>
                        <span>Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span>Rp <?php echo number_format($ongkir, 0, ',', '.'); ?></span>
                    </div>
                    <div class="total-row">
                        <span>Total Belanja</span>
                        <span>Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></span>
                    </div>
                </div>
                
                <input type="hidden" name="total_final" value="<?php echo $grand_total; ?>">
                <button type="submit" class="btn-confirm">Konfirmasi & Bayar</button>
                </form>
                
                <p style="font-size: 0.8em; color: #aaa; text-align: center; margin-top: 15px;">
                    Dengan mengklik tombol, Anda menyetujui syarat dan ketentuan Phyto Store.
                </p>
            </div>
        </div>
    </div>
</body>
</html>