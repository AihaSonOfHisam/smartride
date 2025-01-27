<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Car List</title>
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
							session_start();
							
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
                        <a href="admin customer.php"><i class="fa fa-drivers-license "></i>Customer Informations</a>
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
			
                <div class="row" style="margin-left: 20px;">
                    <div class="col-md-6">
                        <h5>Car List</h5> <a href="car functions/add.php" class="btn btn-success">Add</a>
                        <table class="table table-striped table-bordered table-hover" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>Plate Number</th>
                                    <th>Brand</th>
                                    <th>Model</th>
									<th>Colour</th>
									<th>Type</th>
									<th>Seats</th>
									<th>Transmission</th>
									<th>RM/Day</th>
									<th>RM/Week</th>
									<th>RM/Month</th>
									<th>Status</th>
									<th>Edit</th>
									<th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            require_once('../testdatabase.php');

                            // Query to fetch car details
                            $query = "SELECT * FROM car";
                            $stid = oci_parse($dbconn, $query);
                            oci_execute($stid);

                            // Display car details in table rows
                            while ($row = oci_fetch_assoc($stid)) {
                                $plateNumber = $row['PLATE_NUM'];
                                $brand = $row['BRAND'];
                                $model = $row['MODEL'];
                                $colour = $row['COLOUR'];
                                $type = $row['TYPE'];
                                $seats = $row['SEAT_NUM'];
                                $transmission = $row['TRANSMISSION'];
                                $pricePerDay = $row['PRICE_PER_DAY'];
                                $pricePerWeek = $row['PRICE_PER_WEEK'];
                                $pricePerMonth = $row['PRICE_PER_MONTH'];
                                $status = $row['STATUS'];

                                echo "<tr>";
                                echo "<td>" . $plateNumber . "</td>";
                                echo "<td>" . $brand . "</td>";
                                echo "<td>" . $model . "</td>";
                                echo "<td>" . $colour . "</td>";
                                echo "<td>" . $type . "</td>";
                                echo "<td>" . $seats . "</td>";
                                echo "<td>" . $transmission . "</td>";
                                echo "<td>" . "RM " . $pricePerDay . "</td>";
                                echo "<td>" . "RM " . $pricePerWeek . "</td>";
                                echo "<td>" . "RM " . $pricePerMonth . "</td>";
                                echo "<td>" . $status . "</td>";
                                echo "<td><a href='car functions/edit.php?plate_num=" . $plateNumber . "' class='btn btn-info'>Edit</a></td>";
                                echo "<td><a href='car functions/delete.php?plate_num=" . $plateNumber . "' class='btn btn-danger'>Delete</a></td>";
                                echo "</tr>";
                            }
                            ?>

                            </tbody>
                        </table>

                    </div>
                    
                </div>
				
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>


</body>
</html>
