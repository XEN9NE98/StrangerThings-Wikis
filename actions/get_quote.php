<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = getDBConnection();
    $query = "SELECT q.*, c.name as character_name, e.title as episode_title 
              FROM quotes q 
              LEFT JOIN characters c ON q.character_id = c.id 
              LEFT JOIN episodes e ON q.episode_id = e.id 
              WHERE q.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $quote = $result->fetch_assoc();
    
    echo json_encode($quote);
    
    $stmt->close();
    $conn->close();
}
?>
