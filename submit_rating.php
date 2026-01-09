<?php
$conn = mysqli_connect("localhost", "root", "", "pytho");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $new_rating = (int)$_POST['rating_value'];

    if ($new_rating > 0) {
        $res = mysqli_query($conn, "SELECT rating, reviews FROM products WHERE name = '$product_name'");
        $data = mysqli_fetch_assoc($res);

        if ($data) {
            $old_rating = $data['rating'];
            $old_reviews = $data['reviews'];

            $total_reviews = $old_reviews + 1;
            $updated_rating = round((($old_rating * $old_reviews) + $new_rating) / $total_reviews);

            mysqli_query($conn, "UPDATE products SET rating = '$updated_rating', reviews = '$total_reviews' WHERE name = '$product_name'");
        }
    }
}

header("Location: myOrder.php?status=Selesai");
exit;