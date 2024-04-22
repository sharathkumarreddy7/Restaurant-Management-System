<?php
// Start the session at the beginning of the script
session_start();
?>

<!-- START NAVBAR SECTION -->

<header id="header" class="header-section">
    <div class="container">
        <nav class="navbar">
            <a href="index.php" class="navbar-brand">
                <img src="Design/images/restaurant-logo.png" alt="Restaurant Logo" style="width: 150px;">
            </a>
            <div class="d-flex menu-wrap align-items-center">
                <div class="mainmenu" id="mainmenu">
                    <ul class="nav">
                        <li><a href="index.php#home">HOME</a></li>
                        <li><a href="index.php#menus">MENUS</a></li>
                        <li><a href="index.php#gallery">GALLERY</a></li>
                        <li><a href="index.php#about">ABOUT</a></li>
                        <li><a href="index.php#contact">CONTACT</a></li>
                    </ul>
                </div>

                <?php if (isset($_SESSION['client_id'])): ?>
                    <!-- Display if client is logged in -->
                    <div class="header-btn" style="margin-left:10px">
                        <a href="table-reservation.php" target="_blank" class="menu-btn">Reserve Table</a>
                    </div>
                    <div class="header-btn" style="margin-left:10px">
                        <a href="profile.php" target="_blank" class="menu-btn">Profile</a>
                    </div>
                <?php else: ?>
                    <!-- Display if no client is logged in -->
                    <div class="header-btn" style="margin-left:10px">
                        <a href="login.php" target="_blank" class="menu-btn">Sign-in</a>
                    </div>
                <?php endif; ?>
                
            </div>
        </nav>
    </div>
</header>

<div class="header-height" style="height: 120px;"></div>

<!-- END NAVBAR SECTION -->
