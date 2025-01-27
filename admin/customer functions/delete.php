<?php
require_once('../../testdatabase.php'); // Ensure this connects using oci_connect()

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Disable foreign key checks (Oracle doesn't have this option like MySQL, 
    // so you may need to disable constraints manually if necessary)

    // Build the SQL query
    $query = "DELETE FROM customers WHERE username = :username";

    $statement = oci_parse($dbconn, $query);
    oci_bind_by_name($statement, ':username', $username);

    // Execute the query
    $result = oci_execute($statement);

    // Check if the deletion was successful
    if ($result) {
        // Success message or redirection to a success page
        echo '<script>alert("User was deleted successfully!."); window.location.href = "../admin customer.php";</script>';
    } else {
        $e = oci_error($statement);
        // Error message or redirection to an error page
        echo "Failed to delete customer: " . $e['message'];
    }

    // Free the statement
    oci_free_statement($statement);
} else {
    // Handle the case when no username is provided in the URL parameter
    echo "Invalid request.";
}

// Close the connection
oci_close($dbconn);
?>
