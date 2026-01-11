<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pytho");

// Cek koneksi dan session
if (!isset($_SESSION['login']) || empty($_SESSION['cart'])) {
    header("Location: dashboard_frame/shop.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form checkout
    $nama_penerima = mysqli_real_escape_string($conn, $_POST['nama_penerima']);
    $telepon       = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat        = mysqli_real_escape_string($conn, $_POST['alamat']);
    $tanggal       = date('Y-m-d H:i:s');
    $status        = "Sedang Dikemas"; // Status default setelah bayar

    // Loop setiap item di keranjang untuk dimasukkan ke database satu per satu
    foreach ($_SESSION['cart'] as $id_produk => $item) {
        $nama_produk   = $item['name'];
        $gambar        = $item['image'];
        $jumlah        = $item['quantity'];
        $harga_satuan  = $item['price'];
        $total_harga   = $harga_satuan * $jumlah;

        // Query INSERT yang lebih lengkap
        // Pastikan kolom-kolom ini ada di tabel orders kamu
        $query = "INSERT INTO orders (
                    tanggal_pemesanan, 
                    status, 
                    nama_produk, 
                    gambar_produk, 
                    jumlah, 
                    harga_satuan, 
                    total_harga
                  ) VALUES (
                    '$tanggal', 
                    '$status', 
                    '$nama_produk', 
                    '$gambar', 
                    '$jumlah', 
                    '$harga_satuan', 
                    '$total_harga'
                  )";

        mysqli_query($conn, $query);
    }

    // Kosongkan keranjang setelah berhasil diproses
    unset($_SESSION['cart']);

    // Redirect ke halaman My Order dengan pesan sukses
    echo "<script>
            alert('Pesanan Berhasil Dibuat! Alamat tujuan: $alamat');
            window.location.href = 'myOrder.php?status=Sedang Dikemas';
          </script>";
} else {
    header("Location: checkout_page.php");
}
exit;