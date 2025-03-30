<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delivery</title>
    <link rel="stylesheet" href="css/Nextcallus.css">
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
        <h2>Confirm Pickup and Delivery</h2>

        <!-- Customer Information Display -->
        <p><strong>Firstname:</strong> <?php echo htmlspecialchars($_POST['firstname']); ?></p>
        <p><strong>Lastname:</strong> <?php echo htmlspecialchars($_POST['lastname']); ?></p>
        <p><strong>Tel:</strong> <?php echo htmlspecialchars($_POST['tel']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($_POST['address']); ?></p>
        <p><strong>Delivery Type:</strong> <?php echo htmlspecialchars($_POST['delivery_type']); ?></p>
        <p><strong>Product Weight:</strong> <?php echo htmlspecialchars($_POST['weight']); ?> kg</p>
        <p><strong>Product Type:</strong> <?php echo htmlspecialchars($_POST['product_type']); ?></p>

        <!-- Calculate Estimated Price -->
        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีค่าถูกส่งมาหรือไม่
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : "N/A";
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : "N/A";
    $tel = isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) : "N/A";
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : "N/A";
    $delivery_type = isset($_POST['delivery_type']) ? htmlspecialchars($_POST['delivery_type']) : "N/A";
    $weight = isset($_POST['weight']) ? (float)$_POST['weight'] : 0;
    $product_type = isset($_POST['product_type']) ? htmlspecialchars($_POST['product_type']) : "N/A";
    
    // คำนวณราคา
    $base_price = 50;
    $price = $base_price + ($weight * 10);

    if ($delivery_type == 'express') {
        $price += 30;
    }
    if ($product_type == 'electronics') {
        $price += 20;
    }
} else {
    die("No data received!"); // หากไม่มีข้อมูล ให้หยุดทำงาน
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delivery</title>
    <link rel="stylesheet" href="css/Nextcallus.css">
</head>
<body>

        <form action="confirm_order.php" method="POST">
            <input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
            <input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
            <input type="hidden" name="tel" value="<?php echo $tel; ?>">
            <input type="hidden" name="address" value="<?php echo $address; ?>">
            <input type="hidden" name="delivery_type" value="<?php echo $delivery_type; ?>">
            <input type="hidden" name="weight" value="<?php echo $weight; ?>">
            <input type="hidden" name="product_type" value="<?php echo $product_type; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">

            <button type="button" class="track-btn" onclick="window.location.href='paymentys.php';">Confirm and Proceed</button>
            <button type="button" class="track-btn" onclick="window.location.href='customerdeli.php';">Cancel</button>
        </form>
    </div>

</body>
</html>
