<?php
// Assuming you have a database connection established
require_once('../../testdatabase.php');

if (isset($_GET['ic'])) {
  $ic = $_GET['ic'];

  // Delete the staff from the database
  $query = "DELETE FROM staff WHERE ic = :ic";
  $stid = oci_parse($dbconn, $query);

  // Bind the :ic parameter to the value
  oci_bind_by_name($stid, ":ic", $ic);

  // Execute the query
  $result = oci_execute($stid);

  // Check if the deletion was successful
  if ($result) {
    // Success message or redirection to a success page
    echo '<script>alert("Staff deleted successfully."); window.location.href = "../admin staff.php";</script>';
  } else {
    // Error message or redirection to an error page
    $error = oci_error($stid);
    echo '<script>alert("Failed to delete staff. Error: ' . $error['message'] . '"); window.location.href = "../admin staff.php";</script>';
  }

  // Free the statement
  oci_free_statement($stid);
} else {
  echo "Invalid request.";
}

// Close the connection
oci_close($dbconn);
?>
