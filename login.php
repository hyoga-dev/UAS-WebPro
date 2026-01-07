<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login - Hyoga</title>
</head>
<body>
    <div class="login-container">
        <div id="login-card">
            <img src="Assets/Image/phyto-login-banner.png" alt="login banner" >
            <div id="login-detail">
                <h1>Welcome Back</h1>
                
                <?php if(isset($_GET['error'])): ?>
                    <p style="color: red; font-size: 14px; margin-bottom: 10px;">
                        Email atau password salah!
                    </p>
                <?php endif; ?>

                <form action="auth_login.php" method="POST">
                    <label for="email">Email</label> <br>
                    <input type="text" id="email" name="email" required> <br>
                    
                    <label for="Password">Password</label> <br>
                    <input type="password" id="Password" name="password" required>
                    
                    <button type="submit" name="login">Log in</button>
                </form>

                <br>
                <div id="signup">
                    <div>Don't have account?</div>
                    <a href="signup.php">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>