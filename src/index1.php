<?php
require_once 'db_connection.php'; 

// Fetch 
$query = "SELECT * FROM cars";
$stmt = $pdo->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// search 
$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
if (!empty($searchTerm)) {
    $query = "SELECT * FROM cars 
              WHERE make LIKE :search OR model LIKE :search OR year LIKE :search";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['search' => "%$searchTerm%"]);
} else {
    $query = "SELECT * FROM cars";
    $stmt = $pdo->query($query);
}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Car Hub</title>
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
                    <a href="index.php#dealers" class="text-gray-300 hover:text-white">Dealers</a>
                    <a href="map.php" class="text-gray-300 hover:text-white">Maps</a>
                    <a href="aboutUs.php" class="text-gray-300 hover:text-white">About us</a>
                    <a href="contactUs.php" class="text-gray-300 hover:text-white">Contact Us</a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="login.php" class="text-gray-300 hover:text-white hidden md:block">Login</a>
                <!-- Hamburger Icon -->
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
                <li><a href="index.php#dealers" class="block text-gray-300 hover:text-white">Dealers</a></li>
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


<!-- Intro -->
<header class="bg-cover bg-center py-12 text-center" style="background-image: url('images/background.jpg');">
    <h1 class="text-4xl font-bold text-gray-800 bg-white bg-opacity-75 inline-block px-4 py-1 rounded">LuxuryCarHub</h1> <br> <br>
    <p class="text-gray-600 bg-white bg-opacity-75 inline-block px-3 py-1 rounded">Welcome! Explore a variety of cars and find the one that suits you best.</p> 
</header>


    <!-- Search -->
    <div class="bg-white py-4 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="index1.php" class="flex space-x-4">
            <input 
                type="text" 
                name="search" 
                value="<?php echo $searchTerm; ?>" 
                placeholder="Search by make, model, or year..." 
                class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-lg">Search</button>
            <a href="index1.php" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Clear</a>
        </form> 
    </div>
</div>

<!-- Cars -->
<div class="container mx-auto px-4 py-2">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Cars</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($products as $product): ?>
            <a href="car_details.php?id=<?php echo urlencode($product['id']); ?>" class="block">
                <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white">
                    <img class="w-full h-48 object-cover" src="<?php echo htmlspecialchars($product['mainimage']); ?>" alt="<?php echo htmlspecialchars($product['make'] . ' ' . $product['model']); ?>">
                    <div class="px-5 py-1">
                        <div class="font-bold text-xl mb-2">
                            <?php echo htmlspecialchars($product['make'] . ' ' . $product['model']); ?>
                        </div>
                        <p class="text-gray-700 text-base">
                            <strong>Year:</strong> <?php echo htmlspecialchars($product['year']); ?><br>
                            <strong>Fuel:</strong> <?php echo htmlspecialchars($product['fuel']); ?>
                        </p>
                        <p class="text-green-500 font-bold mt-4">Rs.<?php echo number_format($product['price'], 2); ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>



    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6">
        <p>&copy; 2025 LuxuryCarHub. All Rights Reserved.</p>
        <p class="text-sm">LuxuryCarHub.com | Contact: support@luxurycarhub.com</p>
    </footer>
    

</body>
</html>


