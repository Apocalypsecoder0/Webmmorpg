<?php
// patch.php
if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    // Get data from request
    parse_str(file_get_contents("php://input"), $data);
    $id = $data['id'];
    $name = $data['name'] ?? null; // Optional
    $email = $data['email'] ?? null; // Optional

    // Database connection
    $conn = new mysqli("localhost", "username", "password", "my_update_database");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the update query
    $query = "UPDATE users SET ";
    $params = [];
    $types = "";

    if ($name) {
        $query .= "name = ?, ";
        $params[] = $name;
        $types .= "s";
    }
    if ($email) {
        $query .= "email = ?, ";
        $params[] = $email;
        $types .= "s";
    }

    // Remove the last comma and space
    $query = rtrim($query, ", ");
    $query .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    // Prepare and bind
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["message" => "Record patched successfully"]);
    } else {
        echo json_encode(["error" => "Error patching record: " . $conn->error]);
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
