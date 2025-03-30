<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Delivery</title>
    <link rel="stylesheet" href="css/customerdeli.css">
</head>
<body>
    <nav class="navbar">
        <a href="homepage.php" class="logo">SeExpress</a>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="track.php">Track</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Deliver Yourself</h2>
        <form action="review_order.php" method="POST" class="track-form">
            <input type="text" name="firstname" placeholder="Firstname" required>
            <input type="text" name="lastname" placeholder="Lastname" required><br>
            <input type="tel" name="tel" placeholder="Tel" required><br>
            <input type="address" name="address" placeholder="Address" required><br>
        
            <label for="delivery_type">Delivery Type:</label>
            <select name="delivery_type" id="delivery_type" required>
                <option value="">Select Delivery Type</option>
                <option value="express">Express</option>
                <option value="standard">Standard</option>
            </select><br>
        
            <label for="weight">Product Weight (kg):</label>
            <input type="number" name="weight" id="weight" placeholder="Enter weight in kg" step="0.1" min="0" required><br>
        
            <label for="product_type">Product Type:</label>
            <select name="product_type" id="product_type" required>
                <option value="">Select Product Type</option>
                <option value="general_use">General Use</option>
                <option value="electronics">Electronics</option>
            </select><br>
        
            <label for="price">Estimated Price (THB):</label>
            <input type="number" name="price" id="price" placeholder="Estimated price based on weight" readonly><br>

            <button type="button" class="track-btn" onclick="window.location.href='homepage.php';">Cancel</button>
            <button type="submit" class="track-btn"onclick="window.location.href='NextCustomerdeli.php';">Next</button>
        </form>
        
    </div>
</body>
</html>