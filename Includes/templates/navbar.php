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
                    <li id="user-btn" class="main-li dropdown" style="margin-left:10px;background:none;">
                    <div class="dropdown show">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>
                            <span class="username">Profile</span>
                            <b class="caret"></b>
                        </a>
                        <!-- DROPDOWN MENU -->
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user-cog"></i>
                                <span style="padding-left:6px">
                                    Edit Profile
                                </span>
                            </a>
                            <a class="dropdown-item" href="my_orders.php">
                                <i class="fa fa-list"></i>
                                <span style="padding-left:6px">
                                    My Orders
                                </span>
                            </a>   
                            <a class="dropdown-item" href="myreservations.php">
                                <i class="fas fa-concierge-bell"></i>
                                <span style="padding-left:6px">
                                    My Reservations
                                </span>
                            </a>                          
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span style="padding-left:6px">Logout</span>
                            </a>
                        </div>
                    </div>
                </li>

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
