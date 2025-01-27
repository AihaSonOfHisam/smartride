<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admins Staff List</title>
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
                        <h5>Staff Informations</h5> <a href="./staffs functions/add.php" class="btn btn-success">Add</a>
                        <table class="table table-striped table-bordered table-hover" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>E-Mail</th>
                                    <th>Phone Number</th>
									<th>IC</th>
									<th>Address</th>
									<th>Gender</th>
									<th>Role</th>
									<th>Salary</th>
									<th>Edit</th>
									<th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
require_once('../testdatabase.php');

// Query to fetch staff details
$query = "SELECT * FROM staff";

// Prepare the statement
$stid = oci_parse($dbconn, $query);

// Execute the query
oci_execute($stid);

// Display staff details in table rows
while ($row = oci_fetch_assoc($stid)) {
    $name = $row['NAME'];
    $email = $row['EMAIL'];
    $phoneNumber = $row['PHONE_NUM'];
    $ic = $row['IC'];
    $address = $row['ADDRESS'];
    $gender = $row['GENDER'];
    $role = $row['ROLE'];
    $salary = $row['SALARY'];

    echo "<tr>";
    echo "<td>" . htmlspecialchars($name) . "</td>";
    echo "<td>" . htmlspecialchars($email) . "</td>";
    echo "<td>" . htmlspecialchars($phoneNumber) . "</td>";
    echo "<td>" . htmlspecialchars($ic) . "</td>";
    echo "<td>" . htmlspecialchars($address) . "</td>";
    echo "<td>" . htmlspecialchars($gender) . "</td>";
    echo "<td>" . htmlspecialchars($role) . "</td>";
    echo "<td>" . htmlspecialchars($salary) . "</td>";
    echo "<td><a href='staffs functions/edit.php?ic=" . urlencode($ic) . "' class='btn btn-info'>Edit</a></td>";
    echo "<td><a href='staffs functions/delete.php?ic=" . urlencode($ic) . "' class='btn btn-danger'>Delete</a></td>";
    echo "</tr>";
}

// Close the Oracle statement and connection
oci_free_statement($stid);
oci_close($dbconn);
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
