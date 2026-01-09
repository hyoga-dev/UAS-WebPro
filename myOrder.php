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
    <style>
    /* Modal sederhana untuk Rating */
    .modal { display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
    .modal-content { background: white; margin: 15% auto; padding: 20px; width: 300px; border-radius: 10px; text-align: center; }
    .stars { font-size: 25px; cursor: pointer; color: #ccc; }
    .stars:hover, .stars.active { color: #f1c40f; }
    .btn-submit-rating { background: #62a72b; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 15px; }
    /* Mematikan tombol jika bukan status Selesai */
    .btn-disabled { opacity: 0.5; cursor: not-allowed; pointer-events: none; }
</style>

<div id="ratingModal" class="modal">
    <div class="modal-content">
        <h3>Nilai Produk</h3>
        <p id="ratingProductName"></p>
        <div class="star-container">
            <span class="stars" onclick="setRating(1)">★</span>
            <span class="stars" onclick="setRating(2)">★</span>
            <span class="stars" onclick="setRating(3)">★</span>
            <span class="stars" onclick="setRating(4)">★</span>
            <span class="stars" onclick="setRating(5)">★</span>
        </div>
        <form action="submit_rating.php" method="POST">
            <input type="hidden" name="product_name" id="inputProductName">
            <input type="hidden" name="rating_value" id="ratingValue" value="0">
            <button type="submit" class="btn-submit-rating">Kirim Nilai</button>
            <button type="button" onclick="closeModal()" style="background:none; border:none; color:red; cursor:pointer;">Batal</button>
        </form>
    </div>
</div>




    <div id="content">
        <div id="content-header">
            <h1>My Orders</h1>
            <div id="header-navigation">
                <div class="cart"><a href="cart.php">cart</a> </div>
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
                                <div class="btn-nilai btn-order <?php echo ($row['status'] != 'Selesai') ? 'btn-disabled' : ''; ?>" 
                                    onclick="openModal('<?php echo $row['nama_produk']; ?>')">
                                    Nilai
                                </div>
                                <a href="shop.php" class="btn-beli-lagi btn-order" style="text-decoration:none;">Beli lagi</a>
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
        function openModal(name) {
            document.getElementById('ratingModal').style.display = 'block';
            document.getElementById('ratingProductName').innerText = name;
            document.getElementById('inputProductName').value = name;
        }

        function closeModal() {
            document.getElementById('ratingModal').style.display = 'none';
        }

        function setRating(n) {
            document.getElementById('ratingValue').value = n;
            const stars = document.querySelectorAll('.stars');
            stars.forEach((s, index) => {
                s.style.color = index < n ? '#f1c40f' : '#ccc';
            });
        }
    </script>
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