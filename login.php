<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Welcome to Book Bazar</title>
</head>

<body>
    <?php
    include 'database/connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT user_id, email, password FROM users WHERE email = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                header("Location: home.php?login=success");
                exit();
            } else {
                header("Location: login.php?error=invalid");
                exit();
            }
        } else {
            header("Location: login.php?match=error");
            exit();
        }

        $stmt->close();
        $conn->close();
    }
    ?>




    <div class="image-box">
        <img class="background" src="images/login.jpg">

    </div>
    <div class="right-box">
        <img src="images/logo.png" alt="">
        <h3>Login to <br>Book Bazzar</h3>
        <p class="welcome">Welcome Back</p>
        <form action="login.php" enctype="multipart/form-data" method="post">
            <div class="mb-2">
                <label class="email" for="email">Email address *</label><br>
                <input type="email" class="email-box" id="email" name="email"><br><br>
            </div>
            <div class="mb-2">
                <label class="password" for="password">Password *</label><br>
                <input type="password" class="password-box" id="password" name="password"><br><br>
                <img src="images/closed-eye.png"
                    style="width: 36px; cursor:pointer; position: absolute; top: 40.8%; transform: translateY(-50%); height:45px; right:12%"
                    id="eye-icon">
            </div>
            <a class="forget" href="">Forgot Password?</a><br>
            <div class="mb-2">
                <input type="checkbox" class="checkbox" id="remember" name="remember">
                <label class="remember" for="remember">Remember Me</label><br>
            </div>
            <button type="submit" class="login">Login</button>
            <p class="new">New Here?<a class="register-link" href="/bookBazzar/register.php"> Register</a></p>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');


        if (error === 'invalid') {
            toastr.error('Invalid User');
        }
    });
    </script>

    <script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const logout = urlParams.get('logout');


        if (logout === 'success') {
            toastr.success('User Logged out Successfully');
        }
    });
    </script>

    <script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const match = urlParams.get('match');


        if (match === 'error') {
            toastr.error('No matching user found!');
        }
    });
    </script>

    <script>
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
    </script>

</body>



</html>