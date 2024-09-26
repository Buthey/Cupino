<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.5/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/edit-book.css">
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
    if (isset($_GET['id'])) {
        $book_id = $_GET['id'];

        $sql = "SELECT * FROM books WHERE book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $book_name = $row['book_name'];
            $book_price = $row['book_price'];
            $quantity = $row['quantity'];
            $stock = $row['stock'];
            $published_date = $row['published_date'];
            $image = $row['image'];
        } else {
            echo "Book not found!";
        }
        $stmt->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $book_id = $_POST['book_id'];
        $title = $_POST['book_name'];
        $price = $_POST['book_price'];
        $quantity = $_POST['quantity'];
        $stock = isset($_POST['stock']) ? 1 : 0;
        $publish_date = $_POST['published_date'];

        $image_path = '';
        if (!empty($_FILES['image']['name'])) {
            $image_path = 'images/books/' . basename($_FILES['image']['name']);
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                echo "Failed to upload image.";
                $image_path = '';
            }
        }

        if (!empty($image_path)) {
            $stmt = $conn->prepare("UPDATE books SET image = ?, book_name = ?, book_price = ?, quantity = ?, stock = ?, published_date = ? WHERE book_id = ?");
            $stmt->bind_param("ssdiisi", $image_path, $title, $price, $quantity, $stock, $publish_date, $book_id);
        } else {
            $stmt = $conn->prepare("UPDATE books SET book_name = ?, book_price = ?, quantity = ?, stock = ?, published_date = ? WHERE book_id = ?");
            $stmt->bind_param("sdiisi", $title, $price, $quantity, $stock, $publish_date, $book_id);
        }

        if ($stmt->execute()) {
            header("Location: book.php?status=success");
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    }
    ?>

    <div class="container">
        <h1>Edit Book</h1>
        <form action="edit-book.php?id=<?php echo $book_id; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">

            <label for="image">Book Image:</label>
            <input type="file" id="image" name="image">
            <br>
            <?php if (!empty($image)) { ?>
            <img src="<?php echo $image; ?>" alt="Book Image" width="100">
            <?php } ?>

            <label for="title">Book Title:</label>
            <input type="text" id="title" name="book_name" value="<?php echo $book_name; ?>" required>

            <label for="price">Price:</label>
            <input type="text" id="price" name="book_price" value="<?php echo $book_price; ?>" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>

            <label for="stock">In Stock:</label>
            <select id="stock" name="stock" required>
                <option value="1" <?php echo ($stock == 1) ? 'selected' : ''; ?>>In Stock</option>
                <option value="0" <?php echo ($stock == 0) ? 'selected' : ''; ?>>Out of Stock</option>
            </select>

            <label for="published_date">Published Date:</label>
            <input type="datetime-local" id="published_date" name="published_date"
                value="<?php echo date('Y-m-d\TH:i', strtotime($published_date)); ?>" required>

            <input type="submit" name="edit_book" value="Update Book">
        </form>
    </div>


</body>

</html>