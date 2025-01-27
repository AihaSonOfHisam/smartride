<?php
require_once('../../testdatabase.php');

if (isset($_GET['reservation_id'])) {
    $reservationId = $_GET['reservation_id'];

    // Update the status of the reservation to "Returned"
    $reservationQuery = "UPDATE reservation SET status = 'Returned' WHERE reservation_id = :reservation_id";
    $stid = oci_parse($dbconn, $reservationQuery);
    oci_bind_by_name($stid, ":reservation_id", $reservationId);

    $reservationResult = oci_execute($stid);

    if ($reservationResult) {
        // Update the status of the car to "Available"
        $carQuery = "UPDATE car SET status = 'available' WHERE plate_num IN (SELECT plate_num FROM reservation WHERE reservation_id = :reservation_id)";
        $stid = oci_parse($dbconn, $carQuery);
        oci_bind_by_name($stid, ":reservation_id", $reservationId);

        $carResult = oci_execute($stid);

        if ($carResult) {
            echo '<script>alert("Reservation status updated to Returned. Car status updated to Available."); window.location.href = "../admin reservations.php";</script>';
        } else {
            echo "Failed to update the car status.";
        }
    } else {
        echo "Failed to update the reservation status.";
    }
} else {
    echo "Invalid reservation ID.";
}
?>
