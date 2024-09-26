<?php

include 'database/connect.php';

$role = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if ($stmt = $conn->prepare("SELECT role FROM users WHERE user_id = ?")) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();
    }
}

?>


<nav class="navbar">
    <div class="page-name">The Book Bazzar</div>
    <ul>
        <?php if ($role === 'Admin'): ?>
        <li><a href="/bookBazzar/adminPanel.php"><i class='bx bx-data'></i> Data</a></li>
        <?php endif; ?>
        <li><a href="/bookBazzar/home.php"><i class="bx bx-home icon"></i> Home</a></li>
        <li><a href="/bookBazzar/shop.php"><i class="bx bx-store icon"></i> Shop</a></li>
        <li><a href="/bookBazzar/about.php"><i class="bx bx-info-circle icon"></i> About Us</a></li>
        <li><a href="/bookBazzar/contact.php"><i class="bx bx-phone icon"></i> Contact Us</a></li>
        <li><a href="/bookBazzar/favourite.php"><i class="bx bx-heart icon"></i> Favourite</a></li>
        <li><a href="/bookBazzar/cart.php"><i class="bx bx-cart icon"></i> Cart</a></li>
        <li><a href="/bookBazzar/profile.php"><i class="bx bx-user icon"></i> Profile</a></li>
        <li><a href="/bookBazzar/logout.php"><i class="bx bx-log-out icon"></i> Logout</a></li>
    </ul>
</nav>