<?php
session_start();
require_once 'db/db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเข้าสู่ระบบหรือไม่
if (!isset($_SESSION['user_id'])) {
    die("กรุณาเข้าสู่ระบบก่อน");
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_id = $_SESSION['user_id'];
$sql = "SELECT role FROM users WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบว่าเป็นแอดมินหรือไม่
if (!$user || $user['role'] !== 'admin') {
    die("คุณไม่มีสิทธิ์เปลี่ยนสถานะการจัดส่ง");
}

// ตรวจสอบค่าที่ส่งมาจากฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["tracking_number"]) && !empty($_POST["status"])) {
    $tracking_number = $_POST["tracking_number"];
    $status = $_POST["status"];

    // อัปเดตสถานะในฐานข้อมูล
    $sql = "UPDATE orders SET delivery_status = :status WHERE tracking_number = :tracking_number";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        echo "สถานะถูกอัปเดตเรียบร้อย!";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดต";
    }
}
?>
