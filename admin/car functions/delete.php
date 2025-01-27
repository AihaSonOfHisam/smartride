<?php
require_once('../../testdatabase.php');

// Check if the car ID is provided
if (isset($_GET['plate_num'])) {
    $plateNumber = $_GET['plate_num'];

    // Prepare the delete query with bind variables for security
    $query = "DELETE FROM car WHERE plate_num = :plate_num";

    // Prepare the statement
    $stid = oci_parse($dbconn, $query);

    // Bind the plate number
    oci_bind_by_name($stid, ":plate_num", $plateNumber);

    // Execute the delete query
    if (oci_execute($stid)) {
        echo '<script>alert("Successfully deleted car information."); window.location.href = "../admin car list.php";</script>';
    } else {
        // Error occurred while deleting car details
        $error = oci_error($stid);
        echo "Error: " . $error['message'];
    }

    // Free the statement
    oci_free_statement($stid);
}

// Close the connection
oci_close($dbconn);
?>
