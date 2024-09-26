<?php

include 'database/connect.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            header("Location: user.php?deleted=success");
            exit();
        } else {
            echo "Error deleting user: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
