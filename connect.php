<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$dbname = "flux";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize POST data
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$country = $_POST['country'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Validate password match
if ($password !== $confirmPassword) {
    die("Error: Passwords do not match.");
}

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL statement
$sql = "INSERT INTO registration (firstname, lastname, country, phone, email, password)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssss", $firstname, $lastname, $country, $phone, $email, $hashed_password);
    if ($stmt->execute()) {
        echo "Signup successful!";
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}

$conn->close();
?>
