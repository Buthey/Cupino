<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.5/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/add-book.css">
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
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['book_name'];
        $price = $_POST['book_price'];
        $quantity = $_POST['quantity'];
        $stock = isset($_POST['stock']) ? 1 : 0;
        $publish_date = $_POST['published_date'];

        // Handle file upload
        $image_path = 'images/books/' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            echo "Image uploaded successfully.";
        } else {
            echo "Failed to upload image.";
            $image_path = '';
        }

        $stmt = $conn->prepare("INSERT INTO books (image, book_name, book_price, quantity, stock, published_date) VALUES (?, ?, ?,
    ?, ?, ?)");
        $stmt->bind_param("ssdiis", $image_path, $title, $price, $quantity, $stock, $publish_date);


        if ($stmt->execute()) {
            header("Location: book.php?add=success");
            exit();
        } else {
            header("Location: book.php?add=error");
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <div class="container">
        <h1>Add New Book</h1>
        <form action="add-book.php" method="post" enctype="multipart/form-data">
            <label for="image">Book Image:</label>
            <input type="file" id="image" name="image" required>

            <label for="title">Book Title:</label>
            <input type="text" id="title" name="book_name" required>

            <label for="price">Price:</label>
            <input type="text" id="price" name="book_price" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="stock">In Stock:</label>
            <select id="stock" name="stock" required>
                <option value="1">In Stock</option>
                <option value="0">Out of Stock</option>
            </select>

            <label for="published_date">Published Date:</label>
            <input type="datetime-local" id="published_date" name="published_date" required>


            <input type="submit" value="Add Book">
        </form>
    </div>
</body>

</html>