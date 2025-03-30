<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/payment.css">
    <script>
        function getQueryParams() {
            const urlParams = new URLSearchParams(window.location.search);
            return {
                firstname: urlParams.get('firstname'),
                lastname: urlParams.get('lastname'),
                tel: urlParams.get('tel'),
                address: urlParams.get('address'),
                destination_address: urlParams.get('destination_address'),
                delivery_type: urlParams.get('delivery_type'),
                weight: urlParams.get('weight'),
                product_type: urlParams.get('product_type'),
                price: urlParams.get('price')
            };
        }

        function displayOrderDetails() {
            const orderDetails = getQueryParams();
            document.getElementById('firstname').textContent = orderDetails.firstname;
            document.getElementById('lastname').textContent = orderDetails.lastname;
            document.getElementById('tel').textContent = orderDetails.tel;
            document.getElementById('address').textContent = orderDetails.address;
            document.getElementById('destination_address').textContent = orderDetails.destination_address;
            document.getElementById('delivery_type').textContent = orderDetails.delivery_type;
            document.getElementById('weight').textContent = orderDetails.weight;
            document.getElementById('product_type').textContent = orderDetails.product_type;
            document.getElementById('price').textContent = orderDetails.price;
        }

        function completePayment() {
            alert("ชำระเงินสำเร็จ!");

            // สร้าง Tracking Number สุ่ม
            const trackingNumber = "TRACK-" + Math.random().toString(36).substring(2, 10).toUpperCase();

            // ดึงค่าจากฟอร์ม
            const params = new URLSearchParams(getQueryParams());
            params.append("tracking_number", trackingNumber); // เพิ่ม Tracking Number

            // ไปหน้า Success.php พร้อมส่งข้อมูล
            window.location.href = "Success.php?" + params.toString();
        }

        function cancelOrder() {
            window.history.back();
        }

        window.onload = function() {
            displayOrderDetails();
        };
    </script>
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
        <p><strong>Firstname:</strong> <span id="firstname"></span></p>
        <p><strong>Lastname:</strong> <span id="lastname"></span></p>
        <p><strong>Tel:</strong> <span id="tel"></span></p>
        <p><strong>Address:</strong> <span id="address"></span></p>
        <p><strong>Destination Address:</strong> <span id="destination_address"></span></p>
        <p><strong>Delivery Type:</strong> <span id="delivery_type"></span></p>
        <p><strong>Product Weight:</strong> <span id="weight"></span> kg</p>
        <p><strong>Product Type:</strong> <span id="product_type"></span></p>
        <p><strong>Estimated Price:</strong> <span id="price"></span> THB</p>

        <div class="button-container">
            <button type="button" onclick="completePayment()" class="track-btn">Complete Payment</button>
            <button type="button" onclick="cancelOrder()" class="track-btn cancel-btn">Cancel Order</button>
        </div>
    </div>
</body>
</html>
