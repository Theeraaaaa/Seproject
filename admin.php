<?php 
session_start();
require_once 'db/db.php';

// ตรวจสอบการล็อกอินของผู้ดูแลระบบ
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'Please login';
    header('location: login.php');
    exit();
}

// แสดงข้อมูลลูกค้า รวมถึง destination_address
$sql = "
    SELECT o.id, o.firstname, o.lastname, o.tel, o.address, o.tracking_number, o.delivery_status, 
           COALESCE(o.destination_address, 'No destination address') AS destination_address
    FROM orders o
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// แก้ไขสถานะ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $tracking_number = $_POST['tracking_number'];
    $status = $_POST['status'];

    // อัปเดตสถานะในฐานข้อมูล
    $update_sql = "UPDATE orders SET delivery_status = :status WHERE tracking_number = :tracking_number";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $update_stmt->bindParam(':tracking_number', $tracking_number, PDO::PARAM_STR);
    $update_stmt->execute();

    // แสดงข้อความสำเร็จ
    $_SESSION['success'] = "Status updated successfully!";
    header('Location: admin.php'); // รีเฟรชหน้า
    exit();
}

// ลบข้อมูลลูกค้า
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $delete_sql = "DELETE FROM orders WHERE id = :id";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $delete_stmt->execute();

    $_SESSION['success'] = "Customer deleted successfully!";
    header('Location: admin.php'); // รีเฟรชหน้า
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeAdmin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <h1>Admin Page</h1>

    <h2>Delivery</h2>
    <table class="table-container">
        <thead>
            <tr>
                <th>Name</th>
                <th>Lastname</th>
                <th>Tel</th>
                <th>Address</th>
                <th>Tracking</th>
                <th>Status</th>
                <th>Destination Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($customer['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($customer['tel']); ?></td>
                    <td><?php echo htmlspecialchars($customer['address']); ?></td>
                    <td><?php echo htmlspecialchars($customer['tracking_number']); ?></td>
                    <td><?php echo htmlspecialchars($customer['delivery_status']); ?></td>
                    <td><?php echo $customer['destination_address'] !== 'No destination address' ? htmlspecialchars($customer['destination_address']) : 'N/A'; ?></td>
                    <td>
                        <!-- ปุ่มแก้ไขสถานะ -->
                        <form method="POST" action="admin.php" style="display:inline;">
                            <select name="status" required>
                                <option value="Shipped" <?php echo $customer['delivery_status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Pending" <?php echo $customer['delivery_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Cancel" <?php echo $customer['delivery_status'] == 'Cancel' ? 'selected' : ''; ?>>Cancel</option>
                            </select>
                            <input type="hidden" name="tracking_number" value="<?php echo htmlspecialchars($customer['tracking_number']); ?>">
                            <button type="submit" name="update_status">Update Status</button>
                        </form>

                        <!-- ปุ่มลบข้อมูล -->
                        <a href="admin.php?delete=<?php echo $customer['id']; ?>" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
