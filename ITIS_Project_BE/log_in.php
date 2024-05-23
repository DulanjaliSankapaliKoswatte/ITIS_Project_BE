<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $json = file_get_contents('php://input');
    // Decode the JSON data
    $data = json_decode($json, true);

    // Extract the data
    $username = $data['username'];
    $password = $data['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'library_managment');
    if ($conn->connect_error) {
        echo json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error));
        exit();
    }

    // Check if the user exists
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo json_encode(array("success" => true, "message" => "Login successful! Redirecting to library page..."));
        } else {
            echo json_encode(array("success" => false, "message" => "Invalid password."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid username."));
    }

    $stmt->close();
    $conn->close();
}
?>
