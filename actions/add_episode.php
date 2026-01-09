<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $season = $_POST['season'];
    $episode_number = $_POST['episode_number'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $youtube_clip_url = $_POST['youtube_clip_url'] ?? '';
    $air_date = $_POST['air_date'] ?? null;
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("INSERT INTO episodes (title, season, episode_number, description, image_url, youtube_clip_url, air_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siissss", $title, $season, $episode_number, $description, $image_url, $youtube_clip_url, $air_date);
    
    if ($stmt->execute()) {
        header("Location: ../episodes.php?success=added");
    } else {
        header("Location: ../episodes.php?error=failed");
    }
    
    $stmt->close();
    $conn->close();
}
?>
