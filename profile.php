<?php
// Start session
ob_start();
session_start();

$pageTitle = 'Profile';

// Include the database connection file
include "connect.php";
include 'Includes/functions/functions.php';
include "Includes/templates/header.php";
include 'Includes/templates/navbar.php';
?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    var vertical_staff = document.getElementById("vertical-menu");


    var current = vertical_staff.getElementsByClassName("active_link");

    if(current.length > 0)
    {
        current[0].classList.remove("active_link");   
    }
    
    vertical_staff.getElementsByClassName('staff_link')[0].className += " active_link";

</script>
<style type="text/css">
    body {
        background: url('Design/images/home_bg.jpg') center center fixed;
        background-size: cover;
    }
</style>
<?php

// Check if user is logged in
if (!isset($_SESSION['client_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit;
}

// Retrieve user information from the database based on client_id
$stmt = $con->prepare("SELECT * FROM clients WHERE client_id = ?");
$stmt->execute([$_SESSION['client_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user exists
if (!$user) {
    // If user not found, redirect to login page
    header("Location: login.php");
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();
    
    // Redirect to index.php after logout
    header("Location: index.php");
    exit;
}

// Update user information
if(isset($_POST['edit_user_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $client_id = test_input($_POST['client_id']);
    $client_name = test_input($_POST['client_name']);
    $client_phone = test_input($_POST['client_phone']);
    $client_email = test_input($_POST['client_email']);
    $client_address = test_input($_POST['client_address']);
    $client_city = test_input($_POST['client_city']);
    $client_zipcode = test_input($_POST['client_zipcode']);
    $client_password = $_POST['client_password'];
    $hashedPass = sha1($client_password);

    try
    {
        $stmt = $con->prepare("update clients  set client_name = ?, client_phone = ?, client_email = ?, client_address=?, client_city=?,client_zipcode=?,client_password=? where client_id = ? ");
        $stmt->execute(array($client_name,$client_phone,$client_email,$client_address,$client_city,$client_zipcode,$hashedPass,$client_id));
        
        ?> 
                                        <!-- SUCCESS MESSAGE -->
            <script type="text/javascript">
            swal("Edit User","Profile has been updated successfully", "success").then((value) => 
                {
                    window.location.replace("profile.php");
                });
            </script>

        <?php

    }
    catch(Exception $e)
    {
        echo 'Error occurred: ' .$e->getMessage();
    }
}

?>



    <div class="card">
        <div class="card-header">
            Edit Profile
        </div>
        <div class="card-body">
            <form method="POST" class="menu_form" action="profile.php?do=Edit&client_id=<?php echo $user['client_id'] ?>">
                <div class="panel-X">
                    <div class="panel-header-X">
                    </div>

                    <div class="panel-body-X">                         
                                            <!-- User ID -->

                        <input type="hidden" name="client_id" value="<?php echo $user['client_id'];?>" >

                        <div class="form-group">
                            <label for="client_email">E-mail</label>
                            <input type="email" class="form-control" value="<?php echo $user['client_email'] ?>" placeholder="User Email" name="client_email">
                            <?php

                                if(isset($_POST['edit_user_sbmt']))
                                {
                                    if(empty(test_input($_POST['client_email'])))
                                    {
                                        ?>
                                            <div class="invalid-feedback" style="display: block;">
                                                E-mail is required.
                                            </div>
                                        <?php

                                        $flag_edit_user_form = 1;
                                    }
                                    elseif(!filter_var($_POST['client_email'], FILTER_VALIDATE_EMAIL))
                                    {
                                        ?>
                                            <div class="invalid-feedback" style="display: block;">
                                                Invalid e-mail.
                                            </div>
                                        <?php

                                        $flag_edit_user_form = 1;
                                    }
                                }
                            ?>
                        </div>
                                            <!-- Staff_Name INPUT -->

                        <div class="form-group">
                            <label for="client_name">Name</label>
                            <input type="text" class="form-control" value="<?php echo $user['client_name'] ?>" placeholder="Name" name="client_name">
                            <?php
                                $flag_edit_user_form = 0;

                                if(isset($_POST['edit_user_sbmt']))
                                {
                                    if(empty(test_input($_POST['client_name'])))
                                        {
                                            ?>
                                                <div class="invalid-feedback" style="display: block;">
                                                    Name is required.
                                                </div>
                                            <?php

                                            $flag_edit_user_form = 1;
                                        }
                                }
                            ?>
                        </div>


                                            <!-- Staff Number INPUT -->
                        <div class="form-group">
                            <label for="client_phone">Phone Number</label>
                            <input type="text" class="form-control" value="<?php echo $user['client_phone'] ?>" placeholder="(000)-000-000" name="client_phone">
                                                
                            <?php

                            if(isset($_POST['edit_user_sbmt']))
                            {
                                if(empty(test_input($_POST['client_phone'])))
                                {
                                    ?>
                                        <div class="invalid-feedback" style="display: block;">
                                            Number is required.
                                        </div>
                                    <?php

                                    $flag_edit_user_form = 1;
                                }
                            }
                            ?>
                        </div>
                                 


                                            <!-- Staff_Password INPUT -->

                        <div class="form-group">
                            <label for="client_password">Password</label>
                            <input type="password" class="form-control" name="client_password">
                            <?php

                                if(isset($_POST['edit_user_sbmt']))
                                {
                                    if(!empty($_POST['client_password']) and strlen($_POST['client_password']) < 8)
                                    {
                                        ?>
                                            <div class="invalid-feedback" style="display: block;">
                                                Password length must be at least 8 characters.
                                            </div>
                                        <?php

                                        $flag_edit_user_form = 1;
                                    }
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="client_address">Street Address</label>
                            <input type="text" class="form-control" value="<?php echo $user['client_address'] ?>" placeholder="St. Address" name="client_address">
                            <?php
                                $flag_edit_user_form = 0;

                                if(isset($_POST['edit_user_sbmt']))
                                {
                                    if(empty(test_input($_POST['client_address'])))
                                        {
                                            ?>
                                                <div class="invalid-feedback" style="display: block;">
                                                    Street Address is required.
                                                </div>
                                            <?php

                                            $flag_edit_user_form = 1;
                                        }
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="client_city">City</label>
                            <input type="text" class="form-control" value="<?php echo $user['client_city'] ?>" placeholder="City" name="client_city">
                            <?php
                                $flag_edit_user_form = 0;

                                if(isset($_POST['edit_user_sbmt']))
                                {
                                    if(empty(test_input($_POST['client_city'])))
                                        {
                                            ?>
                                                <div class="invalid-feedback" style="display: block;">
                                                    City is required.
                                                </div>
                                            <?php

                                            $flag_edit_user_form = 1;
                                        }
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="client_zipcode">Zip Code</label>
                            <input type="number" class="form-control" value="<?php echo $user['client_zipcode'] ?>" placeholder="Zip Code" name="client_zipcode">
                            <?php
                                $flag_edit_user_form = 0;

                                if(isset($_POST['edit_user_sbmt']))
                                {
                                    if(empty(test_input($_POST['client_zipcode'])))
                                        {
                                            ?>
                                                <div class="invalid-feedback" style="display: block;">
                                                    Zip Code is required.
                                                </div>
                                            <?php

                                            $flag_edit_user_form = 1;
                                        }
                                }
                            ?>
                        </div>
                        <div class="button-controls">
                            <button type="submit" name="edit_user_sbmt" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    
    include 'Includes/templates/footer.php';
?>





