<?php
session_start();
include 'db.php'; // Include your database connection

// Handle login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to select the user
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    if (!$stmt) {
        die("Error preparing statement: " . $db->lastErrorMsg());
    }
    
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();

    // Fetch the user data
    $user = $result->fetchArray(SQLITE3_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.html"); // Redirect to main page
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!-- Simple login form -->
<form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <input type="submit" value="Login">
</form>
