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
    SELECT tracking_number, 
           COALESCE(delivery_status, 'No status available') AS delivery_status, 
           COALESCE(updated_at, created_at) AS last_update 
    FROM orders WHERE tracking_number = :tracking_number
    UNION
    SELECT tracking_number, 
           'Pending' AS delivery_status, 
           created_at AS last_update 
    FROM customers WHERE tracking_number = :tracking_number
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
$stmt->execute();
$tracking_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tracking_data) {
    header("Location: track.php?error=notfound");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Status</title>
    <link rel="stylesheet" href="css/trackparcel.css">
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

    <div class="parcel-container">
        <h1>Tracking Status</h1>
        <h2>Tracking Number: <?php echo htmlspecialchars($tracking_data["tracking_number"]); ?></h2>
        <h2>Status: <?php echo htmlspecialchars($tracking_data["delivery_status"]); ?></h2>
        <p>Last Updated: <?php echo $tracking_data["last_update"]; ?></p>
        <a href="track.php">กลับไปหน้าตรวจสอบ</a>
    </div>
</body>
</html>
