<?php
session_start();
require_once 'db/db.php';

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = !empty($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : NULL;
    $lastname = !empty($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : NULL;
    $tel = !empty($_POST['tel']) ? htmlspecialchars($_POST['tel']) : NULL;
    $address = !empty($_POST['address']) ? htmlspecialchars($_POST['address']) : NULL;
    $delivery_type = !empty($_POST['delivery_type']) ? htmlspecialchars($_POST['delivery_type']) : NULL;
    $weight = !empty($_POST['weight']) ? floatval($_POST['weight']) : 0;
    $product_type = !empty($_POST['product_type']) ? htmlspecialchars($_POST['product_type']) : NULL;
    $price = !empty($_POST['price']) ? floatval($_POST['price']) : 0;

    try {
        $sql = "INSERT INTO orders (tracking_number, firstname, lastname, tel, address, delivery_type, weight, product_type, price) 
        VALUES (:tracking_number, :firstname, :lastname, :tel, :address, :delivery_type, :weight, :product_type, :price)";

$stmt = $conn->prepare($sql);

// Bind ค่าที่ส่งมา
$stmt->bindValue(':tracking_number', 'TRACK-' . strtoupper(uniqid()), PDO::PARAM_STR);
$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':delivery_type', $delivery_type, PDO::PARAM_STR);
$stmt->bindValue(':weight', $weight, PDO::PARAM_STR);
$stmt->bindValue(':product_type', $product_type, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_STR);

$stmt->execute();

        //echo "บันทึกข้อมูลสำเร็จ!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No data received.";
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
        <h2>Confirm Order Details</h2>

        <p><strong>Firstname:</strong> <?php echo $firstname; ?></p>
        <p><strong>Lastname:</strong> <?php echo $lastname; ?></p>
        <p><strong>Tel:</strong> <?php echo $tel; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Delivery Type:</strong> <?php echo $delivery_type; ?></p>
        <p><strong>Product Weight:</strong> <?php echo $weight; ?> kg</p>
        <p><strong>Product Type:</strong> <?php echo $product_type; ?></p>
        <p><strong>Total Price:</strong> ฿<?php echo number_format($price, 2); ?></p>

        <form action="paymentys.php" method="POST">
            <input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
            <input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
            <input type="hidden" name="tel" value="<?php echo $tel; ?>">
            <input type="hidden" name="address" value="<?php echo $address; ?>">
            <input type="hidden" name="delivery_type" value="<?php echo $delivery_type; ?>">
            <input type="hidden" name="weight" value="<?php echo $weight; ?>">
            <input type="hidden" name="product_type" value="<?php echo $product_type; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">

            <button type="submit">Proceed to Payment</button>
            <button type="button" class="track-btn cancel-btn" onclick="window.location.href='homepage.php';">Cancel</button>
        </form>
    </div>
</body>
</html>