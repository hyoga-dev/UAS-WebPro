<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pytho");

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];

            header("Location: index.php"); 
            exit;
        }
    }
    
    header("Location: login.php?error=true");
    exit;
}
?>