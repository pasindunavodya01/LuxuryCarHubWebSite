<?php
require_once 'db_connection.php';

// Fetch car details
$stmt = $pdo->prepare("
    SELECT cars.id, cars.make, cars.model, cars.mainimage, cars.price, dealers.name AS dealer_name, dealers.phone AS dealer_phone
    FROM cars
    JOIN dealers ON cars.dealer_id = dealers.dealer_id
    LIMIT 8 
");
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch dealer details
$dealerStmt = $pdo->prepare("SELECT name, phone FROM dealers LIMIT 10");
$dealerStmt->execute();
$dealers = $dealerStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxuryCarHub - Find Your Dream Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="../dist/output.css" rel="stylesheet">

</head>
<body class="bg-gray-100">

   <!-- Navbar -->
   <nav class="bg-custom-gray">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
            <a href="index.php" class="text-white text-2xl font-bold flex items-center">
                <img src="images/Logo.jpg" alt="LuxuryCarHub Logo" class="mr-8 h-10 rounded">
            </a>
                <a href="index.php" class="text-white text-2xl font-bold">LuxuryCarHub</a>
                <div class="ml-10 flex space-x-4 hidden md:flex">
                    <a href="index1.php" class="text-gray-300 hover:text-white">Vehicles</a>
                    <a href="#dealers" class="text-gray-300 hover:text-white">Dealers</a>
                    <a href="map.php" class="text-gray-300 hover:text-white">Maps</a>
                    <a href="aboutUs.php" class="text-gray-300 hover:text-white">About us</a>
                    <a href="contactUs.php" class="text-gray-300 hover:text-white">Contact Us</a>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <a href="login.php" class="text-gray-300 hover:text-white hidden md:block">Login</a>
                <!-- Hamburger Icon  -->
                <div class="md:hidden">
                    <button id="menu-toggle" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <ul class="space-y-4 text-white">
                <li><a href="index1.php" class="block text-gray-300 hover:text-white">Vehicles</a></li>
                <li><a href="#dealers" class="block text-gray-300 hover:text-white">Dealers</a></li>
                <li><a href="map.php" class="block text-gray-300 hover:text-white">Maps</a></li>
                <li><a href="aboutUs.php" class="block text-gray-300 hover:text-white">About us</a></li>
                <li><a href="contactUs.php" class="block text-gray-300 hover:text-white">Contact Us</a></li>
                <li><a href="login.php" class="block text-gray-300 hover:text-white">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<script>
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");

    menuToggle.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });
</script>

    <!--Banner -->
    <section class="relative bg-cover bg-center h-96 " style="background-image: url('images/BYD-Song-L-traseira.webp');">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-center">
            <h1 class="text-4xl font-semibold">Find your dream car today!</h1>
        </div>
    </section>

    <!-- Vehicles-->
    <section class="py-10 bg-gray-50">
        <div class="max-w-8xl mx-auto px-1 text-center">
            <h2 class="text-4xl font-bold mb-5">Vehicles</h2>
            <p class="text-lg text-gray-700 mb-6">At LuxuryCarHub, we feature a wide range of vehicles, from model sports cars to spacious SUVs, all carefully inspected to meet the highest standards.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($cars as $car): ?>
                    <div class="bg-white p-1 rounded-lg shadow-lg">
                        <img src="<?php echo htmlspecialchars($car['mainimage']); ?>" alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>" class="w-full h-64 object-cover rounded-md mb-4">
                        <h3 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h3>
                        <p class="text-lg text-gray-700"><strong>Price:</strong> Rs.<?php echo number_format($car['price'], 2); ?></p>
                        <a href="car_details.php?id=<?php echo $car['id']; ?>" class="text-blue-500 mt-4 inline-block">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="index1.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg mt-6 inline-block">Show More Vehicles</a>
        </div>
    </section>

   <!-- Dealers -->
    <section id="dealers" class="py-10 bg-white">
        <div class="max-w-8xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Our Dealers</h2>
            <p class="text-lg text-gray-700 mb-6">Our network of verified dealers is at the heart of LuxuryCarHub. We partner with reputable sellers who share our commitment to excellence, ensuring that every transaction is secure and transparent.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                <?php foreach ($dealers as $dealer): ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        
                        <h3 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($dealer['name']); ?></h3>
                        <p class="text-lg text-gray-700">Phone: <?php echo htmlspecialchars($dealer['phone']); ?></p>
                      
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6">
        <p>&copy; 2025 LuxuryCarHub. All Rights Reserved.</p>
        <p class="text-sm">LuxuryCarHub.com | Contact: support@luxurycarhub.com</p>
    </footer>

    

</body>
</html>
