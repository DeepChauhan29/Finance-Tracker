<?php
session_start();
include 'db.php'; // Include your database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields exist in the POST request
    if (!isset($_POST['description'], $_POST['amount'], $_POST['date'], $_POST['category'])) {
        echo "Error: All fields are required.";
        exit();
    }

    // Collect form data and trim whitespace
    $description = trim($_POST['description']);
    $amount = trim($_POST['amount']);
    $date = trim($_POST['date']);
    $category = trim($_POST['category']);

    // Validate form data
    if (empty($description) || empty($amount) || empty($date) || empty($category)) {
        echo "Error: All fields are required.";
        exit();
    }

    // Prepare SQL statement to insert expense
    $stmt = $db->prepare("INSERT INTO expenses (description, amount, date, category) VALUES (:description, :amount, :date, :category)");

    // Check if the statement was prepared correctly
    if (!$stmt) {
        die("Error preparing statement: " . $db->lastErrorMsg());
    }

    // Bind values to the statement
    $stmt->bindValue(':description', $description, SQLITE3_TEXT);
    $stmt->bindValue(':amount', $amount, SQLITE3_FLOAT); // Use SQLITE3_FLOAT for amounts
    $stmt->bindValue(':date', $date, SQLITE3_TEXT);
    $stmt->bindValue(':category', $category, SQLITE3_TEXT);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to index.php after successful addition
        header("Location: index.php");
        exit();
    } else {
        echo "Error adding expense: " . $db->lastErrorMsg();
    }
}
?>
