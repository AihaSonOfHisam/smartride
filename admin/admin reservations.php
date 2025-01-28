<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Rezervations</title>
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
                        <h5>Reservations</h5> 
                        <table class="table table-striped table-bordered table-hover" style="margin-top: 20px;">
                            <thead>
                                <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Plate Number</th>
    <th>Rent Duration</th>
    <th>Rent Type</th>
    <th>Status</th>
    <th>Start Rent Date</th>
    <th>Delete</th>
    <th>Return Verification</th>
</tr>
</thead>
<tbody>
<?php
// Assuming you have a database connection established
require_once('../testdatabase.php'); // Ensure this connects using oci_connect()

// Query to fetch reservation details
$query = "SELECT * FROM reservation";
$statement = oci_parse($dbconn, $query);

// Execute the query
oci_execute($statement);

// Display reservation details in table rows
while ($row = oci_fetch_assoc($statement)) {
    $id = $row['RESERVATION_ID'];
    $username = $row['USERNAME'];
    $plateNumber = $row['PLATE_NUM'];
    $duration = $row['RENT_DURATION'];
    $rentType = $row['RENT_DURATION_TYPE'];
    $status = $row['STATUS'];
    $startRentDate = $row['START_RENT_DATE'];

    echo "<tr>";
    echo "<td>" . htmlspecialchars($id) . "</td>";
    echo "<td>" . htmlspecialchars($username) . "</td>";
    echo "<td>" . htmlspecialchars($plateNumber) . "</td>";
    echo "<td>" . htmlspecialchars($duration) . "</td>";
    echo "<td>" . htmlspecialchars($rentType) . "</td>";
    echo "<td>" . htmlspecialchars($status) . "</td>";
    echo "<td>" . htmlspecialchars($startRentDate) . "</td>";
    echo "<td><a href='reservation functions/delete.php?reservation_id=" . $id . "' class='btn btn-danger'onclick='return confirmDelete()'>Delete</a></td>";
    echo "<td><a href='reservation functions/verified.php?reservation_id=" . $id . "' class='btn btn-primary' style='margin: auto; display: block;'>Verified</a></td>";
    echo "</tr>";
}

// Free the statement
oci_free_statement($statement);
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
    <script>
function confirmDelete() {
  return confirm("Are you sure you want to delete this data?");
}
</script>

</body>
</html>
