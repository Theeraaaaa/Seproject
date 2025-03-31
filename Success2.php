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

// ปิดการเชื่อมต่อ
$conn->close();
?>
