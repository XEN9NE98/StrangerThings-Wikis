<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM locations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $location = $result->fetch_assoc();
    
    echo json_encode($location);
    
    $stmt->close();
    $conn->close();
}
?>
