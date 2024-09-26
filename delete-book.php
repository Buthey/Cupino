<?php

include 'database/connect.php';

if (isset($_GET['id'])) {
    $book_id = intval($_GET['id']);

    $sql = "DELETE FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $book_id);

        if ($stmt->execute()) {
            header("Location: book.php?deleted=success");
            exit();
        } else {
            echo "Error deleting book: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
