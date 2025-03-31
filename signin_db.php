<?php
session_start();
require_once 'db/db.php';

if (isset($_POST['signin'])) {
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
    }

    try {
        // ตรวจสอบว่าอีเมลมีอยู่ในระบบแล้วหรือยัง
        $check_data = $conn->prepare("SELECT * FROM user WHERE username = :username");
        $check_data->bindParam(":username", $username);
        $check_data->execute();
        $row = $check_data->fetch(PDO::FETCH_ASSOC);

        if ($check_data->rowCount() > 0) {

            if ($username == $row['username']) {
                if (password_verify($password, $row['password'])) {
                    if ($row['urole'] == 'admin') {
                        $_SESSION['admin_login'] = $row['id'];
                        header("location: admin.php");
                        exit();  // ต้องมี exit หลัง header
                    } else {
                        $_SESSION['user_login'] = $row['id'];
                        header("location: homepage.php");
                        exit();  // ต้องมี exit หลัง header
                    }
                } else {
                    $_SESSION['error'] = 'Wrong password';
                    header("location: login.php");
                    exit();  // ต้องมี exit หลัง header
                }
            } else {
                $_SESSION['error'] = 'Wrong username';
                header("location: login.php");
                exit();  // ต้องมี exit หลัง header
            }
        } else {
            $_SESSION['error'] = 'Data not found';
            header("location: login.php");
            exit();  // ต้องมี exit หลัง header
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // แสดงข้อผิดพลาด
    }
}
?>