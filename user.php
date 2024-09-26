<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.5/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/user.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Welcome to User Management</title>
</head>

<body>
    <?php
    session_start();
    include 'layout/navbar.php'; ?>
    <?php include 'database/connect.php'; ?>

    <div class="container">
        <div class="add-button">
            <a href="/bookBazzar/add-user.php" class="button">
                <i class="bx bx-plus"></i> Add User
            </a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Lsst Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT user_id, first_name,last_name, email, role
                  FROM users ";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Error in query: " . $conn->error);
                    }
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["user_id"] . '</td>';
                            echo '<td>' . $row["first_name"] . '</td>';
                            echo '<td>' . $row["last_name"] . '</td>';
                            echo '<td>' . $row["email"] . '</td>';
                            echo '<td>' . $row["role"] . '</td>';
                            echo '<td>
                    <a class="edit-btn" href="edit-user.php?id=' . $row["user_id"] . '">Edit</a> 
                    <a class="delete-btn" href="delete-user.php?id=' . $row["user_id"] . '" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a>
                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="9">No users found</td></tr>';
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
            toastr.success('User was Updated successfully!');
        } else if (status === 'error') {
            toastr.error('There was an error.');
        }

        if (add === 'success') {
            toastr.success('User was Added successfully!');
        } else if (add === 'error') {
            toastr.error('There was an error.');
        }

        if (deleted === 'success') {
            toastr.success('User was Deleted successfully!');
        } else if (deleted === 'error') {
            toastr.error('There was an error.');
        }
    });
    </script>

</body>

</html>