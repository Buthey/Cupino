<?php
include 'database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start(); // Ensure session is started
    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

    if ($book_id > 0 && $user_id > 0) {
        $checkStmt = $conn->prepare("SELECT * FROM favourites WHERE user_id = ? AND book_id = ?");
        $checkStmt->bind_param("ii", $user_id, $book_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $favourite = $result->fetch_assoc()['is_favourite'] ? 0 : 1;
            $stmt = $conn->prepare("UPDATE favourites SET is_favourite = ? WHERE user_id = ? AND book_id = ?");
            $stmt->bind_param("iii", $favourite, $user_id, $book_id);

            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }

        } else {
            $is_favourite = 1;
            $stmt = $conn->prepare("INSERT INTO favourites (user_id, book_id, is_favourite) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $user_id, $book_id, $is_favourite);

            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }
        }

        $stmt->close();
        $checkStmt->close();
    } else {
        echo 'error';
    }

    $conn->close();
}