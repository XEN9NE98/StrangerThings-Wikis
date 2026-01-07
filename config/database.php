<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'stranger_things_wiki');

// Create connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Get total count for a table
function getCount($table) {
    $conn = getDBConnection();
    $result = $conn->query("SELECT COUNT(*) as count FROM $table");
    $row = $result->fetch_assoc();
    $count = $row['count'];
    $conn->close();
    return $count;
}

// Get random quote of the day
function getQuoteOfTheDay() {
    $conn = getDBConnection();
    $query = "SELECT q.*, c.name as character_name, e.title as episode_title 
              FROM quotes q 
              LEFT JOIN characters c ON q.character_id = c.id 
              LEFT JOIN episodes e ON q.episode_id = e.id 
              ORDER BY RAND() 
              LIMIT 1";
    $result = $conn->query($query);
    $quote = $result->fetch_assoc();
    $conn->close();
    return $quote;
}
?>
