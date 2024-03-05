<?php
// Start a session to store user information
session_start();

// Check if the user is already logged in, redirect to home if true
if(isset($_SESSION['user_id'])){
    header("Location: home.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to your database (replace these values with your database information)
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $database = "your_database";

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // You should hash the password in a real-world scenario
    // For simplicity, this example uses plaintext passwords (which is not secure)
    // You should use password_hash() and password_verify() functions for secure password handling

    // Query the database for user authentication
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User is authenticated, set session variables and redirect to home page
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("Location: home.php");
        exit();
    } else {
        // Invalid login, show an error message
        $error_message = "Invalid username or password";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
