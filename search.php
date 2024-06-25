<?php
session_start();
require_once("database.php");

if (isset($_POST['search'])) {
    $searchTerm = $_POST['username'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE nama_user LIKE :searchTerm");
    $stmt->execute(['searchTerm' => "%$searchTerm%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="justify-center items-center h-screen bg-blue-500">
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-8">
                            <a href="home.php" class="rounded-md px-3 py-2 text-sm font-medium text-white">Home</a>
                            <a href="newPost.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">New Post</a>
                            <a href="news.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">News</a>
                            <a href="search.php" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Search</a>
                            <a href="logout.php" class="bg-red-600 text-white rounded-md px-3 py-2 text-sm font-medium hover:bg-white hover:text-gray-700">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-white p-8 rounded-lg shadow-md w-96 mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4 text-black">Search Users</h2>
        <form method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <button type="submit" name="search" class="w-full bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Search</button>
        </form>

        <?php if (isset($results)) : ?>
            <div class="mt-4">
                <h3 class="text-xl font-bold text-black">Search Results:</h3>
                <?php if (count($results) > 0) : ?>
                    <ul>
                        <?php foreach ($results as $user) : ?>
                            <li class="mt-2 p-2 border-b border-gray-200 text-black">
                                <?= htmlspecialchars($user['nama_user']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-black">No users found.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>