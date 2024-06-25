<?php
session_start();
require_once("add.php");
require_once("./database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
    input:checked~.dot {
        transform: translateX(100%);
        background-color: #48bb78;
    }
</style>

<body>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <a href="home.php" class="rounded-md px-3 py-2 text-sm font-medium text-white" aria-current="page">Home</a>
                            <a href="newPost.php" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">New Post</a>
                            <a href="news.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">News</a>
                            <a href="search.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Search</a>
                            <a href="logout.php" class="bg-red-600 text-white rounded-md px-3 py-2 text-sm font-medium hover:bg-white hover:text-gray-700">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <table width="70%" border="0">
            <tr>
                <td colspan="3">
                    <h1>New Post</h1>
                </td>
            </tr>
            <tr>
                <td>Upload gambar </td>
                <td>:</td>
                <td><label>
                        <input type="file" name="file" />
                    </label></td>
            </tr>
            <tr>
                <td>Location</td>
                <td>:</td>
                <td id="googleMap" style="width:50%;height:300px;"></td>

                <script>
                    function myMap() {
                        var mapProp = {
                            center: new google.maps.LatLng(-7.361806611579532, 112.89477191915905),
                            zoom: 13,
                            mapTypeId: google.maps.MapTypeId.TERRAIN,
                        };
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(-7.252355724374438, 112.7906520461803)
                        });
                        var marker2 = new google.maps.Marker({
                            position: new google.maps.LatLng(-7.266404268656808, 112.79760433147855),
                            animation: google.maps.Animation.DROP,
                            icon: "marker.png",
                        });

                        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

                        var infoWindow = new google.maps.InfoWindow({
                            map: map
                        });
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var pos = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };

                                infoWindow.setPosition(pos);
                                infoWindow.setContent('Lokasi saya disiniii!');
                                map.setCenter(pos);
                                icon: "marker.png";

                                fetch('save_location.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify(pos)
                                    })
                                    .then(response => response.json())
                                    .then(data => console.log('Success:', data))
                                    .catch(error => console.error('Error:', error));

                            }, function() {
                                handleLocationError(true, infoWindow, map.getCenter());
                            });
                        } else {
                            handleLocationError(false, infoWindow, map.getCenter());
                        }

                        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                            infoWindow.setPosition(pos);
                            infoWindow.setContent(browserHasGeolocation ?
                                'Error: The Geolocation service failed.' :
                                'Error: Your browser doesn\'t support geolocation.');
                        }
                        marker.setMap(map);
                        marker2.setMap(map);
                    }
                </script>

                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSF8UV4KQr_6dq14G2zXBAjL2ErBUUqWQ&callback=myMap"></script>

                <!-- <td class="flex items-center">
                    <label for="toggle" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input id="toggle" type="checkbox" class="sr-only" name="location_toggle" />
                            <div class="block bg-gray-600 w-10 h-6 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                        </div>
                    </label>
                    <div class="ml-1 text-xs text-gray-600">Toggle me</div>
                </td> -->
            </tr>
            <tr>
                <td>Filter</td>
                <td>:</td>
                <td><label>
                        <select name="filter">
                            <option value="1">grayscale</option>
                            <option value="2">ruby</option>
                            <option value="3">almethyst</option>
                            <option value="4">Topaz</option>
                        </select>
                    </label></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><label>
                        <textarea name="keterangan" rows="5"></textarea>
                    </label></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><label>
                        <input type="submit" name="Submit" value="New post" />
                    </label></td>
            </tr>
        </table>
        <p>&nbsp;</p>
    </form>

    <?php
    if (isset($_POST["Submit"])) {
        $id_user = $_SESSION['id_user'];
        $filter = $_POST["filter"];
        $keterangan = $_POST["keterangan"];
        $location = isset($_SESSION['location']) ? $_SESSION['location'] : null;
        $location_name = $location ? $location['lat'] . ',' . $location['lng'] : 'Unknown Location';
        $date = new DateTime();
        $result = $date->format('YmdHis');
        $path = "gambar/$result.jpg";

        $image = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);

        if ($filter == "1") {
            imagefilter($image, IMG_FILTER_GRAYSCALE);
        } else if ($filter == "2") {
            imagefilter($image, IMG_FILTER_COLORIZE, 50, 50, 100);
        } else if ($filter == "3") {
            imagefilter($image, IMG_FILTER_COLORIZE, 50, 100, 50);
        } else {
            imagefilter($image, IMG_FILTER_COLORIZE, 100, 50, 50);
        }

        imagejpeg($image, $path);
        imagedestroy($image);

        try {
            $sql = "INSERT INTO posts (id_user, url_media, description, location) VALUES (:id_user, :url_media, :description, :location)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->bindParam(':url_media', $path, PDO::PARAM_STR);
            $stmt->bindParam(':description', $keterangan, PDO::PARAM_STR);
            $stmt->bindParam(':location', $location_name, PDO::PARAM_STR);
            $stmt->execute();
            echo "New post saved successfully.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
</body>

</html>