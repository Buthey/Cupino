<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/home.css">
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
    <div class="container">
        <div class="background">
            <img src="images/background.jpg" width="100%" height="650px" alt="Background Image" />
            <div class="overlay">
                <h2>A Bookstore is a Dream Factory where Anything is Possible and Every Story Awaits.</h2>
                <a href="/bookBazzar/shop.php" class="button"><i class="bx bx-cart icon"></i> Shop Now</a>
            </div>
        </div>

        <div class="book-box">
            <h1> <i class='bx bxs-book-open'></i> New Arrival</h1>
            <h2 class="more"><a href="/bookBazzar/shop.php">View More <i class='bx bx-right-arrow-alt'></i> <a></h2>
            <?php
            $sql = "SELECT book_id, book_name, book_price, image FROM books ORDER BY published_date DESC LIMIT 5";
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
    <?php include 'layout/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const login = urlParams.get('login');


            if (login === 'success') {
                toastr.success('User was Logged in successful');
            }
        });
    </script>
</body>

</html>