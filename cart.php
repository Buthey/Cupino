<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.5/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/cart.css">
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

    $user_id = $_SESSION['user_id'];

    $query = "
        SELECT 
            books.image, 
            books.book_name, 
            cart.quantity_no, 
            cart.total_amount 
        FROM cart 
        JOIN books ON cart.book_id = books.book_id 
        WHERE cart.user_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
?>


    <?php while ($cart_item = $result->fetch_assoc()) { ?>
    <div class="cart-box">
        <img src="<?php echo $cart_item['image']; ?>" alt="<?php echo $cart_item['book_name']; ?>"
            class="cart-book-image">
        <h3><?php echo $cart_item['book_name']; ?></h3>
        <p>Quantity: <?php echo $cart_item['quantity_no']; ?></p>
        <p>Total: $<?php echo number_format($cart_item['total_amount'], 2); ?></p>
    </div>
    <?php } ?>

    <?php $stmt->close(); ?>
    <?php $conn->close(); ?>


</body>

</html>