<?php
    ob_start();
    session_start();

    $pageTitle = 'My Orders';

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
        if(current.length > 0)
        {
            current[0].classList.remove("active_link");   
        }
        vertical_menu.getElementsByClassName('menu_categories_link')[0].className += " active_link";
    </script>

    <style type="text/css">
            body {
        background: url('Design/images/home_bg.jpg') center center fixed;
        background-size: cover;
    }
        .categories-table
        {
            -webkit-box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
            text-align: center;
            vertical-align: middle;
        }
    </style>

    <?php
    
    // Retrieve user information from the database based on client_id
    $stmt = $con->prepare("SELECT * FROM placed_orders WHERE client_id = ?");
    $stmt->execute([$client_id]);
    $my_orders = $stmt->fetchAll();

    ?>
    <div class="card">
        <div class="card-header">
            <?php echo $pageTitle; ?>
        </div>
        <div class="card-body">
            <!-- MENU CATEGORIES TABLE -->
            <table class="table table-bordered categories-table">
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Order Time</th>
                        <th scope="col">Order Items</th>  
                        <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($my_orders as $order)
                        {
                            $order_id = $order['order_id'];
                            $order_time = $order['order_time'];
                            $delivery_address = $order['delivery_address'];
                            $total_price = 0; // Initialize total price for this order
                            
                            // Retrieve order items for this order from in_order table
                            $stmt_o = $con->prepare("SELECT * FROM in_order WHERE order_id = ?");
                            $stmt_o->execute([$order_id]);
                            $order_items = $stmt_o->fetchAll();
                            
                            echo "<tr>";
                            echo "<td>$order_id</td>";
                            echo "<td>$order_time</td>";
                            echo "<td>";
                            
                            // Display order items
                            foreach($order_items as $item)
                            {
                                $menu_id = $item['menu_id'];
                                $quantity = $item['quantity'];
                                
                                // Retrieve menu details for this item
                                $stmt_m = $con->prepare("SELECT * FROM menus WHERE menu_id = ?");
                                $stmt_m->execute([$menu_id]);
                                $menu = $stmt_m->fetch(PDO::FETCH_ASSOC);
                                
                                // Display menu name and quantity
                                echo $menu['menu_name'] . " (Quantity: $quantity)<br>";
                                
                                // Calculate subtotal for this item
                                $subtotal = $menu['menu_price'] * $quantity;
                                $total_price += $subtotal; // Add subtotal to total price
                            }
                            
                            echo "</td>";
                            echo "<td>$total_price</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>  
        </div>
    </div>
    <?php

    /*** FOOTER BOTTON ***/
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

