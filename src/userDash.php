<?php
require_once 'db_connection.php';

// Start session to get user ID 
session_start();

// Replace with actual logged-in user ID  
$userId = $_SESSION['user_id'] ?? null; 

if (!$userId) {
    header("Location: login.php"); 
    exit();
}

// Fetch user information
$query = "SELECT name, email, phone, username FROM users WHERE user_id = :id"; 
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC); 

if (!$user) {
    die("User not found or session invalid.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">User Dashboard</a>
            <div>
                <a href="logout.php" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
            <p class="text-gray-600 mt-2">Here’s an overview of your account.</p>
        </div>

        <!-- User Information -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        </div>
    </div>
</body>
</html>

