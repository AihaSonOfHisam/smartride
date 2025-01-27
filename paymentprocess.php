<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Process</title>
</head>
<body>
    <center>
        <?php
        require_once('testdatabase.php'); // Assume it provides $dbconn (already initialized Oracle connection)

        // Retrieve form data safely
        $reservation_id = $_REQUEST['reservation_id'] ?? null;
        $total = $_REQUEST['total_amount'] ?? null;

        // Check if essential data is provided
        if (empty($reservation_id) || empty($total)) {
            echo '<script>alert("Missing reservation ID or total amount.");</script>';
            exit();
        }

        if (!$dbconn) {
            $error = oci_error();
            die("Database connection failed: " . $error['message']);
        }

        try {
            // Start a transaction
            oci_execute(oci_parse($dbconn, "BEGIN NULL; END;")); // Ensures the connection is in a transaction context

            // Insert payment into the payment table
            $insertPaymentQuery = "INSERT INTO payment (reservation_id, total_price) VALUES (:reservation_id, :total) RETURNING payment_id INTO :payment_id";
            $stmt = oci_parse($dbconn, $insertPaymentQuery);
            oci_bind_by_name($stmt, ":reservation_id", $reservation_id);
            oci_bind_by_name($stmt, ":total", $total);
            oci_bind_by_name($stmt, ":payment_id", $payment_id, -1, SQLT_INT);

            if (!oci_execute($stmt, OCI_NO_AUTO_COMMIT)) {
                throw new Exception("Failed to insert payment.");
            }

            // Update the reservation status to "in rent"
            $updateReservationQuery = "UPDATE reservation SET status = 'in rent' WHERE reservation_id = :reservation_id";
            $stmt = oci_parse($dbconn, $updateReservationQuery);
            oci_bind_by_name($stmt, ":reservation_id", $reservation_id);

            if (!oci_execute($stmt, OCI_NO_AUTO_COMMIT)) {
                throw new Exception("Failed to update reservation status.");
            }

            // Retrieve the plate number for the reservation
            $getPlateNumQuery = "SELECT plate_num FROM reservation WHERE reservation_id = :reservation_id";
            $stmt = oci_parse($dbconn, $getPlateNumQuery);
            oci_bind_by_name($stmt, ":reservation_id", $reservation_id);

            if (!oci_execute($stmt)) {
                throw new Exception("Failed to retrieve plate number.");
            }

            $row = oci_fetch_assoc($stmt);
            if ($row) {
                $plate_num = $row['PLATE_NUM'];

                // Update the car status to "in rent"
                $updateCarQuery = "UPDATE car SET status = 'in rent' WHERE plate_num = :plate_num";
                $stmt = oci_parse($dbconn, $updateCarQuery);
                oci_bind_by_name($stmt, ":plate_num", $plate_num);

                if (!oci_execute($stmt, OCI_NO_AUTO_COMMIT)) {
                    throw new Exception("Failed to update car status.");
                }

                // Commit the transaction
                oci_commit($dbconn);

                echo '<script>alert("Payment Successful!");</script>';
                header("Location: receipt.php?reservation_id=$reservation_id&payment_id=$payment_id&total=$total");
                exit();
            } else {
                throw new Exception("Plate number not found for the reservation.");
            }
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            oci_rollback($dbconn);
            echo "Error: " . $e->getMessage();
        } finally {
            // Close the database connection
            oci_close($dbconn);
        }
        ?>
    </center>
</body>
</html>
