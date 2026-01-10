<?php
// Database configuration
// The "?:" trick checks: "Do we have a DigitalOcean variable? If NO, use XAMPP default."

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASSWORD') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'stranger_things_wiki'); // Auto-switches name
define('DB_PORT', getenv('DB_PORT') ?: 3306); // Auto-switches port

// Create connection
function getDBConnection() {
    // We added DB_PORT as the 5th argument because DigitalOcean uses port 25060
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Get total count for a table
function getCount($table) {
    $conn = getDBConnection();
    // Protect against SQL injection slightly better, but your original logic is preserved here
    $result = $conn->query("SELECT COUNT(*) as count FROM $table");
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    } else {
        $count = 0;
    }
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
    if ($result) {
        $quote = $result->fetch_assoc();
    } else {
        $quote = null;
    }
    $conn->close();
    return $quote;
}

// Include CSRF helper
require_once __DIR__ . '/../includes/csrf.php';
?>