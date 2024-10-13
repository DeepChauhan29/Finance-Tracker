<?php
session_start();
include 'db.php'; // Include your database connection

header('Content-Type: application/json');

// Check if the database is initialized
if (!$db) {
    echo json_encode(["error" => "Unable to open database: " . $db->lastErrorMsg()]);
    exit();
}

// Query to get the expenses
$stmt = $db->prepare("SELECT * FROM expenses");
if (!$stmt) {
    echo json_encode(["error" => "Error preparing statement: " . $db->lastErrorMsg()]);
    exit();
}

$results = $stmt->execute();
if (!$results) {
    echo json_encode(["error" => "Error executing query: " . $db->lastErrorMsg()]);
    exit();
}

// Fetch expenses into an array
$expenses = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $expenses[] = $row;
}

// Return expenses as JSON
echo json_encode($expenses);
?>
