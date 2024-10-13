<?php
session_start();
include 'db.php'; // Include your database connection

// Handle registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Check if the username already exists
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result && $result->fetchArray()) {
        // Username already exists
        echo "Error: Username already taken. Please choose a different username. <br>";
        echo "Already have an account? <a href='login.html'>Login here</a>."; // Link to login page
    } else {
        // Prepare the SQL statement to insert a new user
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        
        // Check if the statement was prepared correctly
        if (!$stmt) {
            die("Error preparing statement: " . $db->lastErrorMsg());
        }

        $stmt->bindValue(':username', $username, SQLITE3_TEXT); // Bind the username
        $stmt->bindValue(':password', $password, SQLITE3_TEXT); // Bind the hashed password

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.html");
            exit();
        } else {
            echo "Error registering user: " . $db->lastErrorMsg(); // Show error message
        }
    }
}
?>
