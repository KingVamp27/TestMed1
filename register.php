<?php
require_once("./database.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_user = $_POST["nama_user"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm"];

    if (empty($nama_user)) {
        $error = "Username is required.";
    }

    if (empty($password)) {
        $error = "Password is required.";
    }

    if (empty($confirm_password)) {
        $error = "Confirm password is required.";
    }

    if ($password != $confirm_password) {
        $error = "Passwords do not match.";
    }

    $success = "";

    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO users (nama_user, password) VALUES (?, ?)");
        $stmt->execute([$nama_user, $password]);
        $success = "User registered successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex justify-center items-center h-screen bg-blue-500">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4 text-black">Register</h2>
        <form action="" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">New Username</label>
                <input type="text" id="username" name="nama_user" placeholder="Enter your username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">New Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Confirm New Password</label>
                <input type="password" id="confirm" name="confirm" placeholder="Confirm your password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Register</button>
            <a href="index.php" class="text-blue-500">Already have an account? Login here</a>

            <?php
            if (!empty($error)) {
                echo $error . "<br>";
            }
            if (!empty($success)) {
                echo $success . "<br>";
            }
            ?>

        </form>
    </div>
</body>

</html>