<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config.php';

    // Validate and sanitize input
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']); // Convert to integer to prevent SQL injection

        // Execute the DELETE query
        $query = "DELETE FROM list_fasum WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            // Redirect back to the data page with success message
            header("Location: /data");
            exit;
        } else {
            echo "Error: Could not execute the delete operation.";
        }
    } else {
        echo "Invalid ID provided.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If not a POST request, deny access
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
