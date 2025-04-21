<?php
require_once 'db_connection.php';

// Initialize variables
$username = $password = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize input
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; 

    // Validate inputs
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // log the user or dealer in
    if (empty($errors)) {
        try {
            // Check users
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $user['password'] === $password) {
                // redirect to user dashboard
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                header("Location: userDash.php");
                exit();
            }

            // If user not found, check dealers
            $query = "SELECT * FROM dealers WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['username' => $username]);
            $dealer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dealer && $dealer['password'] === $password) {
                //redirect to dealer dashboard
                session_start();
                $_SESSION['dealer_id'] = $dealer['dealer_id'];
                header("Location: dealerDash.php"); 
                exit();
            } else {
                $errors[] = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $errors[] = "Error logging in: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-md mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">Login</h1>

        <!--Errors -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-200 text-red-800 p-4 rounded-md mb-6">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form method="POST" action="login.php">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Username" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Enter Password" required>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-gray-800 text-white py-3 rounded-md hover:bg-gray-700">Login</button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-700">Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register here</a></p>
            </div>
        </div>
    </div>

</body>
</html>
