<?php
session_start();
require_once 'db/db.php'; // เชื่อมต่อฐานข้อมูล

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["tracking"])) {
    $tracking_number = $_POST["tracking"];

    // ตรวจสอบหมายเลขติดตามจากตาราง orders และ customers
    $sql = "
        SELECT tracking_number FROM orders WHERE tracking_number = :tracking_number
        UNION
        SELECT tracking_number FROM customers WHERE tracking_number = :tracking_number
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // ถ้าพบหมายเลขติดตามให้ไปยัง tracking_result.php พร้อมพารามิเตอร์ tracking_number
        header("Location: tracking_result.php?tracking=$tracking_number");
        exit;
    } else {
        $error_message = "ไม่พบหมายเลขติดตามนี้ในระบบ กรุณาตรวจสอบอีกครั้ง";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking</title>
    <link rel="stylesheet" href="css/track.css">
</head>
<body>
    <nav class="navbar">
        <a href="homepage.php" class="logo">SeExpress</a>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="track.php">Track</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </nav>

    <div class="track-container">
        <h1>Tracking</h1>

        <form action="" method="POST">
            <input type="text" name="tracking" placeholder="Enter Tracking Number" required><br>
            <button type="submit" class="button button1">Submit</button>
        </form>

        <?php if (!empty($error_message)) : ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
