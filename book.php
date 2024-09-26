<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.5/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/book.css">
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
        <div class="add-button">
            <a href="/bookBazzar/add-book.php" class="button">
                <i class="bx bx-plus"></i> Add Books
            </a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Image</th>
                        <th>Book Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Stock</th>
                        <th>Publish Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT book_id, image, book_name, book_price, quantity, stock, published_date 
                  FROM books 
                  ORDER BY published_date DESC";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Error in query: " . $conn->error);
                    }
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["book_id"] . '</td>';
                            echo '<td><img src="' . $row["image"] . '" alt="Book Image" width="50"></td>';
                            echo '<td>' . $row["book_name"] . '</td>';
                            echo '<td>$' . $row["book_price"] . '</td>';
                            echo '<td>' . $row["quantity"] . '</td>';
                            echo '<td>' . ($row["stock"] ? 'In Stock' : 'Out of Stock') . '</td>';
                            echo '<td>' . $row["published_date"] . '</td>';
                            echo '<td>
                    <a class="edit-btn" href="edit-book.php?id=' . $row["book_id"] . '">Edit</a> 
                    <a class="delete-btn" href="delete-book.php?id=' . $row["book_id"] . '" onclick="return confirm(\'Are you sure you want to delete this book?\');">Delete</a>
                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8">No books found</td></tr>';
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const add = urlParams.get('add');
        const deleted = urlParams.get('deleted');

        if (status === 'success') {
            toastr.success('Book was Updated successful!');
        } else if (status === 'error') {
            toastr.error('There was an error.');
        }

        if (add === 'success') {
            toastr.success('Book was Added successful!');
        } else if (add === 'error') {
            toastr.error('There was an error.');
        }

        if (deleted === 'success') {
            toastr.success('Book was Deleted successful!');
        } else if (deleted === 'error') {
            toastr.error('There was an error.');
        }
    });
    </script>


</body>

</html>