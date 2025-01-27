<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="./css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="./css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">&nbsp;SMARTRIDE</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                           session_start([
                               'cookie_lifetime' => 0,
                               'cookie_secure' => true,
                               'cookie_httponly' => true,
                               'cookie_samesite' => 'Strict',
                           ]);
                           
                           // Implement session timeout
                           $timeout = 1800; // 30 minutes
                           if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
                               session_unset();
                               session_destroy();
                               header("Location: ../Login/Login.html");
                               exit();
                           }
                           $_SESSION['last_activity'] = time();
                           
                           if (isset($_SESSION['username'])) {
                            // User is logged in, display log-out button
                            echo '<li><a href="../Login/logout.php">Logout</a></li>';
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center user-image-back">
						<?php
							echo "<h3>" . $_SESSION['username'] . "</h3>";
						?>

                    </li>


                    <li>
                        <a href="dashboard.php"><i class="fa fa-desktop "></i>Dashboard</a>
                    </li>

                    <li>
                        <a href="admin customer.php"><i class="fa fa-drivers-license "></i>Customers Informations</a>
                    </li>
					<li>
                        <a href="admin reservations.php"><i class="fa fa-clipboard "></i>Reservations</a>
                    </li>
                    <li>
                        <a href="admin car list.php"><i class="fa fa-car "></i>Car List</a>
                    </li>
					<li>
                        <a href="admin staff.php"><i class="material-icons" style="font-size:17px">person</i>Staffs</a>
                    </li>
                
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Dashboard</h2>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        
                        <div class="panel panel-primary text-center no-boder bg-color-blue">
                            <div class="panel-body">
                                <i class="fa fa-car" style="font-size:70px"></i>
								<?php
								  // Assuming you have an Oracle database connection established
								  require_once('../testdatabase.php');

								  // Query to fetch available cars
								  $query = "SELECT COUNT(*) AS available_cars FROM car WHERE status = 'available'";
								  $statement = oci_parse($dbconn, $query);
								  oci_execute($statement);

								  // Fetch the count
								  $row = oci_fetch_assoc($statement);
								  $numAvailableCars = $row['AVAILABLE_CARS'];

								  // Display the number of available cars
								  echo "<h3>$numAvailableCars</h3>";

								  oci_free_statement($statement);
								?>
                            </div>
                            <div class="panel-footer back-footer-blue">
                                Current Available Car
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
						<div class="panel panel-primary text-center no-boder bg-color-purple">
                            <div class="panel-body">
                                <i class="fa fa-wrench" style="font-size:70px"></i>
								<?php
								  // Query to fetch cars under maintenance
								  $query = "SELECT COUNT(*) AS maintenance_cars FROM car WHERE status = 'maintenance'";
								  $statement = oci_parse($dbconn, $query);
								  oci_execute($statement);

								  // Fetch the count
								  $row = oci_fetch_assoc($statement);
								  $numMaintenance = $row['MAINTENANCE_CARS'];

								  // Display the number of cars in maintenance
								  echo "<h3>$numMaintenance</h3>";

								  oci_free_statement($statement);
								?>
                            </div>
                            <div class="panel-footer back-footer-purple">
                                In Maintenance
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="panel panel-primary text-center no-boder bg-color-orange">
                            <div class="panel-body">
                                <i class="fa fa-exchange" style="font-size:70px"></i>
                                <?php
								  // Query to fetch returned reservations
								  $query = "SELECT COUNT(*) AS returned_rentals FROM reservation WHERE status = 'returned'";
								  $statement = oci_parse($dbconn, $query);
								  oci_execute($statement);

								  // Fetch the count
								  $row = oci_fetch_assoc($statement);
								  $numReturned = $row['RETURNED_RENTALS'];

								  // Display the number of returned rentals
								  echo "<h3>$numReturned</h3>";

								  oci_free_statement($statement);
								?>
                            </div>
                            <div class="panel-footer back-footer-orange">
                                Returned/Completed Rental
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-3 col-sm-3 col-xs-6">
						<div class="panel panel-primary text-center no-boder bg-color-green">
                            <div class="panel-body">
                                <i class="fa fa-handshake-o" style="font-size:70px"></i>
                                <?php
								  // Query to fetch number of customers
								  $query = "SELECT COUNT(*) AS total_customers FROM customers";
								  $statement = oci_parse($dbconn, $query);
								  oci_execute($statement);

								  // Fetch the count
								  $row = oci_fetch_assoc($statement);
								  $numCustomer = $row['TOTAL_CUSTOMERS'];

								  // Display the number of customers
								  echo "<h3>$numCustomer</h3>";

								  oci_free_statement($statement);
								?>
                            </div>
                            <div class="panel-footer back-footer-green">
                                Registered User/Customer
                            </div>
                        </div>
                    </div>
				
                    <div class="row" style="margin-left: 20px;">
    <div class="col-md-6">
        <h5>Latest renter</h5>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>E-Mail</th>
                    <th>Car Plate</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Query to fetch latest reservations
                    $query = "SELECT r.reservation_id, r.username, c.email, r.plate_num, r.rent_duration, r.rent_duration_type 
                              FROM reservation r 
                              JOIN customers c ON r.username = c.username
                              ORDER BY r.reservation_id DESC";
                    
                    // Prepare and execute the query
                    $statement = oci_parse($dbconn, $query);
                    if (!oci_execute($statement)) {
                        $e = oci_error($statement);  // Get Oracle error if query execution fails
                        echo "Error executing query: " . $e['message'];
                    } else {
                        // Fetch the data if execution is successful
                        while ($row = oci_fetch_assoc($statement)) {
                            $reservationId = $row['RESERVATION_ID'];
                            $username = $row['USERNAME'];
                            $email = $row['EMAIL'];
                            $plate_num = $row['PLATE_NUM'];
                            $rent_duration = $row['RENT_DURATION'];
                            $rent_duration_type = $row['RENT_DURATION_TYPE'];
                            
                            // Output the rows
                            echo "<tr>
                                    <td>$reservationId</td>
                                    <td>$username</td>
                                    <td>$email</td>
                                    <td>$plate_num</td>
                                    <td>$rent_duration $rent_duration_type</td>
                                  </tr>";
                        }
                        
                        // Free the statement
                        oci_free_statement($statement);
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>


            </div>
        </div>
    </div>

</body>
</html>
