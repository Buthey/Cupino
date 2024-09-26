<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/adminPanel.css">
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
        <a href="/bookBazzar/book.php" class="box-link">
            <div class="box">
                <i class="bx bx-book"></i>
                <h3>Books</h3>
                <p>View Books</p>
            </div>
        </a>
        <a href="/bookBazzar/user.php" class="box-link">
            <div class="box">
                <i class="bx bx-user"></i>
                <h3>Users</h3>
                <p>Manage Users</p>
            </div>
        </a>
        <a href="/bookBazzar/message.php" class="box-link">
            <div class="box">
                <i class="bx bx-message"></i>
                <h3>Messages</h3>
                <p>View Messages</p>
            </div>
        </a>
    </div>
</body>

</html>