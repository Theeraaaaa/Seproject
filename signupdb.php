<?php

session_start();
require_once 'db/db.php';

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $urole = 'user';

    if(empty($username)) {
            $_SESSION['error'] = 'Please enter your name';
            header("location: register.php");
    }else if (empty($password)) {
        $_SESSION['error'] = 'Please enter your password';
        header("location: register.php");
    }else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        $_SESSION['error'] = 'Password must be 5 to 20 characters long';
        header("location: register.php");
    }else if (empty($email)){
        $_SESSION['error'] = 'Please enter your email';
        header("location: register.php");
    }else if (!filter_var($email , FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'invaild email';
        header("location: register.php");
    }{
        try {

            $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
            $check_email->bindParam(":email",$email);
            $check_email->execute();
            $row = $check_email->fetch (PDO::FETCH_ASSOC);

            if($row['email']== $email) {
                 $_SESSION['warning'] = "Email has already been used <a href='login.php'> click here </a> to login";
                 header("location: register.php");

            }else if(!isset($_SESSION['error'])) {
                $passwordHash = password_hash($password,PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, password, urole)
                 VALUES(:firstname, :lastname, :email, :password, :urole)");
                $stmt->bindParam(":firstname",$firstname);
                $stmt->bindParam(":lastname",$lastname);
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":password",$passwordHash);
                $stmt->bindParam(":urole",$urole);
                $stmt->execute();
                $_SESSION['success'] = "Register complete! <a href='signin.php' class='alert-link'> click here </a> to login";
                header("location: index.php");
            }else {
                $_SESSION['error'] = "Something wrong";
                header("location: index.php");
            }

           
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
            
?>