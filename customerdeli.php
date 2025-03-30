<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delivery</title>
    <link rel="stylesheet" href="css/Nextcallus.css">
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
        <h2>Confirm Pickup and Delivery</h2>
        <form action="NextCustomerdeli.php" method="POST">
    <input type="text" name="firstname" placeholder="Firstname" required>
    <input type="text" name="lastname" placeholder="Lastname" required><br>
    <input type="tel" name="tel" placeholder="Tel" required><br>
    <input type="text" name="address" placeholder="Address" required><br>

    <label for="delivery_type">Delivery Type:</label>
    <select name="delivery_type" id="delivery_type" required>
        <option value="standard">Standard</option>
        <option value="express">Express</option>
    </select><br>

    <label for="weight">Product Weight (kg):</label>
    <input type="number" name="weight" id="weight" placeholder="Enter weight in kg" step="0.1" min="0" required><br>

    <label for="product_type">Product Type:</label>
    <select name="product_type" id="product_type" required>
        <option value="general_use">General Use</option>
        <option value="electronics">Electronics</option>
    </select><br>

    <!-- ปุ่ม "Next" สำหรับไปต่อ -->
    <button type="submit">Next</button>

    <!-- ปุ่ม "Cancel" กลับไปหน้า homepage.php หรือ customerdeli.php -->
    <button type="button" onclick="window.location.href='homepage.php';">Cancel</button>
</form>


    </div>
</body>
</html>
