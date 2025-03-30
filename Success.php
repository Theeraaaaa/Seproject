<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="css/success.css">
    <script>
        function getQueryParams() {
            const urlParams = new URLSearchParams(window.location.search);
            return {
                firstname: urlParams.get('firstname'),
                lastname: urlParams.get('lastname'),
                tracking_number: urlParams.get('tracking_number')
            };
        }

        function displaySuccessDetails() {
            const details = getQueryParams();
            document.getElementById('firstname').textContent = details.firstname;
            document.getElementById('lastname').textContent = details.lastname;
            document.getElementById('tracking-number').textContent = details.tracking_number;
        }

        window.onload = function() {
            displaySuccessDetails();
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
        <h2>Payment Successful</h2>

        <p><strong>Thank you,</strong> <span id="firstname"></span> <span id="lastname"></span></p>
        <p><strong>Your Tracking Number:</strong> <span id="tracking-number"></span></p>

        <button type="button" onclick="window.location.href='homepage.php';" class="track-btn">Back to Home</button>
    </div>

</body>
</html>
