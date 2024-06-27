<?php
session_start();
require_once("./database.php");
require_once("add.php");

$stmt = $conn->prepare("SELECT * FROM posts ORDER BY id_post DESC 1");
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);
$recent = $post['url_media'];
$description = $post['description'];
$location = $post['location'];  

if (isset( $_POST["logout"])){
    session_destroy();
    header("Location: index.php");
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="justify-center items-center min-h-screen bg-gray-1000">
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-8">
                            <a href="home.php" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Home</a>
                            <a href="newPost.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">New Post</a>
                            <a href="news.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">News</a>
                            <a href="search.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Search</a>
                            <a href="logout.php" class="bg-red-600 text-white rounded-md px-3 py-2 text-sm font-medium hover:bg-white hover:text-gray-700">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-gray-1000 p-8 rounded-lg shadow-md max-w-4xl mx-auto text-center">
        <h1 class="text-2xl font-bold w-full h-10 rounded-lg shadow-md justify-center items-center mb-5">Home</h1>
        <div class="mx-auto">
            <div class="bg-white p-3 w-3/5 rounded-lg shadow-md mx-auto">
                <h2 class="text-2xl font-bold mb-4 text-black">Recent Post</h2>
                <img src="<?= $recent ?>" alt="" class="w-3/5 mx-auto rounded">
                <p class="text-black"><?= $description ?></p>
                <p class="text-black">Location : <?= $location ?></p>
            </div>
        </div>
    </div>
</body>

</html>