<?php
require_once 'require_login.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF Token
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die("Error: Invalid CSRF token.");
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $actor_name = $_POST['actor_name'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $youtube_clip_url = $_POST['youtube_clip_url'] ?? '';
    $age = !empty($_POST['age']) ? intval($_POST['age']) : null;
    $born_date = !empty($_POST['born_date']) ? $_POST['born_date'] : null;
    $height = $_POST['height'] ?? '';
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("UPDATE characters SET name=?, actor_name=?, description=?, image_url=?, youtube_clip_url=?, age=?, born_date=?, height=? WHERE id=?");
    $stmt->bind_param("sssssissi", $name, $actor_name, $description, $image_url, $youtube_clip_url, $age, $born_date, $height, $id);
    
    if ($stmt->execute()) {
        header("Location: ../characters.php?success=updated");
    } else {
        header("Location: ../characters.php?error=failed");
    }
    
    $stmt->close();
    $conn->close();
}
?>
