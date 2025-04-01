<?php
session_start();
require_once 'db/db.php';

if (!isset($_GET['tracking'])) {
    header("Location: track.php");
    exit;
}

$tracking_number = $_GET['tracking'];

// ค้นหาใน orders และ customers
$sql = "
    SELECT o.tracking_number, 
           COALESCE(o.delivery_status, 'No status available') AS delivery_status, 
           COALESCE(o.updated_at, o.created_at) AS last_update,
           o.created_at,
           o.firstname, o.lastname, o.address, o.destination_address, o.price, o.province
    FROM orders o
    WHERE o.tracking_number = :tracking_number
    UNION
    SELECT c.tracking_number, 
           'Pending' AS delivery_status, 
           c.created_at AS last_update,
           c.created_at,
           c.firstname, c.lastname, c.address, NULL AS destination_address, c.price, c.province
    FROM customers c
    WHERE c.tracking_number = :tracking_number
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
$stmt->execute();
$tracking_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tracking_data) {
    header("Location: track.php?error=notfound");
    exit;
}

// ข้อมูลระยะทาง
$distanceToSriracha = [
    // your distance data
];

// กำหนดความเร็วเฉลี่ยในการขนส่ง (เช่น 60 km/h)
$average_speed = 60; 

// คำนวณเวลาจัดส่งตามระยะทางจาก province
$province = strtolower($tracking_data['province']);  // Province จากข้อมูล
$distance = isset($distanceToSriracha[$province]) ? $distanceToSriracha[$province] : 100;  // ใช้ระยะทางจาก province หรือกำหนดค่าคงที่ถ้าไม่พบ
$delivery_time_hours = $distance / $average_speed;
$delivery_time_minutes = $delivery_time_hours * 60;  // คำนวณเป็นนาที
$delivery_time_days = floor($delivery_time_minutes / (24 * 60));
$delivery_time_minutes %= (24 * 60);
$delivery_time_hours = floor($delivery_time_minutes / 60);
$delivery_time_minutes %= 60;

$delivery_time = "$delivery_time_days days $delivery_time_hours hours $delivery_time_minutes minutes";

// Handle the cancel button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
    $update_sql = "UPDATE orders SET delivery_status = 'Cancelled' WHERE tracking_number = :tracking_number";
    $stmt = $conn->prepare($update_sql);
    $stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
    $stmt->execute();

    // After updating, refresh the page to reflect the new status
    header("Location: track.php?tracking=$tracking_number");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Status</title>
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f4f4;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start; /* Align items to the top */
    min-height: 100vh;
    text-align: center;
    padding-top: 0; /* Remove any top padding */
}

.navbar {
    background-color: lightsteelblue;
    padding: 15px 20px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed; /* Keep navbar at the top */
    top: 0;
    left: 0;
    z-index: 1000;
}

.navbar .logo {
    font-size: 32px;
    font-weight: bold;
    color: white; 
}

.navbar ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar ul li {
    margin-left: 20px;
}

.navbar ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    padding: 8px 12px;
    transition: background 0.3s, color 0.3s;
}

.navbar ul li a:hover {
    background-color: #e9e104;
    border-radius: 4px;
}

.parcel-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    width: 100%;
    margin-top: 100px; /* Add space for the fixed navbar */
    text-align: center;
}

.parcel-container h1, .parcel-container h2 {
    color: #333;
    margin-bottom: 10px;
}

.parcel-container p {
    font-size: 16px;
    color: #555;
    margin: 5px 0;
}

.parcel-container a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
    text-align: center;
    font-weight: bold;
}

.parcel-container a:hover {
    background-color: #218838;
}

.cancel-button {
    background-color: #dc3545; /* Red background for cancel button */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}

.cancel-button:hover {
    background-color: #c82333;
}


</style>
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

    <div class="parcel-container">
        <h1>Tracking Status</h1>
        <h2>Tracking Number: <?php echo htmlspecialchars($tracking_data["tracking_number"]); ?></h2>
        <h2>Status: <?php echo htmlspecialchars($tracking_data["delivery_status"]); ?></h2>
        <p>Last Updated: <?php echo $tracking_data["last_update"]; ?></p>
        
        <!-- แสดงระยะเวลาในการจัดส่ง -->
        <p>Delivery Time: <?php echo $delivery_time; ?></p>

        <!-- แสดง destination_address เฉพาะเมื่อมีข้อมูล -->
        <?php if (!empty($tracking_data['destination_address'])): ?>
            <p><strong>Destination Address:</strong> <?php echo htmlspecialchars($tracking_data['destination_address']); ?></p>
        <?php endif; ?>

        <!-- แสดงข้อมูลอื่น ๆ ของผู้ใช้ -->
        <p><strong>Firstname:</strong> <?php echo htmlspecialchars($tracking_data['firstname']); ?></p>
        <p><strong>Lastname:</strong> <?php echo htmlspecialchars($tracking_data['lastname']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($tracking_data['address']); ?></p>
        <p><strong>Province:</strong> <?php echo htmlspecialchars($tracking_data['province']); ?></p>
        <p><strong>Price:</strong> ฿<?php echo number_format($tracking_data['price'], 2); ?></p>

        <!-- Cancel Button -->
        <?php if ($tracking_data['delivery_status'] !== 'Cancelled'): ?>
            <form method="POST" action="">
                <button type="submit" name="cancel" class="cancel-button">Cancel Order</button>
            </form>
        <?php else: ?>
            <p>Status: Cancelled</p>
        <?php endif; ?>

        <a href="track.php">กลับไปหน้าตรวจสอบ</a>
    </div>
</body>
</html>

