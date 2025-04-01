<?php
session_start();
require_once 'db/db.php';

// ตรวจสอบว่าได้เข้าสู่ระบบแล้วหรือยัง
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];  // สมมุติว่าใช้ user_id ในการระบุผู้ใช้

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "
    SELECT firstname, lastname, address, province, email, phone
    FROM customers
    WHERE id = :user_id
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

// ถ้าหากไม่พบข้อมูลผู้ใช้
if (!$user_data) {
    echo "User data not found.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <a href="homepage.php" class="logo">SeExpress</a>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="user.php">User Info</a></li>
            <li><a href="track.php">Track</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </nav>

    <div class="user-container">
        <h1>User Information</h1>
        
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($user_data['firstname']); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user_data['lastname']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user_data['address']); ?></p>
        <p><strong>Province:</strong> <?php echo htmlspecialchars($user_data['province']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_data['phone']); ?></p>

        <a href="edit_user.php">Edit Profile</a>
    </div>
</body>
</html>
