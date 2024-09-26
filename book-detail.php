<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.5/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/book-detail.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Welcome to Book Bazar</title>
</head>

<body>
    <?php
session_start();
include 'layout/navbar.php';
include 'database/connect.php';

if (isset($_GET['id'])) {
    $book_id = intval($_GET['id']); 

    $query = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc(); 
    } else {
        echo "Book not found.";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $fav_query = "SELECT * FROM favourites WHERE user_id = ? AND book_id = ?";
    $fav_stmt = $conn->prepare($fav_query);
    $fav_stmt->bind_param("ii", $user_id, $book_id);
    $fav_stmt->execute();
    $fav_result = $fav_stmt->get_result();

    $is_favourite = $fav_result->num_rows > 0 ? 1 : 0;
} else {
    echo "Book ID not provided.";
    exit();
}
?>


    <div class="container">
        <img src="<?php echo $book['image']; ?>" alt="<?php echo $book['book_name']; ?>" class="book-image">

        <h2><?php echo $book['book_name']; ?></h2>

        <i id="favourite" class='bx <?php echo $is_favourite ? "bxs-heart" : "bx-heart"; ?> favourite-icon'
            data-book-id="<?php echo $book['book_id']; ?>"
            style="color: <?php echo $is_favourite ? 'red' : 'black'; ?>; cursor: pointer;">
        </i>


        <p class="stock">
            <?php echo $book['stock'] ? "<span class='in-stock'>In Stock</span>" : "<span class='out-of-stock'>Out of Stock</span>"; ?>
        </p>

        <div class="quantity-container">
            <label for="quantity" class="quantity-label">Quantity:</label>
            <div class="quantity-selector">
                <button type="button" class="quantity-btn" onclick="decrementQuantity()">-</button>
                <input type="text" id="quantity" value="1" readonly>
                <button type="button" class="quantity-btn" onclick="incrementQuantity()">+</button>
            </div>
        </div>

        <p class="price">Price: $<?php echo number_format($book['book_price'], 2); ?></p>

        <button class="add-to-cart"
            onclick="addToCart(<?php echo $book['book_id']; ?>, <?php echo $book['book_price']; ?>, <?php echo $_SESSION['user_id']; ?>)">Add
            to Cart</button>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const add = urlParams.get('add-cart');

        if (add === 'success') {
            toastr.success('Added to Cart Successfully');
        } else if (add === 'error') {
            toastr.error('There was an error.');
        }
    });
    </script>
    <script>
    function decrementQuantity() {
        let quantity = document.getElementById("quantity").value;
        if (quantity > 1) {
            document.getElementById("quantity").value = --quantity;
        }
    }

    function incrementQuantity() {
        let quantity = document.getElementById("quantity").value;
        document.getElementById("quantity").value = ++quantity;
    }

    function addToCart(bookId, bookPrice, userId) {
        let quantity = parseInt(document.getElementById("quantity").value);
        let totalAmount = bookPrice * quantity;

        if (confirm(`Do you want to add ${quantity} item(s) to the cart for a total of $${totalAmount.toFixed(2)}?`)) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'add-cart.php';

            let inputBookId = document.createElement('input');
            inputBookId.type = 'hidden';
            inputBookId.name = 'book_id';
            inputBookId.value = bookId;
            form.appendChild(inputBookId);

            let inputUserId = document.createElement('input');
            inputUserId.type = 'hidden';
            inputUserId.name = 'user_id';
            inputUserId.value = userId;
            form.appendChild(inputUserId);

            let inputQuantity = document.createElement('input');
            inputQuantity.type = 'hidden';
            inputQuantity.name = 'quantity';
            inputQuantity.value = quantity;
            form.appendChild(inputQuantity);

            let inputTotalAmount = document.createElement('input');
            inputTotalAmount.type = 'hidden';
            inputTotalAmount.name = 'total_amount';
            inputTotalAmount.value = totalAmount;
            form.appendChild(inputTotalAmount);

            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>


    <script>
    $(document).ready(function() {
        $('.favourite-icon').on('click', function() {
            var $this = $(this);
            var bookId = $this.data('book-id');
            var isFavourite = $this.hasClass('bxs-heart') ? 1 : 0;

            if (!bookId) {
                toastr.error('Book ID is missing.');
                return;
            }

            if (isFavourite == 0) {
                $.ajax({
                    url: 'favourite-update.php',
                    method: 'POST',
                    data: {
                        book_id: bookId
                    },
                    success: function(response) {
                        console.log('Server response:', response);

                        if (response.trim() === 'success') {
                            $this.removeClass('bx-heart').addClass('bxs-heart').css('color',
                                'red');
                            toastr.success('Added to favourites!');
                        } else {
                            toastr.error('An error occurred: ' + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX error:', error);
                        toastr.error('Failed to update favourite status. Error: ' + error);
                    }
                });
            } else {
                $.ajax({
                    url: 'delete-favourite.php',
                    method: 'POST',
                    data: {
                        book_id: bookId
                    },
                    success: function(response) {
                        console.log('Server response:', response);

                        if (response.trim() === 'success') {
                            $this.removeClass('bxs-heart').addClass('bx-heart').css('color',
                                'black');
                            toastr.success('Removed from favourites!');
                        } else {
                            toastr.error('An error occurred: ' + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX error:', error);
                        toastr.error('Failed to remove favourite status. Error: ' + error);
                    }
                });
            }
        });
    });
    </script>

</body>

</html>