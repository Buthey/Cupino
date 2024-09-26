<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/shop.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Welcome to Book Bazar</title>
</head>

<body>
    <?php
    session_start();
    include 'layout/navbar.php'; ?>
    <?php include 'database/connect.php'; ?>
    <section class="hero-section">
        <div class="hero-content">
            <h1>Discover Your Next Favorite Book</h1>
            <p>Explore our extensive collection of books across various genres and find your next great read.</p>
        </div>
    </section>

    <div class="books-container">
        <h2>Latest Books</h2>
        <div class="book-list">
            <?php
            $sql = "SELECT book_id, book_name, book_price, image FROM books ORDER BY published_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<a href="book-detail.php?id=' . $row["book_id"] . '" class="book-link">';
                    echo '<div class="book-item">';
                    echo '<img src="' . $row["image"] . '" alt="' . $row["book_name"] . '">';
                    echo '<div class="details">';
                    echo '<h3>' . $row["book_name"] . '</h3>';
                    echo '<p>$' . $row["book_price"] . '</p>';
                    echo '</div></div></a>';
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
    </div>

</body>

</html>