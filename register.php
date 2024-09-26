<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="css/register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Signup</title>
</head>

<body>
    <?php include 'database/connect.php'; ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        if ($password !== $password_confirmation) {
            echo "<script>toastr.error('Passwords do not match!');</script>";
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>toastr.success('Registration successful!');</script>";
        } else {
            echo "<script>toastr.error('Error: Could not register!');</script>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
    <div class="image-box">
        <img class="background" src="images/login.jpg">

    </div>
    <div class="reg-right-box">
        <img src="images/logo.png" alt="">
        <h3>Register to <br>Book Bazzar</h3>
        <p class="new">New Here?</p>
        <form action="register.php" enctype="multipart/form-data" method="post">
            <div class="mb-2">
                <label class="firstName">First Name </label>
                <input type="text" id="name" class="first_name" name="first_name" />
            </div>
            <div class="mb-2">
                <label class="lastName">Last Name </label>
                <input type="text" id="name" class="last_name" name="last_name" />
            </div>
            <div class="mb-2">
                <label class="emailText">Email address </label>
                <input type="email" class="email" id="email" name="email">
            </div>
            <div class="mb-2 password-container">
                <label class="passwordText">Password</label>
                <input type="password" name="password" class="password" id="password">
                <img src="images/closed-eye.png"
                    style="width: 36px; cursor:pointer; position: absolute; top: 32.5%; transform: translateY(-50%); height:45px; right:23%"
                    id="eye-icon">
            </div>
            <div class="mb-2 password-container">
                <label class="cpasswordText">Confirm Password </label>
                <input type="password" class="cpassword" id="cpassword" name="password_confirmation">
                <img src="images/closed-eye.png"
                    style="width: 36px;cursor: pointer;position: absolute;margin-left: 558px;top: 34%;height: 45px;transform: translateY(-50%); right:23%"
                    id="eye-icon-conf">
            </div>
            <button type="submit" class="registerButton">Register</button>
            <p class="already">Already Member?<a class="login-link" href="/bookBazzar/login.php"> Login</a></p>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        const password = document.getElementById('password');
        const confpassword = document.getElementById('cpassword');
        let eyeIcon = document.getElementById('eye-icon');
        eyeIcon.onclick = function() {
            if (password.type == "password") {
                password.type = "text";
                eyeIcon.src = "images/eye-open.png"
            } else {
                password.type = "password";
                eyeIcon.src = "images/closed-eye.png"
            }
        }
        let eyeIconConf = document.getElementById('eye-icon-conf');
        eyeIconConf.onclick = function() {
            if (confpassword.type == "password") {
                confpassword.type = "text";
                eyeIconConf.src = "images/eye-open.png"
            } else {
                confpassword.type = "password";
                eyeIconConf.src = "images/closed-eye.png"
            }
        }
    </script>
</body>

</html>