<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM episodes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $episode = $result->fetch_assoc();
    
    echo json_encode($episode);
    
    $stmt->close();
    $conn->close();
}
?>
