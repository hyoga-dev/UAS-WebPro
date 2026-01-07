<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Sign Up - Hyoga</title>
</head>
<body>
    <div class="login-container">
        <div id="login-card">
            <img src="Assets/Image/phyto-login-banner.png" alt="login banner" >
            <div id="login-detail">
                <h1>Create Account</h1>

                <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <p style="color: green; font-size: 14px;">Akun berhasil dibuat! Silakan login.</p>
                <?php elseif(isset($_GET['error'])): ?>
                    <p style="color: red; font-size: 14px;">Terjadi kesalahan atau email sudah terdaftar.</p>
                <?php endif; ?>

                <form action="auth_signup.php" method="POST">
                    <label for="fname">Full Name</label> <br>
                    <input type="text" id="fname" name="fname" required> <br>
                    
                    <label for="email">Email</label> <br>
                    <input type="email" id="email" name="email" required> <br>
                    
                    <label for="Password">Password</label> <br>
                    <input type="password" id="Password" name="Password" required>
                    
                    <button type="submit" name="signup">Sign Up</button>
                </form>

                <br>
                <div id="signup">
                    <div>Already have account?</div>
                    <a href="login.php">Sign In</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>