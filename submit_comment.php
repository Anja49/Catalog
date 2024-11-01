<?php
include 'db.php';

$response = ['success' => false];

if (isset($_POST['name'], $_POST['email'], $_POST['text'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $text = $conn->real_escape_string($_POST['text']);

    $sql = "INSERT INTO comments (name, email, text, approved) VALUES ('$name', '$email', '$text', 0)";
    if ($conn->query($sql) === TRUE) {
        $response['success'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
