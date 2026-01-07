<?php
$conn = mysqli_connect("localhost", "root", "", "pytho");

if (isset($_POST['signup'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['fname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['Password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($check_email) > 0) {
        header("Location: signup.php?error=exists");
    } else {
        $query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$hashed_password')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: signup.php?status=success");
        } else {
            header("Location: signup.php?error=failed");
        }
    }
    exit;
}
?>