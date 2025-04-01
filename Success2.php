<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Status</title>
    <link rel="stylesheet" href="css/success.css">
    <style>
        /* CSS สำหรับจัดตำแหน่งให้อยู่ตรงกลาง */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center;
        }

        .info-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
            width: 80%;
            max-width: 500px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .button-link {
            margin-top: 20px;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            font-size: 16px;
        }

        .button-link:hover {
            background-color: #45a049;
        }
    </style>
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
        </div>
    </div>

</body>
</html>

<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seproject";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tracking_number = isset($_POST['tracking_number']) ? $_POST['tracking_number'] : "";
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";
    $tel = isset($_POST['tel']) ? $_POST['tel'] : "";
    $address = isset($_POST['address']) ? $_POST['address'] : "";
    $destination_address = isset($_POST['destination_address']) ? $_POST['destination_address'] : "";
    $province = isset($_POST['province']) ? $_POST['province'] : "";
    $delivery_type = isset($_POST['delivery_type']) ? $_POST['delivery_type'] : "";
    $weight = isset($_POST['weight']) ? (float)$_POST['weight'] : 0;
    $product_type = isset($_POST['product_type']) ? $_POST['product_type'] : "";
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;

    // สร้างคำสั่ง SQL เพื่อบันทึกข้อมูลลงฐานข้อมูล
    $sql = "INSERT INTO orders (tracking_number, firstname, lastname, tel, address, destination_address, province, delivery_type, weight, product_type, price) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // เตรียมคำสั่ง SQL
    if ($stmt = $conn->prepare($sql)) {
        // ผูกค่าตัวแปรกับพารามิเตอร์
        $stmt->bind_param("ssssssssdsd", $tracking_number, $firstname, $lastname, $tel, $address, $destination_address, $province, $delivery_type, $weight, $product_type, $price);

        // ประมวลผลคำสั่ง
        if ($stmt->execute()) {
            echo "<p>Payment Successful! Your tracking number is: <strong>$tracking_number</strong></p>";
            echo "<a href='homepage.php'>Go to Home</a>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // ปิดคำสั่ง SQL
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "<p>Error: Invalid Request</p>";
}

// ดึงข้อมูลการติดตามจากฐานข้อมูล
$tracking_number = $_GET['tracking'] ?? '';
if ($tracking_number) {
    $sql = "
        SELECT tracking_number, 
               COALESCE(delivery_status, 'No status available') AS delivery_status, 
               COALESCE(updated_at, created_at) AS last_update, 
               COALESCE(distance_km, 0) AS distance_km, 
               COALESCE(estimated_time, 0) AS estimated_time
        FROM orders
        WHERE tracking_number = ?
    ";

    // เตรียมและประมวลผลคำสั่ง SQL
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $tracking_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $tracking_data = $result->fetch_assoc();
        $stmt->close();
    }
} else {
    $tracking_data = null;
}

// ปิดการเชื่อมต่อ
$conn->close();
?>

