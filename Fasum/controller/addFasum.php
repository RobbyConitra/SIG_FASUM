<?php
// Start session safely to avoid "session already started" warning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config.php';

    // Initialize error array
    $errors = [];

    // Validation for required fields
    if (empty($_POST['jenis_lapangan'])) {
        $errors["lapangan"] = "Jenis lapangan harus diisi!";
    }

    if (empty($_POST['lokasi'])) {
        $errors["lokasi"] = "Lokasi harus diisi!";
    }

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
    } else {
        $errors["foto"] = "Foto harus diisi!";
    }

    // If there are validation errors, stop and display errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors; // Save errors in session
        header("Location: /data/create"); // Redirect back to the form
        exit;
    }

    // File upload handling
    $foto = $_FILES['foto'];
    $foto_name = uniqid("fasum_", true) . '.' . $file_extension; // Generate unique name
    $target_dir = "../uploads/images/";
    $target_file = $target_dir . $foto_name;

    if (move_uploaded_file($foto['tmp_name'], $target_file)) {
        // File successfully uploaded
        $jenis_lapangan = $_POST['jenis_lapangan'];
        $lokasi = $_POST['lokasi'];
        $koordinat = $_POST['koordinat']; //Example value = "1.12321, 104.1231293"

        // Split the string into an array using ',' as a delimiter
        list($latitude, $longitude) = explode(',', $koordinat);

        // Trim any extra spaces (optional, if the input might have spaces)
        $latitude = trim($latitude);
        $longitude = trim($longitude);

        // Insert into database
        $sql = "INSERT INTO list_fasum (foto, lapangan, lokasi, latitude, longitude) 
                VALUES ('$foto_name', '$jenis_lapangan', '$lokasi', '$latitude', '$longitude')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to /data on success
            header("Location: /data");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $_SESSION['errors'] = ["Error uploading file."]; // Add error to session
        header("Location: /create-form.php");
        exit;
    }

    $conn->close();
}
