<?php
session_start();
require_once("./database.php");
require_once("add.php");
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="justify-center items-center min-h-screen bg-gray-1000">
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-8">
                            <a href="home.php" class="rounded-md px-3 py-2 text-sm font-medium text-white">Home</a>
                            <a href="newPost.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">New Post</a>
                            <a href="news.php" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">News</a>
                            <a href="search.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Search</a>
                            <a href="logout.php" class="bg-red-600 text-white rounded-md px-3 py-2 text-sm font-medium hover:bg-white hover:text-gray-700">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-gray-1000 p-8 rounded-lg shadow-md max-w-4xl mx-auto text-center">
        <h1 class="text-2xl font-bold w-full h-10 rounded-lg shadow-md justify-center items-center mb-5">News</h1>
        <div class="mx-auto">
            <div class="bg-white p-3 w-full rounded-lg shadow-md mx-auto">
                <h2 class="text-2xl font-bold mb-4 text-black">Recent News</h2>
                <?php
                $rss = new DOMDocument();
                $rss->load('https://sindikasi.okezone.com/index.php/rss/2/RSS2.0');
                $feed = array();
                foreach ($rss->getElementsByTagName('item') as $node) {
                    $item = array(
                        'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                        'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                        'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                        // 'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                    );

                    array_push($feed, $item);
                }

                function get_image_from_link($url)
                {
                    $html = file_get_contents($url);
                    $doc = new DOMDocument();
                    @$doc->loadHTML($html);
                    $xpath = new DOMXPath($doc);
                    $img = $xpath->query("//img[@id='imgCheck']")->item(0);
                    return $img ? $img->getAttribute('src') : null;
                }

                $limit = 10;
                for ($x = 0; $x < $limit; $x++) {
                    $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                    $link = $feed[$x]['link'];
                    $description = $feed[$x]['desc'];
                    // $date = date('l F d, Y', strtotime($feed[$x]['date']));
                    $date = date('l F d, Y');
                    $imgSrc = get_image_from_link($link);

                    echo '<p class="text-black"><strong><a href="' . $link . '" title="' . $title . '">' . $title . '</a></strong><br />';
                    echo '<small><em>Posted on ' . $date . '</em></small></p>';
                    echo $imgSrc ? '<img src="' . $imgSrc . '" alt="' . $title . '" /><br />' : '';
                    echo '<p>' . $description . '</p>';
                    echo '</br></br><br>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>