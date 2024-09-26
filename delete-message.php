<?php

include 'database/connect.php';

if (isset($_GET['id'])) {
    $message_id = intval($_GET['id']);

    $sql = "DELETE FROM messages WHERE message_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $message_id);

        if ($stmt->execute()) {
            header("Location: message.php?deleted=success");
            exit();
        } else {
            echo "Error deleting message: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
