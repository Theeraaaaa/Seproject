<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Us</title>
    <link rel="stylesheet" href="css/callus.css">
    <script>
        function calculatePrice() {
            let weight = parseFloat(document.getElementById('weight').value) || 0;
            let deliveryType = document.getElementById('delivery_type').value;
            let productType = document.getElementById('product_type').value;
            let basePrice = 50;
            let price = basePrice + (weight * 10);

            if (deliveryType === 'express') {
                price += 30;
            }
            if (productType === 'electronics') {
                price += 20;
            }
            document.getElementById('price').value = price.toFixed(2);
        }
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
        <h2>Delivery</h2>
        <form action="Nextcallus.php" method="POST" class="track-form">
    <input type="text" name="firstname" placeholder="Firstname" required>
    <input type="text" name="lastname" placeholder="Lastname" required><br>
    <input type="tel" name="tel" placeholder="Tel" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <input type="text" name="destination_address" placeholder="Destination Address" required><br>
    
    <label for="delivery_type">Delivery Type:</label>
    <select name="delivery_type" id="delivery_type" required>
        <option value="">Select Delivery Type</option>
        <option value="express">Express</option>
        <option value="standard">Standard</option>
    </select><br>

    <label for="weight">Product Weight (kg):</label>
    <input type="number" name="weight" id="weight" placeholder="Enter weight in kg" step="0.1" required><br>

    <label for="product_type">Product Type:</label>
                <select name="product_type" id="product_type" required onchange="calculatePrice()">
                <option value="electronics">Select Type</option>
                <option value="general_use">General Use</option>
                    <option value="electronics">Electronics</option>

    </select><br>

    <label for="price">Total Price (฿):</label>
    <input type="text" name="price" id="price" readonly><br>

    <!-- ปุ่มยกเลิก + ปุ่มถัดไป -->
    <button type="button" class="track-btn cancel-btn" onclick="window.location.href='homepage.php';">Cancel</button>
    <button type="submit" class="track-btn Next">Next</button> <!-- ส่งข้อมูลไปที่ Nextcallus.php -->
</form>

    </div>

    
</body>
</html>
