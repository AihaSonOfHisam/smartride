<?php
// Assuming you have a database connection established
require_once('../../testdatabase.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $plateNumber = $_POST['plate_number'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $colour = $_POST['colour'];
    $type = $_POST['type'];
    $seats = $_POST['seats'];
    $transmission = $_POST['transmission'];
    $pricePerDay = $_POST['price_per_day'];
    $pricePerWeek = $_POST['price_per_week'];
    $pricePerMonth = $_POST['price_per_month'];
    $status = $_POST['status'];

    // Check if the plate number already exists
    $checkQuery = "SELECT COUNT(*) FROM car WHERE plate_num = :plate_num";
    $checkStid = oci_parse($dbconn, $checkQuery);
    oci_bind_by_name($checkStid, ":plate_num", $plateNumber);

    // Execute the query to check if the plate number exists
    oci_execute($checkStid);
    oci_fetch($checkStid);
    $count = oci_result($checkStid, 1);

    if ($count > 0) {
        // Plate number already exists, show an alert
        echo '<script>alert("This plate number already exists. Please use a different one."); window.location.href = "add.php";</script>';
    } else {
        // Prepare and execute the SQL query using bind variables for security
        $query = "INSERT INTO car (plate_num, brand, model, colour, type, seat_num, transmission, price_per_day, price_per_week, price_per_month, status) 
                  VALUES (:plate_num, :brand, :model, :colour, :type, :seat_num, :transmission, :price_per_day, :price_per_week, :price_per_month, :status)";

        // Prepare the statement
        $stid = oci_parse($dbconn, $query);

        // Bind variables
        oci_bind_by_name($stid, ":plate_num", $plateNumber);
        oci_bind_by_name($stid, ":brand", $brand);
        oci_bind_by_name($stid, ":model", $model);
        oci_bind_by_name($stid, ":colour", $colour);
        oci_bind_by_name($stid, ":type", $type);
        oci_bind_by_name($stid, ":seat_num", $seats);
        oci_bind_by_name($stid, ":transmission", $transmission);
        oci_bind_by_name($stid, ":price_per_day", $pricePerDay);
        oci_bind_by_name($stid, ":price_per_week", $pricePerWeek);
        oci_bind_by_name($stid, ":price_per_month", $pricePerMonth);
        oci_bind_by_name($stid, ":status", $status);

        // Execute the query
        if (oci_execute($stid)) {
            // Car details inserted successfully
            echo '<script>alert("Successfully added new car information."); window.location.href = "../admin car list.php";</script>';
        } else {
            // Error occurred while inserting car details
            $error = oci_error($stid);
            echo "Error: " . $error['message'];
        }

        // Close the Oracle statement
        oci_free_statement($stid);
    }

    // Close the Oracle statement and connection
    oci_free_statement($checkStid);
    oci_close($dbconn);
}
?>
