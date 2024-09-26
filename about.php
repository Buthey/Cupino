<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/about.css">
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
    <div class="banner">
        <div class="overlay">
            <h1>The Book Bazzar</h1>
            <p>"A world of knowledge at your fingertips, one page at a time."</p>
        </div>
    </div>

    <div class="about-section">
        <div class="about-content">
            <h2>About Us</h2>
            <p>Book Bazzar is a platform designed for book lovers who want to explore a vast collection of titles across
                genres. We believe in the power of books to educate, inspire, and transport readers to new worlds.</p>
            <p>With a commitment to bringing you the best selection of books, Book Bazzar is your go-to destination for
                everything from classic literature to the latest bestsellers. Whether you're looking for fiction,
                non-fiction, or children's books, you'll find it all here.</p>
        </div>
        <div class="about-image">
            <img src="images/store.jpg">
        </div>
    </div>
    <?php include 'layout/footer.php'; ?>
</body>

</html>