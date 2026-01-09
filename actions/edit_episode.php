<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $season = $_POST['season'];
    $episode_number = $_POST['episode_number'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $youtube_clip_url = $_POST['youtube_clip_url'] ?? '';
    $air_date = $_POST['air_date'] ?? null;
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("UPDATE episodes SET title=?, season=?, episode_number=?, description=?, image_url=?, youtube_clip_url=?, air_date=? WHERE id=?");
    $stmt->bind_param("siissssi", $title, $season, $episode_number, $description, $image_url, $youtube_clip_url, $air_date, $id);
    
    if ($stmt->execute()) {
        header("Location: ../episodes.php?success=updated");
    } else {
        header("Location: ../episodes.php?error=failed");
    }
    
    $stmt->close();
    $conn->close();
}
?>
