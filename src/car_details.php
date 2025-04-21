<?php
require_once 'db_connection.php';

// Get car ID 
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch car and dealer 
$stmt = $pdo->prepare("
    SELECT cars.*, dealers.name AS dealer_name, dealers.email AS dealer_email, dealers.phone AS dealer_phone
    FROM cars
    JOIN dealers ON cars.dealer_id = dealers.dealer_id
    WHERE cars.id = :id
");
$stmt->execute(['id' => $id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto px-4 py-10">
        <?php if ($car): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg">
    <!-- Image -->
    <div class="w-full mb-6">
        <img src="<?php echo htmlspecialchars($car['mainimage']); ?>" alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>" class="w-full h-96 object-cover rounded-md">
    </div>

    <!-- Car details and Dealer details -->
    <div class="flex">
        <div class="w-1/2 pr-6">
            <h1 class="text-4xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h1>
            <p class="text-gray-700 text-lg"><strong>Year:</strong> <?php echo htmlspecialchars($car['year']); ?></p>
            <p class="text-gray-700 text-lg"><strong>Fuel:</strong> <?php echo htmlspecialchars($car['fuel']); ?></p>
            <p class="text-gray-700 text-lg"><strong>Price:</strong> Rs.<?php echo number_format($car['price'], 2); ?></p>
            <p class="text-gray-700 mt-4"><?php echo htmlspecialchars($car['description']); ?></p>
        </div>

        <div class="w-1/2 pl-6 p-4 border-2 border-gray-300 rounded-lg bg-gray-50">
            <h3 class="text-2xl font-bold mb-4">Dealer Information</h3>
            <p class="text-gray-700"><strong>Name:</strong> <?php echo htmlspecialchars($car['dealer_name']); ?></p>
            <p class="text-gray-700"><strong>Email:</strong> <?php echo htmlspecialchars($car['dealer_email']); ?></p>
            <p class="text-gray-700"><strong>Phone:</strong> <?php echo htmlspecialchars($car['dealer_phone']); ?></p>
        </div>
    </div>

    <a href="index1.php" class="block text-blue-500 mt-6">Back to Cars</a>
</div>


        <?php else: ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-lg">
                <p>Car not found.</p>
                <a href="index.php" class="text-blue-500 underline">Back to Cars</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
