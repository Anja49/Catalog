<?php
session_start();
include 'db.php';


if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_id = $_POST['comment_id'];

   
    $query = "UPDATE comments SET approved = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $comment_id);

    if ($stmt->execute()) {
        echo "Komentar je uspešno odobren.";
    } else {
        echo "Greška pri odobravanju komentara: " . $conn->error;
    }
    header("Location: admin.php");
    exit();
}
?>
