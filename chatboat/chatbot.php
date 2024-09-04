<?php
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "chatboat"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['reply' => "Connection failed: " . $conn->connect_error]));
}

// Get user message from the request
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = strtolower($conn->real_escape_string($input['message'])); // Convert to lowercase and escape input

// Prepare SQL query to find the reply
$sql = "SELECT replay FROM chat WHERE question = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userMessage);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the reply from the database
    $row = $result->fetch_assoc();
    $reply = $row['replay'];
} else {
    // Default response if no match is found
    $reply = "Sorry, I don't understand that.";
}

// Return the reply as a JSON object
echo json_encode(['reply' => $reply]);

// Close the connection
$conn->close();
?>
