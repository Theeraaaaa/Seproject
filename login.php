<?php
session_start();
require_once 'db/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<link rel="stylesheet" href="css/login.css">

<body>
    
   <h1>Login</h1>

    <div class="login-container">
        <h1>SeExpress</h1>

        <form action="signin_db.php" method="post">

           <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>

    <input type="username" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>

    <button class="button button1" type="submit" name="signin">Submit</button> 
</form>

        <a href="index.php">
            <button class="button button2">Cancel</button>
        </a>
    <p>Don't have an account? <a href="register.php" class="btn btn-register">Register</a></p>

    </div>

</body>

</html>