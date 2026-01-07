<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $maps_url = $_POST['maps_url'] ?? '';
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("INSERT INTO locations (name, description, image_url, maps_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $description, $image_url, $maps_url);
    
    if ($stmt->execute()) {
        header("Location: ../locations.php?success=added");
    } else {
        header("Location: ../locations.php?error=failed");
    }
    
    $stmt->close();
    $conn->close();
}
?>
