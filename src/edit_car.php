<?php
require_once 'db_connection.php';

// Start session to get the dealer_id
session_start();

// Ensure the dealer is logged in
if (!isset($_SESSION['dealer_id'])) {
    header("Location: login.php"); 
    exit;
}

$dealer_id = $_SESSION['dealer_id']; // Retrieve the dealer_id 

// Get car details by car_id
if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Get car data
    $query = "SELECT * FROM cars WHERE id = :car_id AND dealer_id = :dealer_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['car_id' => $car_id, 'dealer_id' => $dealer_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        // Car not found or not owned by the dealer
        header("Location: dealerDash.php");
        exit;
    }
}

//submission for editing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    // Handle editing the car
    if ($action == "edit") {
        // Get form data 
        $make = isset($_POST['make']) ? htmlspecialchars($_POST['make']) : '';
        $model = isset($_POST['model']) ? htmlspecialchars($_POST['model']) : '';
        $year = isset($_POST['year']) ? htmlspecialchars($_POST['year']) : '';
        $price = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '';
        $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
        $fuel = isset($_POST['fuel']) ? htmlspecialchars($_POST['fuel']) : '';
        $image = $car['mainimage'];  // Keep the current image if not uploading a new one

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageFileName = $_FILES['image']['name'];
            $imageFileTmp = $_FILES['image']['tmp_name'];
            $imageFileSize = $_FILES['image']['size'];
            $imageFileType = $_FILES['image']['type'];

            // Move the image file to images folder
            $imagePath = 'images/' . basename($imageFileName);
            if (move_uploaded_file($imageFileTmp, $imagePath)) {
                $image = $imagePath; // Update image 
            } else {
                $errors[] = "Failed to upload image.";
            }
        }

        if (empty($errors)) {
            try {
                // Update car data 
                $query = "UPDATE cars SET make = :make, model = :model, year = :year, price = :price, fuel = :fuel, description = :description, mainimage = :mainimage WHERE id = :car_id AND dealer_id = :dealer_id";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'make' => $make,
                    'model' => $model,
                    'year' => $year,
                    'price' => $price,
                    'fuel' => $fuel,
                    'description' => $description,
                    'mainimage' => $image,
                    'car_id' => $car_id,
                    'dealer_id' => $dealer_id
                ]);
                
                header("Location: dealerDash.php#myads");
            } catch (PDOException $e) {
                $errors[] = "Error updating car details: " . $e->getMessage();
            }
        }
    }

    elseif ($action == "delete") {
        try {
            // Delete the car 
            $query = "DELETE FROM cars WHERE id = :car_id AND dealer_id = :dealer_id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['car_id' => $car_id, 'dealer_id' => $dealer_id]);

            // Redirect to the dashboard
            header("Location: dealerDash.php#myads");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Error deleting car: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
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

    <!-- Edit Car Form -->
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Edit Car Details</h1>

        <!-- Edit Car Form -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Car</h2>
            <form method="POST" action="edit_car.php?car_id=<?php echo $car['id']; ?>" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">

                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="make" class="block text-gray-700">Make</label>
                        <input type="text" id="make" name="make" class="w-full p-3 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($car['make']); ?>" placeholder="Enter Car Make">
                    </div>
                    <div class="flex-1">
                        <label for="model" class="block text-gray-700">Model</label>
                        <input type="text" id="model" name="model" class="w-full p-3 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($car['model']); ?>" placeholder="Enter Car Model">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="year" class="block text-gray-700">Year</label>
                        <input type="number" id="year" name="year" class="w-full p-3 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($car['year']); ?>" placeholder="Enter Year">
                    </div>
                    <div class="flex-1">
                        <label for="fuel" class="block text-gray-700">Fuel Type</label>
                        <input type="text" id="fuel" name="fuel" class="w-full p-3 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($car['fuel']); ?>" placeholder="Enter Fuel Type">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="price" class="block text-gray-700">Price</label>
                        <input type="number" id="price" name="price" class="w-full p-3 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($car['price']); ?>" placeholder="Enter Price">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="description" class="block text-gray-700">Description</label>
                    <textarea id="description" name="description" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Car Description"><?php echo htmlspecialchars($car['description']); ?></textarea>
                </div>

                <div class="mt-4">
                    <label for="image" class="block text-gray-700">Upload New Image (Optional)</label>
                    <input type="file" id="image" name="image" class="w-full p-3 border border-gray-300 rounded-md">
                </div>

                <div class="mt-4 flex space-x-4">
                    <!-- Update Button -->
    <button 
                    type="submit" 
                    name="action" 
                    value="edit" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                    onclick="return confirm('Are you sure you want to update this car?');">
                    Update Car
    </button>

                <button 
                    type="submit" 
                    name="action" 
                    value="delete" 
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                    onclick="return confirm('Are you sure you want to delete this car?');">
                    Delete Car
                </button>
            </div>
            </form>

            

            <!-- Back  -->
                      
            <div class="mt-4">
                <a href="dealerDash.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Back</a>
            </div>


        </div>
    </div>

</body>
</html>
