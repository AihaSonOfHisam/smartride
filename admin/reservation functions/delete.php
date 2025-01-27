<?php
require_once('../../testdatabase.php');

if (isset($_GET['reservation_id'])) {
    $reservationId = $_GET['reservation_id'];

    // Prepare the SQL query
    $query = "DELETE FROM reservation WHERE reservation_id = :reservation_id";

    // Prepare the statement
    $stid = oci_parse($dbconn, $query);

    // Bind the reservation_id parameter
    oci_bind_by_name($stid, ":reservation_id", $reservationId);

    // Execute the query
    $result = oci_execute($stid);

    if ($result) {
        echo '<script>alert("Reservation deleted successfully."); window.location.href = "../admin reservations.php";</script>';
    } else {
        // Error handling
        $error = oci_error($stid);
        echo "Failed to delete the reservation. Error: " . $error['message'];
    }

    // Free the statement
    oci_free_statement($stid);
} else {
    echo "Invalid reservation ID.";
}

// Close the connection
oci_close($dbconn);
?>
