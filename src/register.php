<?php
require_once 'db_connection.php';

// Initialize variables
$name = $phone = $email = $username = $password = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

    // Validate inputs
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // insert user data
    if (empty($errors)) {
        try {
   

            $query = "INSERT INTO users (name, phone, email, username, password) 
                      VALUES (:name, :phone, :email, :username, :password)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'username' => $username,
                'password' => $password
            ]);
            header("Location: login.php");
        } catch (PDOException $e) {
            $errors[] = "Error registering user: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-md mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">User Registration</h1>

        <!-- Display Errors -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-200 text-red-800 p-4 rounded-md mb-6">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form method="POST" action="register.php">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Your Name" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700">Phone</label>
                    <input type="text" id="phone" name="phone" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Phone Number" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Email" required>
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Username" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Password" required>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-md hover:bg-gray-700">Register</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
