<?php
require_once 'require_login.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $id = $_POST['id'];
    
    $table = '';
    switch($type) {
        case 'character':
            $table = 'characters';
            break;
        case 'episode':
            $table = 'episodes';
            break;
        case 'quote':
            $table = 'quotes';
            break;
        case 'location':
            $table = 'locations';
            break;
        default:
            echo "Invalid type";
            exit;
    }
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Item deleted successfully";
    } else {
        echo "Error deleting item";
    }
    
    $stmt->close();
    $conn->close();
}
?>
