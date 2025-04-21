<?php
require_once 'db_connection.php';

// Initialize variables
$make = $model = $year = $price = $fuel = $image = "";
$errors = [];

//get the dealer_id
session_start();

// Ensure the dealer is logged in
if (!isset($_SESSION['dealer_id'])) {
    header("Location: login.php"); 
    exit;
}

$dealer_id = $_SESSION['dealer_id']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $make = isset($_POST['make']) ? htmlspecialchars($_POST['make']) : '';
    $model = isset($_POST['model']) ? htmlspecialchars($_POST['model']) : '';
    $year = isset($_POST['year']) ? htmlspecialchars($_POST['year']) : '';
    $price = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '';
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
    $fuel = isset($_POST['fuel']) ? htmlspecialchars($_POST['fuel']) : '';


    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageFileName = $_FILES['image']['name'];
        $imageFileTmp = $_FILES['image']['tmp_name'];
        $imageFileSize = $_FILES['image']['size'];
        $imageFileType = $_FILES['image']['type'];


        // upload images 
        if (empty($errors)) {
            $imagePath = 'images/' . basename($imageFileName);
            if (move_uploaded_file($imageFileTmp, $imagePath)) {
                $image = $imagePath; // Store the image path
            } else {
                $errors[] = "Failed to upload image.";
            }
        }
    } else {
        $errors[] = "Image is required.";
    }

    // insert car details 
    if (empty($errors)) {
        try {
            // Insert data into table
            $query = "INSERT INTO cars (make, model, year, price, fuel, description, mainimage, dealer_id) 
            VALUES (:make, :model, :year, :price, :fuel, :description, :mainimage, :dealer_id)";
  
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'make' => $make,
                'model' => $model,
                'year' => $year,
                'price' => $price,
                'fuel' => $fuel,
                'description' => $description,
                'mainimage' => $image,
                'dealer_id' => $dealer_id   
            ]);
            echo "Car details uploaded successfully!";
        } catch (PDOException $e) {
            $errors[] = "Error uploading car details: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealer Dashboard - Add Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

      <!-- Navbar -->
      <nav class="bg-gray-800 text-white p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Dealer Dashboard</a>
            <div>
                <a href="logout.php" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard -->
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Dealer Dashboard</h1>

        <!--Form -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Add New Car</h2>
            <form method="POST" action="dealerDash.php" enctype="multipart/form-data">
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="make" class="block text-gray-700">Make</label>
                        <input type="text" id="make" name="make" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Car Make">
                    </div>
                    <div class="flex-1">
                        <label for="model" class="block text-gray-700">Model</label>
                        <input type="text" id="model" name="model" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Car Model">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="year" class="block text-gray-700">Year</label>
                        <input type="number" id="year" name="year" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Year">
                    </div>
                    <div class="flex-1">
                        <label for="fuel" class="block text-gray-700">Fuel Type</label>
                        <input type="text" id="fuel" name="fuel" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Fuel Type">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="price" class="block text-gray-700">Price</label>
                        <input type="number" id="price" name="price" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Price">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="price" class="block text-gray-700">Description</label>
                        <input type="text" id="description" name="description" class="w-full p-6 border border-gray-300 rounded-md" placeholder="Enter Description">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="image" class="block text-gray-700">Car Image</label>
                    <input type="file" id="image" name="image" class="w-full p-3 border border-gray-300 rounded-md">
                </div>


                <!--Error message -->
                <?php if (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline"><?php echo implode('<br>', $errors); ?></span>
                </div>
                <?php endif; ?>


                <div class="mt-6">
                    <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-md hover:bg-gray-700">Submit</button>
                </div>
            </form>
        </div>

        <!-- My Ads -->
        <div>
            <h2 id= myads class="text-2xl font-bold text-gray-800 mb-4">My Ads</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php
    // Fetch cars by dealer
    $query = "SELECT * FROM cars WHERE dealer_id = :dealer_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['dealer_id' => $dealer_id]);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($cars as $car):
    ?>
        <a href="edit_car.php?car_id=<?php echo $car['id']; ?>" class="bg-white p-4 rounded-lg shadow-lg hover:bg-gray-100">
            <img src="<?php echo htmlspecialchars($car['mainimage']); ?>" alt="Car Image" class="w-full h-48 object-cover mb-4 rounded-md">
            <h3 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h3>
            <p class="text-gray-600"><?php echo htmlspecialchars($car['description']); ?></p>
        </a>
    <?php endforeach; ?>
</div>

        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6">
        <p>&copy; 2025 LuxuryCarHub. All Rights Reserved.</p>
        <p class="text-sm">LuxuryCarHub.com | Contact: support@luxurycarhub.com</p>
    </footer>
</body>
</html>
