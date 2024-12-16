<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve form data from POST request
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$number = isset($_POST['number']) ? preg_replace('/\D/', '', $_POST['number']) : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : 'Not specified';

// Basic validation to check if required fields are filled
if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($number)) {
    die("All fields are required!");
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // If the connection fails, exit
}

// Prepare SQL query to insert data
$stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, gender, email, password, number) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $firstName, $lastName, $gender, $email, $password, $number); // Bind the parameters

// Execute query and check for success
if ($stmt->execute()) {
    echo "Registration successful!<br>"; // Success message
} else {
    echo "Error executing query: " . $stmt->error . "<br>"; // If there's an error with the query
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
