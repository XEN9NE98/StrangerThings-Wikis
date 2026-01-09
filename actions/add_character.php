<?php
require_once 'require_login.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $actor_name = $_POST['actor_name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $youtube_clip_url = $_POST['youtube_clip_url'] ?? '';
    $age = !empty($_POST['age']) ? intval($_POST['age']) : null;
    $born_date = !empty($_POST['born_date']) ? $_POST['born_date'] : null;
    $height = $_POST['height'] ?? '';
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("INSERT INTO characters (name, actor_name, description, image_url, youtube_clip_url, age, born_date, height) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisss", $name, $actor_name, $description, $image_url, $youtube_clip_url, $age, $born_date, $height);
    
    if ($stmt->execute()) {
        header("Location: ../characters.php?success=added");
    } else {
        header("Location: ../characters.php?error=failed");
    }
    
    $stmt->close();
    $conn->close();
}
?>
