<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Destroy the session to log out the user
    session_start();
    session_unset();
    session_destroy();

    // Redirect the user to the login page or home page
    header("Location: /login");
    exit();
}
?>