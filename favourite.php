<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/favourite.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Welcome to Book Bazar</title>
</head>

<body>
    <?php
session_start();
include ('layout/navbar.php');
include 'database/connect.php';

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

if ($user_id > 0) {
    $query = "SELECT b.book_id, b.book_name, b.book_price, b.image 
          FROM favourites f
          JOIN books b ON f.book_id = b.book_id
          WHERE f.user_id = ? AND f.is_favourite = 1";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="favourite-item">';
            echo '<img src="' . $row['image'] . '" alt="' . $row['book_name'] . '" class="book-image">';
            echo '<h3>' . $row['book_name'] . '</h3>';
            echo '<p>Price: $' . number_format($row['book_price'], 2) . '</p>';

            echo '<div class="quantity-container">';
            echo '<label for="quantity-' . $row['book_id'] . '" class="quantity-label">Quantity:</label>';
            echo '<div class="quantity-selector">';
            echo '<button type="button" class="quantity-btn" onclick="decrementQuantity(' . $row['book_id'] . ')">-</button>';
            echo '<input type="text" id="quantity-' . $row['book_id'] . '" value="1" readonly>';
            echo '<button type="button" class="quantity-btn" onclick="incrementQuantity(' . $row['book_id'] . ')">+</button>';
            echo '</div>';
            echo '</div>';

            echo '<button class="add-to-cart-btn" data-book-id="' . $row['book_id'] . '">Add to Cart</button>';
            echo '</div>';
        }
    } else {
        echo '<p>You have no favorite books yet.</p>';
    }
    
    $stmt->close();
}

$conn->close();
?>

    <script>
    function incrementQuantity(bookId) {
        var quantityInput = document.getElementById('quantity-' + bookId);
        var quantity = parseInt(quantityInput.value);
        quantityInput.value = quantity + 1;
    }

    function decrementQuantity(bookId) {
        var quantityInput = document.getElementById('quantity-' + bookId);
        var quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    }
    </script>

</body>

</html>