<?php
include 'database/connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
    $quantity_no = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; 
    $total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0.0;

    if ($user_id > 0 && $book_id > 0 && $quantity_no > 0) {
        $query = "SELECT * FROM cart WHERE user_id = ? AND book_id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $updateQuery = "UPDATE cart SET quantity_no = quantity_no + ?, total_amount = total_amount + ? WHERE user_id = ? AND book_id = ?";
            $updateStmt = $conn->prepare($updateQuery);

            if ($updateStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $updateStmt->bind_param("idii", $quantity_no, $total_amount, $user_id, $book_id);
            $updateStmt->execute();
        } else {
            $insertQuery = "INSERT INTO cart (user_id, book_id, quantity_no, total_amount) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);

            if ($insertStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $insertStmt->bind_param("iiid", $user_id, $book_id, $quantity_no, $total_amount);
            $insertStmt->execute();
        }

        header("Location: book-detail.php?id=$book_id&add-cart=success");
exit();

    } else {
        header("Location: book-detail.php?add-cart=error");
                exit();
    }
}

$conn->close();
?>