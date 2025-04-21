<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maps - Luxury Car Hub</title>  
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

 <!-- Navbar -->
 <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                <a href="index.php" class="text-white text-2xl font-bold flex items-center">
                <img src="images/Logo.jpg" alt="LuxuryCarHub Logo" class="mr-8 h-10 rounded">
            </a>
                <a href="index.php" class="text-white text-2xl font-bold">LuxuryCarHub</a>
                <div class="ml-10 flex space-x-4 hidden md:flex">
                    <a href="index1.php" class="text-gray-300 hover:text-white">Vehicles</a>
                    <a href="index.php#dealers" class="text-gray-300 hover:text-white">Dealers</a>
                    <a href="map.php" class="text-gray-300 hover:text-white">Maps</a>
                    <a href="aboutUs.php" class="text-gray-300 hover:text-white">About us</a>
                    <a href="contactUs.php" class="text-gray-300 hover:text-white">Contact Us</a>
            
                    </div>
                </div>
                <a href="login.php" class="text-gray-300 hover:text-white">Login</a>
            </div>
        </div>
    </nav>
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Our Locations</h1>
    
    <!-- Google Map iframe -->
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3234.046412034546!2d-122.0842494846972!3d37.421999179825105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb6f78c78c8bf%3A0x951d08f3492d41e5!2sGoogleplex!5e0!3m2!1sen!2sus!4v1602185142377!5m2!1sen!2sus"
        width="100%"
        height="600px"
        style="border:0;"
        allowfullscreen=""
        loading="lazy">
    </iframe>
</body>
</html>
