<?php
session_start();
require_once 'db/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegisterPage</title>
</head>
<link rel="stylesheet" href="css/register.css">
<body>
    <h1>Register</h1>

    
    <div class="register-container">
    <form action="signupdb.php" method="post">
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
        <input type="username" name="username" placeholder="Username"required><br>
        <input type="password" name="password" placeholder="Password"required><br>
        <input type="email" name="email" placeholder="Email"required><br>
        <input type="tel" name="tel" placeholder="Tel"required><br>

        <a href="login.php">
            <button class="button button1">Submit</button>
        </a>

        <a href="index.php">
            <button class="button button2">Cancel</button>
        </a>
        
        
    </div>
    
</body>
</html>