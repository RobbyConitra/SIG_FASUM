<?php
// Start session safely to avoid "session already started" warning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mendapatkan URL path saat ini
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$publicPath = ["/login", "/"];
$privatePath = ["/dashboard", "/data", "/data/create", "/data/edit"];

//Create for iteration for the public paths
// Jika URL adalah /login, tampilkan halaman login tanpa sidebar
if ($path === '/login') {
    include './view/pages/login.php';
    exit();
}
// Jika URL adalah /maps, tampilkan halaman maps (halaman publik)
if ($path === '/') {
    include './view/pages/map.php';
    exit();
}

// Check if the path is not in $publicPath and $privatePath, redirect to 404
if (!in_array($path, $publicPath) && !in_array($path, $privatePath)) {
    include './view/pages/404.php'; // Redirect to 404 page
    exit();
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fasum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/d2818b3a11.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="/public/favicon.ico">
    <link rel="stylesheet" type="text/css" href="home.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <style>
        body {
            font-family: "Source Sans Pro";
        }
    </style>
</head>

<body>
    <div>
        <?php
        include './view/sidebar.php';

        ?>
        <main class="ml-[250px] vw-full">
            <?php
            // If the path is in $privatePath, include the corresponding page dynamically
            if (in_array($path, $privatePath)) {
                $page = "./view/pages" . $path . ".php";
                if (file_exists($page)) {
                    include $page;  // Include the corresponding page
                }
            }
            ?>
        </main>
    </div>
</body>

</html>