
    <?php
        //Set page title
        $pageTitle = 'Login';

        include "connect.php";
        include 'Includes/functions/functions.php';
        include "Includes/templates/header.php";
        include "Includes/templates/navbar.php";
    ?>

    <style type="text/css">
        /* Styles for login section */
        .login-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 150px); /* Subtracting header and footer heights */
        }
        .login-section h2 {
            margin-bottom: 20px;
        }
        .login-option {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-option form {
            margin-bottom: 20px;
        }
        .login-option form input {
            margin-bottom: 10px;
        }
        .login-option form button {
            background-color: #ffc851;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

    <section class="login-section">
        <h2>Login</h2>
        <div class="login-option">
            <form action="user-login.php" method="post">
                <input type="text" name="user_username" placeholder="Username" required>
                <input type="password" name="user_password" placeholder="Password" required>
                <button type="submit">Customer Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
        <div class="login-option">
            <form action="staff-login.php" method="post">
                <input type="text" name="staff_username" placeholder="Username" required>
                <input type="password" name="staff_password" placeholder="Password" required>
                <button type="submit">Staff Login</button>
            </form>
        </div>
    </section>


    <?php include "Includes/templates/footer.php"; ?>
