<?php
require_once 'require_login.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $maps_url = $_POST['maps_url'] ?? '';
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("UPDATE locations SET name=?, description=?, image_url=?, maps_url=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $description, $image_url, $maps_url, $id);
    
    if ($stmt->execute()) {
        header("Location: ../locations.php?success=updated");
    } else {
        header("Location: ../locations.php?error=failed");
    }
    
    $stmt->close();
    $conn->close();
}
?>
