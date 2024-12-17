<?php
// Start session safely to avoid "session already started" warning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config.php';

    $id = intval($_POST['id']);
    $jenis_lapangan = $_POST['jenis_lapangan'];
    $lokasi = $_POST['lokasi'];
    $koordinat = $_POST['koordinat'];

    // Split the string into an array using ',' as a delimiter
    list($latitude, $longitude) = explode(',', $koordinat);

    // Trim any extra spaces (optional, if the input might have spaces)
    $latitude = trim($latitude);
    $longitude = trim($longitude);

    // Initialize error array
    $errors = [];

    if (empty($_POST['koordinat'])) {
        $errors["koordinat"] = "Koordinat harus diisi!";
    } else {
        // Validate koordinat format (latitude,longitude)
        $koordinat = $_POST['koordinat'];
        if (!preg_match('/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/', $koordinat)) {
            $errors["koordinat_format"] = "Koordinat harus dalam format 'latitude,longitude'!";
        }
    }

    if (!empty($_FILES['foto']['name'])) {
        // Validate file upload (e.g., only images allowed)
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        

        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            $errors["fotoext"] = "Invalid file type. Hanya JPG, JPEG, PNG, and GIF yang diperbolehkan!";
        }

        $foto_name = uniqid("fasum_", true) . '.' . $file_extension; // Generate unique name
        $target_dir = "../uploads/images/";
        $target_file = $target_dir . $foto_name;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $errors['foto'] = "Error uploading file.";
        }
    } else {
        // Keep the old photo if no new file is uploaded
        $foto_name = $_POST['existing_foto'];
    }

    // If there are validation errors, stop and display errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors; // Save errors in session
        header("Location: /data/edit?id=$id"); // Redirect back to the form
        exit;
    } else {
        // File successfully uploaded

        // Insert into database
        $sql = "UPDATE list_fasum SET foto = '$foto_name', lapangan = '$jenis_lapangan', lokasi = '$lokasi', latitude = '$latitude', longitude = '$longitude'
                WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            // Redirect to /data on success
            header("Location: /data");
            exit;
        } else {
            $_SESSION['errors'] = $conn->error; // Add error to session
            header("Location: /data/edit?id=$id");
            exit;
        }
    }
}
