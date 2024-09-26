<?php
session_start();
include 'database/connect.php';

if (isset($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);
    $user_id = $_SESSION['user_id']; 

    $query = "DELETE FROM favourites WHERE user_id = ? AND book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $book_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>