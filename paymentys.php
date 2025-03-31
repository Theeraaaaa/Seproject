<?php
// ตรวจสอบว่าเป็นการร้องขอแบบ POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจาก $_POST และทำการกรองเพื่อความปลอดภัย
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : "";
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : "";
    $tel = isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) : "";
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : "";
    $province = isset($_POST['province']) ? htmlspecialchars($_POST['province']) : "";
    $delivery_type = isset($_POST['delivery_type']) ? htmlspecialchars($_POST['delivery_type']) : "";
    $weight = isset($_POST['weight']) ? htmlspecialchars($_POST['weight']) : 0;
    $product_type = isset($_POST['product_type']) ? htmlspecialchars($_POST['product_type']) : "";
    $price = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : 0;
} else {
    // หากไม่ใช่การร้องขอแบบ POST ให้แสดงข้อความผิดพลาด
    echo "<p>Error: Invalid Request</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/payment.css">
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

    <div class="container">
        <h2>Payment</h2>

        <!-- แสดงข้อมูลที่ได้รับจากฟอร์ม -->
        <p><strong>Firstname:</strong> <?php echo $firstname; ?></p>
        <p><strong>Lastname:</strong> <?php echo $lastname; ?></p>
        <p><strong>Tel:</strong> <?php echo $tel; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Province:</strong> <?php echo $province; ?></p>
        <p><strong>Delivery Type:</strong> <?php echo $delivery_type; ?></p>
        <p><strong>Product Weight:</strong> <?php echo number_format($weight, 2); ?> kg</p>
        <p><strong>Product Type:</strong> <?php echo $product_type; ?></p>
        <p><strong>Estimated Price:</strong> <?php echo number_format($price, 2); ?> THB</p>

        <!-- ปุ่มเพื่อดำเนินการต่อไป -->
        <div class="button-container">
            <form action="Success2.php" method="POST">
                <input type="hidden" name="tracking_number" value="TRACK-<?php echo strtoupper(substr(md5(time()), 0, 8)); ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                <button type="submit" class="track-btn">Complete Payment</button>
            </form>
            <button type="button" onclick="window.location.href='customerdeli.php';" class="track-btn cancel-btn">Cancel Order</button>

        </div>
    </div>

</body>
</html>
