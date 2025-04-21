<?php
require_once 'db_connection.php'; 



// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and validate form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                // Insert data into table
                $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':message', $message);
                
                if ($stmt->execute()) {
                    $success = "Thank you for contacting us! We will get back to you soon.";
                } else {
                    $error = "Failed to save your message. Please try again.";
                }
            } catch (PDOException $e) {
                $error = "Error saving your message: " . $e->getMessage();
            }
        } else {
            $error = "Please provide a valid email address.";
        }
    } else {
        $error = "Please fill all fields with valid data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Luxury Car Hub</title>
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

    <!-- Content -->
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Contact Us</h1>
        <?php if (isset($success)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="contactUs.php" method="POST" class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input type="text" id="name" name="name" class="border-gray-300 rounded-lg px-4 py-2 w-full" placeholder="Your Name" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" class="border-gray-300 rounded-lg px-4 py-2 w-full" placeholder="Your Email" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-gray-700 font-bold mb-2">Message</label>
                <textarea id="message" name="message" rows="4" class="border-gray-300 rounded-lg px-4 py-2 w-full" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Submit
            </button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6">
        <p>&copy; 2025 LuxuryCarHub. All Rights Reserved.</p>
        <p class="text-sm">LuxuryCarHub.com | Contact: support@luxurycarhub.com</p>
    </footer>

</body>
</html>
