<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pytho"; 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$status_filter = isset($_GET['status']) ? $_GET['status'] : 'All';

$query = "SELECT * FROM orders";
if ($status_filter !== 'All') {
    $query .= " WHERE status = '$status_filter'";
}
$query .= " ORDER BY tanggal_pemesanan DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>My Orders</title>
</head>
<body style="overflow: hidden;">
    <div id="content">
        <div id="content-header">
            <h1>My Orders</h1>
            <div id="header-navigation">
                something
            </div>
        </div>
        <div id="content-navigation">
            <nav id="order-nav">
                <a href="myOrder.php?status=All" class="<?php echo $status_filter == 'All' ? 'active' : ''; ?>">All</a>
                <a href="myOrder.php?status=Belum Bayar" class="<?php echo $status_filter == 'Belum Bayar' ? 'active' : ''; ?>">Belum Bayar</a>
                <a href="myOrder.php?status=Sedang Dikemas" class="<?php echo $status_filter == 'Sedang Dikemas' ? 'active' : ''; ?>">Sedang Dikemas</a>
                <a href="myOrder.php?status=Dikirim" class="<?php echo $status_filter == 'Dikirim' ? 'active' : ''; ?>">Dikirim</a>
                <a href="myOrder.php?status=Selesai" class="<?php echo $status_filter == 'Selesai' ? 'active' : ''; ?>">Selesai</a>
                <a href="myOrder.php?status=Dibatalkan" class="<?php echo $status_filter == 'Dibatalkan' ? 'active' : ''; ?>">Dibatalkan</a>
            </nav>
        </div>
        
        <div id="order-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="order-card">
                        <div class="order-info">
                            <div class="order-tag">Tanggal pemesanan: <?php echo date('d-m-Y', strtotime($row['tanggal_pemesanan'])); ?></div>
                            <div class="ingfo"><?php echo $row['status']; ?></div>
                        </div>
                        
                        <div class="order">
                            <div class="left-order">
                                <div class="product-pic">
                                    <img src="Assets/Image/<?php echo $row['gambar_produk']; ?>" width="100" alt="">
                                </div>
                                <div class="title-quantity">
                                    <h2><?php echo $row['nama_produk']; ?></h2>
                                    <div class="quantity">
                                        <?php echo $row['jumlah']; ?>x
                                    </div>
                                </div>
                            </div>
                            <div class="order-detail">
                                Rp. <?php echo number_format($row['harga_satuan'], 0, ',', '.'); ?>  
                            </div>
                        </div>

                        <div class="order-nav">
                            <div class="total">
                                <span>Total Pesanan:</span> <span class="total-number">Rp.<?php echo number_format($row['total_harga'], 0, ',', '.'); ?></span>
                            </div>

                            <div class="order-btn-container">
                                <div class="btn-nilai btn-order">Nilai</div>
                                <div class="btn-beli-lagi btn-order">Beli lagi</div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align: center; margin-top: 20px;">Tidak ada pesanan.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function makeActive(element) {
            const links = document.querySelectorAll('#order-nav a');
            links.forEach(link => {
                link.classList.remove('active');
            });
            element.classList.add('active');
        }
    </script>
</body>
</html>