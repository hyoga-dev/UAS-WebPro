<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pytho");

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang belanja kosong!'); window.location='dashboard_frame/shop.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$tanggal = date('Y-m-d H:i:s');

foreach ($_SESSION['cart'] as $id_produk => $item) {
    $nama_produk = $item['name'];
    $gambar = $item['image'];
    $jumlah = $item['quantity'];
    $harga_satuan = $item['price'];
    $total_harga = $harga_satuan * $jumlah;
    $status = "Sedang Dikemas"; 

    $query = "INSERT INTO orders (tanggal_pemesanan, status, nama_produk, gambar_produk, jumlah, harga_satuan, total_harga) 
              VALUES ('$tanggal', '$status', '$nama_produk', '$gambar', '$jumlah', '$harga_satuan', '$total_harga')";
    
    mysqli_query($conn, $query);
}

unset($_SESSION['cart']);

echo "<script>alert('Pesanan berhasil dibuat!'); window.location='myOrder.php';</script>";
exit;
?>