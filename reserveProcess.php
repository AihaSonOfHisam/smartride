<?php
    session_start([
      'cookie_lifetime' => 0,
      'cookie_secure' => true,
      'cookie_httponly' => true,
      'cookie_samesite' => 'Strict',
  ]); // Start the session (if not already started)

   // Implement session timeout
   $timeout = 1800; // 30 minutes
   if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
         session_unset();
         session_destroy();
         header("Location: Login/Login.html");
         exit();
   }
   $_SESSION['last_activity'] = time();

    if (isset($_SESSION['username'])) {
        // User is logged in, continue with the rest of the code
    } else {
        // User is not logged in, redirect to login page
        echo '<script>alert("Please log in to continue!"); window.location.href = "Login/Login.html";</script>';
    }
?>
<html>
<head>
    <title>reservation process</title>
</head>
<body>
    <center>

    <?php
    require_once('testdatabase.php'); // Ensure this file contains the correct Oracle DB connection setup

    // Retrieve form data
    $username = $_SESSION['username'];
    $selected_plate_num = $_REQUEST['selected_plate_num'];
    $rentDuration = $_REQUEST['rent_duration'];
    $rentType = $_REQUEST['rent_type'];
    $startRentDate = $_REQUEST['start_rent_date'];

    // Query to insert the reservation into the database
    $query = "INSERT INTO reservation (username, plate_num, rent_duration_type, rent_duration, start_rent_date, status) 
            VALUES (:username, :plate_num, :rent_type, :rent_duration, TO_DATE(:start_rent_date, 'YYYY-MM-DD'), 'pending payment')";

    // Prepare and bind the parameters
    $statement = oci_parse($dbconn, $query);
    oci_bind_by_name($statement, ":username", $username);
    oci_bind_by_name($statement, ":plate_num", $selected_plate_num);
    oci_bind_by_name($statement, ":rent_type", $rentType);
    oci_bind_by_name($statement, ":rent_duration", $rentDuration);
    oci_bind_by_name($statement, ":start_rent_date", $startRentDate);

    // Execute the query
    oci_execute($statement);

    // Check if the reservation was inserted successfully
    if ($statement) {
        // Retrieve the last inserted reservation ID
        $reservationIdQuery = "SELECT reservation_id FROM reservation WHERE username = :username 
                            AND plate_num = :plate_num AND rent_duration_type = :rent_type 
                            AND rent_duration = :rent_duration AND start_rent_date = TO_DATE(:start_rent_date, 'YYYY-MM-DD')";
        
        $reservationStatement = oci_parse($dbconn, $reservationIdQuery);
        oci_bind_by_name($reservationStatement, ":username", $username);
        oci_bind_by_name($reservationStatement, ":plate_num", $selected_plate_num);
        oci_bind_by_name($reservationStatement, ":rent_type", $rentType);
        oci_bind_by_name($reservationStatement, ":rent_duration", $rentDuration);
        oci_bind_by_name($reservationStatement, ":start_rent_date", $startRentDate);
        
        oci_execute($reservationStatement);

        // Fetch the reservation ID
        if ($row = oci_fetch_assoc($reservationStatement)) {
            $reservationId = $row['RESERVATION_ID'];

            // Redirect to payment page
            echo '<script>alert("Reservation Created Successfully!");</script>';
            header("Location: payment.php?reservation_id=$reservationId&selected_plate_num=$selected_plate_num");
            exit();
        } else {
            // Error: Reservation ID not found
            echo "Error: Could not retrieve reservation ID.";
        }

        // Free the resources
        oci_free_statement($statement);
        oci_free_statement($reservationStatement);
    } else {
        // Error during insertion
        echo "Error: " . oci_error($statement)['message'];
    }

    // Close the Oracle connection
    oci_close($dbconn);
    ?>



    </center>
</body>
</html>
