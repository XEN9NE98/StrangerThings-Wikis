<?php
require_once 'require_login.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quote_text = $_POST['quote_text'];
    $description = $_POST['description'] ?? '';
    $character_id = $_POST['character_id'] ?? null;
    $episode_id = $_POST['episode_id'] ?? null;
    
    // Convert empty strings to null
    if (empty($character_id)) $character_id = null;
    if (empty($episode_id)) $episode_id = null;
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("INSERT INTO quotes (quote_text, description, character_id, episode_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $quote_text, $description, $character_id, $episode_id);
    
    if ($stmt->execute()) {
        header("Location: ../quotes.php?success=added");
    } else {
        header("Location: ../quotes.php?error=failed");
    }
    
    $stmt->close();
    $conn->close();
}
?>
