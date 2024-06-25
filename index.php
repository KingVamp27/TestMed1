<?php
session_start();
require_once("./database.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama_user = $_POST["nama_user"];
  $password = $_POST["password"];

  if (empty($nama_user)) {
    $error = "Username is required.";
  }
  if (empty($password)) {
    $error = "Password is required.";
  }
  if (empty($error)) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE nama_user = ?");
    $stmt->execute([$nama_user]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] == $password) {
      $_SESSION['id_user'] = $user['id_user'];
      header("Location: home.php");
    } else {
      $error = "Invalid username or password.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TestMed1</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex justify-center items-center h-screen bg-blue-500">

  <div class="bg-white p-8 rounded-lg shadow-md w-96">
    <h2 class="text-2xl font-bold mb-4 text-black">Login</h2>
    <form action="" method="post">
      <div class="mb-4">
        <label for="username" class="block text-gray-700">Username</label>
        <input type="text" id="username" name="nama_user" placeholder="Enter your username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-700">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>
      <button type="submit" class="w-full bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Login</button>
      <a href="register.php" class="text-blue-500">Don't have an account? Register here</a>

      <?php
      if (!empty($error)) {
        echo $error . "<br>";
      }
      ?>

    </form>
  </div>
</body>

</html>