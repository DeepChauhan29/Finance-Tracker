<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create a new SQLite3 database or open an existing one
$db = new SQLite3('finance_tracker.db');

// Check if the database was created successfully
if (!$db) {
    die("Unable to open database: " . $db->lastErrorMsg());
}

// Create users table if it doesn't exist
$query = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
)";

if (!$db->exec($query)) {
    die("Error creating users table: " . $db->lastErrorMsg());
}

// Create expenses table if it doesn't exist
$query = "CREATE TABLE IF NOT EXISTS expenses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    description TEXT NOT NULL,
    amount REAL NOT NULL,
    date TEXT NOT NULL,
    category TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if (!$db->exec($query)) {
    die("Error creating expenses table: " . $db->lastErrorMsg());
}

// Close the database connection
// Note: Keep it open for the entire request lifecycle
?>
