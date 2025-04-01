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
    let province = document.getElementById('province').value;

    let basePrice = 50;

    // ข้อมูลระยะทางจากศรีราชาไปยังจังหวัดต่างๆ (โดยประมาณ)
    const distanceToSriracha = {
        "bangkok": 120,
        "amnat_charoen": 650,
        "ang_thong": 150,
        "bueng_kan": 700,
        "buri_ram": 350,
        "chachoengsao": 80,
        "chonburi": 30, //ระยะทางศรีราชาถึงตัวเมืองชลบุรี
        "chumphon": 500,
        "kalasin": 500,
        "kamphaeng_phet": 350,
        "kanchanaburi": 250,
        "khon_kaen": 450,
        "krabi": 800,
        "lamphun": 750,
        "lampang": 700,
        "loei": 550,
        "mahasarakham": 500,
        "mueang_chonburi": 30, //ระยะทางศรีราชาถึงตัวเมืองชลบุรี
        "nakhon_nayok": 120,
        "nakhon_pathom": 180,
        "nakhon_ratchasima": 250,
        "nan": 800,
        "narathiwat": 1100,
        "nong_bua_lamphu": 600,
        "nong_khai": 650,
        "pathum_thani": 140,
        "pattani": 1000,
        "phayao": 800,
        "phang_nga": 850,
        "phatthalung": 900,
        "phichit": 400,
        "phitsanulok": 450,
        "phrae": 700,
        "phetchaburi": 300,
        "phetchabun": 400,
        "ranong": 600,
        "ratchaburi": 250,
        "rayong": 50,
        "sakonnakhon": 550,
        "samut_sakhon": 160,
        "samut_prakan": 130,
        "saraburi": 180,
        "singburi": 200,
        "si_saket": 550,
        "songkhla": 950,
        "sukhothai": 450,
        "suphanburi": 200,
        "surat_thani": 700,
        "tak": 500,
        "udon_thani": 600,
        "utai_thani": 250,
        "yala": 1050,
        "yasothon": 550
    };

    // อัตราค่าขนส่งต่อกิโลเมตร (ตัวอย่าง)
    const ratePerKilometer = 2; //ปรับอัตราตามความเหมาะสม

    // คำนวณราคาระยะทาง
    let distance = distanceToSriracha[province] || 0;
    let distancePrice = distance * ratePerKilometer;

    // Calculate total price
    let price = basePrice + distancePrice + (weight * 20);

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
