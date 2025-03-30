<?php

session_start();
require_once 'db/db.php';

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tel = $_POST['tel'];
    $urole = 'user';

    if (empty($username)) {
        $_SESSION['error'] = 'Please enter your username';
        header("location: register.php");
        exit();
    } else if (empty($password)) {
        $_SESSION['error'] = 'Please enter your password';
        header("location: register.php");
        exit();
    } else if (strlen($password) > 20 || strlen($password) < 5) {
        $_SESSION['error'] = 'Password must be 5 to 20 characters long';
        header("location: register.php");
        exit();
    } else if (empty($email)) {
        $_SESSION['error'] = 'Please enter your email';
        header("location: register.php");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email';
        header("location: register.php");
        exit();
    } else if (empty($tel)) {
        $_SESSION['error'] = 'Please enter your telephone number';
        header("location: register.php");
        exit();
    }

    try {
        // ตรวจสอบว่าอีเมลมีอยู่ในระบบแล้วหรือยัง
        $check_email = $conn->prepare("SELECT email FROM user WHERE email = :email");
        $check_email->bindParam(":email", $email);
        $check_email->execute();
        $row = $check_email->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $_SESSION['warning'] = "Email has already been used <a href='login.php'>click here</a> to login";
            header("location: register.php");
            exit();
        }

        // Hash รหัสผ่าน
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // เพิ่มข้อมูลลงฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO user (username, email, password, tel, urole)
                                VALUES (:username, :email, :password, :tel, :urole)");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $passwordHash);
        $stmt->bindParam(":tel", $tel);
        $stmt->bindParam(":urole", $urole);
        $stmt->execute();

        $_SESSION['success'] = "Register complete! <a href='login.php' class='alert-link'>Click here</a> to login";
        header("location: register.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = "Something went wrong: " . $e->getMessage();
        header("location: register.php");
        exit();
    }
}

?>
