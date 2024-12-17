<?php
// Include the database configuration
include 'config.php';

// Fetch records for the current page
$query = "SELECT * FROM list_fasum";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FASUM BATAM</title>
    <link href="https://unpkg.com/maplibre-gl@^4.7.1/dist/maplibre-gl.css" rel="stylesheet" />
    <script src="https://unpkg.com/maplibre-gl@^4.7.1/dist/maplibre-gl.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <script src="https://kit.fontawesome.com/d2818b3a11.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../../public/favicon.ico">
    <style>
        body {
            font-family: "Source Sans Pro";
        }
    </style>
</head>

<body>
    <div class="fixed left-0 bg-white h-screen z-10 w-80 bg-white flex flex-col">
        <a href="" class="block h-14 px-2 py-3 border-b border-gray-500 flex-none hover:text-gray-500">
            <span class="text-xl font-thin px-3">FASUM</span>
        </a>

        <div class="flex-1 overflow-y-auto">
            <?php
            if ($result->num_rows > 0) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    // Extract values from the row
                    $name = htmlspecialchars($row['lapangan']); // Replace 'name' with the actual column name
                    $location = htmlspecialchars($row['lokasi']); // Replace 'location' with the actual column name
                    $image = htmlspecialchars($row['foto']); // Replace 'image' with the actual column name
                    $latitude = htmlspecialchars($row['latitude']);
                    $longitude = htmlspecialchars($row['longitude']);

                    // Output the HTML structure
                    echo "<div class=\"px-4 border-b border-b-gray-300 pt-2 pb-4 flex cursor-pointer hover:bg-gray-200\" data-latitude=\"$latitude\" data-longitude=\"$longitude\">";
                    echo "    <div class=\"flex-1\">";
                    echo "        <p class=\"text-xl font-bold\">$name</p>";
                    echo "        <p class=\"text-gray-500\">$location</p>";
                    echo "    </div>";
                    echo "    <div class=\"flex-none w-24 h-24\">";
                    echo "        <img class=\"h-full w-full object-center object-cover rounded-md\" src=\"../../uploads/images/$image\" alt=\"$name\">";
                    echo "    </div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No records found.</p>";
            }

            ?>
        </div>
    </div>


    <div class="h-screen ml-80 relative">
        <div id="map" class="h-full w-full"></div>
        <div class="absolute top-0 left-0 w-72 bg-white z-10 p-4 m-4 rounded-md">
            <div class="flex flex-col gap-4 mb-2">
                <div class="flex flex-col gap-1">
                    <label for="start" class="font-bold m-0">Mulai</label>
                    <input type="text" class="p-2 rounded-sm bg-gray-200" name="start" id="start" placeholder="Klik lokasi di peta!" disabled>

                </div>
                <div class="flex flex-col gap-1">
                    <label for="end" class="font-bold m-0">Tujuan</label>
                    <input type="text" placeholder="Pilih Fasum dari daftar!" class="p-2 rounded-sm bg-gray-200" name="end" id="end" disabled>
                </div>
            </div>
            <button id="findRouteButton" class="bg-blue-500 hover:bg-blue-600 text-white w-full rounded-md py-2 flex gap-2 justify-center items-center">
                <p>Cari Rute</p>
                <i class="fa-solid fa-diamond-turn-right"></i>
            </button>
        </div>
    </div>

    <script src="../../utils/maplibre.js"></script>
</body>

</html>