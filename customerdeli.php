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
            let province = document.getElementById('province').value;
            
            // Set the base price for delivery (can be adjusted based on needs)
            let basePrice = 50;
            
            // Set province-specific prices
            const provincePrice = {
                "bangkok": 20,
                "amnat_charoen": 40,
                "ang_thong": 35,
                "bueng_kan": 50,
                "buri_ram": 60,
                "chachoengsao": 30,
                "chonburi": 25,
                "chumphon": 45,
                "kalasin": 50,
                "kamphaeng_phet": 55,
                "kanchanaburi": 40,
                "khon_kaen": 50,
                "krabi": 60,
                "lamphun": 45,
                "lampang": 40,
                "loei": 50,
                "mahasarakham": 55,
                "mueang_chonburi": 30,
                "nakhon_nayok": 35,
                "nakhon_pathom": 30,
                "nakhon_ratchasima": 50,
                "nan": 55,
                "narathiwat": 60,
                "nong_bua_lamphu": 50,
                "nong_khai": 45,
                "pathum_thani": 25,
                "pattani": 60,
                "phayao": 55,
                "phang_nga": 60,
                "phatthalung": 50,
                "phichit": 45,
                "phitsanulok": 50,
                "phrae": 50,
                "phetchaburi": 40,
                "phetchabun": 40,
                "ranong": 60,
                "ratchaburi": 35,
                "rayong": 30,
                "sakonnakhon": 55,
                "samut_sakhon": 30,
                "samut_prakan": 25,
                "saraburi": 35,
                "singburi": 40,
                "si_saket": 50,
                "songkhla": 60,
                "sukhothai": 45,
                "suphanburi": 40,
                "surat_thani": 60,
                "tak": 50,
                "udon_thani": 55,
                "utai_thani": 40,
                "yala": 60,
                "yasothon": 50
            };

            // Get the price based on the province selected
            let provinceSpecificPrice = provincePrice[province] || 0;

            // Calculate total price
            let price = basePrice + provinceSpecificPrice + (weight * 20);

            if (deliveryType === 'express') {
                price += 30;
            }
            if (productType === 'electronics') {
                price += 20;
            }

            // Set the calculated price in the price input field
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
            <div class="track-form">
                <input type="text" name="firstname" placeholder="Firstname" required>
                <input type="text" name="lastname" placeholder="Lastname" required><br>

                <input type="tel" name="tel" placeholder="Tel" required><br>
                <input type="text" name="address" placeholder="Address" required><br>

                <label for="province">Province:</label>
                <select name="province" id="province" required onchange="calculatePrice()">
                    <option value="bangkok">Bangkok</option>
                    <option value="amnat_charoen">Amnat Charoen</option>
                    <option value="ang_thong">Ang Thong</option>
                    <option value="bueng_kan">Bueng Kan</option>
                    <option value="buri_ram">Buri Ram</option>
                    <option value="chachoengsao">Chachoengsao</option>
                    <option value="chonburi">Chonburi</option>
                    <option value="chumphon">Chumphon</option>
                    <option value="kalasin">Kalasin</option>
                    <option value="kamphaeng_phet">Kamphaeng Phet</option>
                    <option value="kanchanaburi">Kanchanaburi</option>
                    <option value="khon_kaen">Khon Kaen</option>
                    <option value="krabi">Krabi</option>
                    <option value="lamphun">Lamphun</option>
                    <option value="lampang">Lampang</option>
                    <option value="loei">Loei</option>
                    <option value="mahasarakham">Mahasarakham</option>
                    <option value="mueang_chonburi">Muang Chonburi</option>
                    <option value="nakhon_nayok">Nakhon Nayok</option>
                    <option value="nakhon_pathom">Nakhon Pathom</option>
                    <option value="nakhon_ratchasima">Nakhon Ratchasima</option>
                    <option value="nan">Nan</option>
                    <option value="narathiwat">Narathiwat</option>
                    <option value="nong_bua_lamphu">Nong Bua Lamphu</option>
                    <option value="nong_khai">Nong Khai</option>
                    <option value="pathum_thani">Pathum Thani</option>
                    <option value="pattani">Pattani</option>
                    <option value="phayao">Phayao</option>
                    <option value="phang_nga">Phang Nga</option>
                    <option value="phatthalung">Phatthalung</option>
                    <option value="phichit">Phichit</option>
                    <option value="phitsanulok">Phitsanulok</option>
                    <option value="phrae">Phrae</option>
                    <option value="phetchaburi">Phetchaburi</option>
                    <option value="phetchabun">Phetchabun</option>
                    <option value="ranong">Ranong</option>
                    <option value="ratchaburi">Ratchaburi</option>
                    <option value="rayong">Rayong</option>
                    <option value="sakonnakhon">Sakon Nakhon</option>
                    <option value="samut_sakhon">Samut Sakhon</option>
                    <option value="samut_prakan">Samut Prakan</option>
                    <option value="saraburi">Saraburi</option>
                    <option value="singburi">Singburi</option>
                    <option value="si_saket">Si Saket</option>
                    <option value="songkhla">Songkhla</option>
                    <option value="sukhothai">Sukhothai</option>
                    <option value="suphanburi">Suphanburi</option>
                    <option value="surat_thani">Surat Thani</option>
                    <option value="tak">Tak</option>
                    <option value="udon_thani">Udon Thani</option>
                    <option value="utai_thani">Uthai Thani</option>
                    <option value="yala">Yala</option>
                    <option value="yasothon">Yasothon</option>
                </select><br>

                <label for="delivery_type">Delivery Type:</label>
                <select name="delivery_type" id="delivery_type" required onchange="calculatePrice()">
                    <option value="standard">Standard</option>
                    <option value="express">Express</option>
                </select><br>

                <label for="weight">Product Weight (kg):</label>
                <input type="number" name="weight" id="weight" placeholder="Enter weight in kg" step="0.1" min="0" required oninput="calculatePrice()"><br>

                <label for="product_type">Product Type:</label>
                <select name="product_type" id="product_type" required onchange="calculatePrice()">
                    <option value="general_use">General Use</option>
                    <option value="electronics">Electronics</option>
                </select><br>

                <label for="price">Total Price (฿):</label>
                <input type="text" name="price" id="price" readonly><br>

                <button type="submit" class="track-btn">Next</button>
                <button type="button" class="track-btn cancel-btn" onclick="window.location.href='homepage.php';">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
