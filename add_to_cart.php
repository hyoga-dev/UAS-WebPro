<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pytho");

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id_produk'");
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id_produk])) {
            $_SESSION['cart'][$id_produk]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id_produk] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
    }
}

header("Location: dashboard_frame/shop.php");
exit;
?>