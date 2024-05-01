<?php
    ob_start();
    session_start();

    $pageTitle = 'My Reservations';

    // Check if client_id is not set in the session
    if (!isset($_SESSION['client_id'])) {
        // If client_id is not set, redirect to login page
        header("Location: login.php");
        exit(); // Stop further execution
    }

    // Assign client_id from session to a variable
    $client_id = $_SESSION['client_id'];

    include 'connect.php';
    include 'Includes/functions/functions.php'; 
    include 'Includes/templates/header.php';
    include 'Includes/templates/navbar.php';

    ?>

    <script type="text/javascript">
        var vertical_menu = document.getElementById("vertical-menu");
        var current = vertical_menu.getElementsByClassName("active_link");
        if(current.length > 0) {
            current[0].classList.remove("active_link");   
        }
        vertical_menu.getElementsByClassName('menu_reservations_link')[0].className += " active_link";
    </script>

    <style type="text/css">
        body {
        background: url('Design/images/home_bg.jpg') center center fixed;
        background-size: cover;
    }
        .reservations-table {
            -webkit-box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
            text-align: center;
            vertical-align: middle;
        }
    </style>

    <?php
    // Retrieve reservation information from the database based on client_id
    $stmt = $con->prepare("SELECT * FROM reservations WHERE client_id = ? AND canceled = 0");
    $stmt->execute([$client_id]);
    $reservations = $stmt->fetchAll();
    ?>
    <div class="card">
        <div class="card-header">
            <?php echo $pageTitle; ?>
        </div>
        <div class="card-body">
            <!-- RESERVATIONS TABLE -->
            <table class="table table-bordered reservations-table">
                <thead>
                    <tr>
                        <th scope="col">Reservation ID</th>
                        <th scope="col">Reserved Date</th>
                        <th scope="col">Reserved Time</th>
                        <th scope="col">Number of Guests</th>
                        <th scope="col">Table ID</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($reservations as $reservation)
                        {
                            echo "<tr>";
                            echo "<td>" . $reservation['reservation_id'] . "</td>";
                            echo "<td>" . date('Y-m-d', strtotime($reservation['selected_time'])) . "</td>";
                            echo "<td>" . date('H:i', strtotime($reservation['selected_time'])) . "</td>";
                            echo "<td>" . $reservation['nbr_guests'] . "</td>";
                            echo "<td>" . $reservation['table_id'] . "</td>";
                            echo "<td>" . ($reservation['liberated'] ? "Liberated" : "Active") . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>  
        </div>
    </div>


<section class="widget_section" style="background-color: #222227;padding: 100px 0;">
<div class="container">
<div class="row">
<div class="col-lg-3 col-md-6">
<div class="footer_widget">
<img src="Design/images/restaurant-logo.png" alt="Restaurant Logo" style="width: 150px;margin-bottom: 20px;">
<p>
    Our Restaurnt is one of the bests, provide tasty Menus and Dishes. You can reserve a table or Order food.
</p>
<ul class="widget_social">
    <li><a href="#" data-toggle="tooltip" title="Facebook"><i class="fab fa-facebook-f fa-2x"></i></a></li>
    <li><a href="#" data-toggle="tooltip" title="Twitter"><i class="fab fa-twitter fa-2x"></i></a></li>
    <li><a href="#" data-toggle="tooltip" title="Instagram"><i class="fab fa-instagram fa-2x"></i></a></li>
    <li><a href="#" data-toggle="tooltip" title="LinkedIn"><i class="fab fa-linkedin fa-2x"></i></a></li>
    <li><a href="#" data-toggle="tooltip" title="Google+"><i class="fab fa-google-plus-g fa-2x"></i></a></li>
</ul>
</div>
</div>
<div class="col-lg-3 col-md-6">
<div class="footer_widget">
<h3>Headquarters</h3>
<p>
    962 Fifth Avenue, 3rd Floor New York, NY10022
</p>
<p>
    contact@restaurant.com
    <br>
    (+123) 456 789 101    
</p>
</div>
</div>
<div class="col-lg-3 col-md-6">
<div class="footer_widget">
<h3>
    Opening Hours
</h3>
<ul class="opening_time">
    <li>Monday - Friday 11:30am - 2:008pm</li>
    <li>Monday - Friday 11:30am - 2:008pm</li>
    <li>Monday - Friday 11:30am - 2:008pm</li>
    <li>Monday - Friday 11:30am - 2:008pm</li>
</ul>
</div>
</div>
<div class="col-lg-3 col-md-6">
<div class="footer_widget">
<h3>Subscribe to our contents</h3>
<div class="subscribe_form">
    <form action="#" class="subscribe_form" novalidate="true">
        <input type="email" name="EMAIL" id="subs-email" class="form_input" placeholder="Email Address...">
        <button type="submit" class="submit">SUBSCRIBE</button>
        <div class="clearfix"></div>
    </form>
</div>
</div>
</div>
</div>
</div>
</section>
<?php
    /*** FOOTER BOTTOM ***/
    include 'Includes/templates/footer.php';
?>

<!-- JS SCRIPTS -->

<script type="text/javascript">


	// When add category button is clicked

    $('#add_category_bttn').click(function()
    {
        var category_name = $("#category_name_input").val();
        var do_ = "Add";

        if($.trim(category_name) == "")
        {
            $('#required_category_name').css('display','block');
        }
        else
        {
            $.ajax(
            {
                url:"ajax_files/menu_categories_ajax.php",
                method:"POST",
                data:{category_name:category_name,do:do_},
                dataType:"JSON",
                success: function (data) 
                {
                    if(data['alert'] == "Warning")
                    {
                        swal("Warning",data['message'], "warning").then((value) => {});
                    }
                    if(data['alert'] == "Success")
                    {
                        swal("New Category",data['message'], "success").then((value) => {
                            window.location.replace("menu_categories.php");
                        });
                    }
                    
                },
                error: function(xhr, status, error) 
                {
                    alert('AN ERROR HAS BEEN ENCOUNTERED WHILE TRYING TO EXECUTE YOUR REQUEST');
                }
            });
        }
    });

	// When delete category button is clicked

    $('.delete_category_bttn').click(function()
    {
        var category_id = $(this).data('id');
        var do_ = "Delete";

        $.ajax(
        {
            url:"ajax_files/menu_categories_ajax.php",
            method:"POST",
            data:{category_id:category_id,do:do_},
            success: function (data) 
            {
                swal("Delete Category","The category has been deleted successfully!", "success").then((value) => {
                    window.location.replace("menu_categories.php");
                });     
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN ENCOUNTERED WHILE TRYING TO EXECUTE YOUR REQUEST');
            }
          });
    });

</script>

