<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $character = $result->fetch_assoc();
    
    echo json_encode($character);
    
    $stmt->close();
    $conn->close();
}
?>
