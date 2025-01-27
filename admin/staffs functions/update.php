<?php
// Assuming you have a database connection established
require_once('../../testdatabase.php');

if (isset($_POST['ic'])) {
  $ic = $_POST['ic'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone_num = $_POST['phone_num'];
  $address = $_POST['address'];
  $role = $_POST['role'];
  $salary = $_POST['salary'];
  $gender = $_POST['gender'];

  // Update the staff information in the database
  $query = "UPDATE staff SET name = :name, email = :email, phone_num = :phone_num, address = :address, role = :role, salary = :salary, gender = :gender WHERE ic = :ic";
  $stid = oci_parse($dbconn, $query);

  // Bind parameters to the query
  oci_bind_by_name($stid, ":name", $name);
  oci_bind_by_name($stid, ":email", $email);
  oci_bind_by_name($stid, ":phone_num", $phone_num);
  oci_bind_by_name($stid, ":address", $address);
  oci_bind_by_name($stid, ":role", $role);
  oci_bind_by_name($stid, ":salary", $salary);
  oci_bind_by_name($stid, ":gender", $gender);
  oci_bind_by_name($stid, ":ic", $ic);

  // Execute the query
  $result = oci_execute($stid);

  // Check if the update was successful
  if ($result) {
    // Success message or redirection to a success page
    echo '<script>alert("Successfully updated staff information."); window.location.href = "../admin staff.php";</script>';
  } else {
    // Error message or redirection to an error page
    echo '<script>alert("Failed to update staff information."); window.location.href = "../admin staff.php";</script>';
  }

  // Free the statement
  oci_free_statement($stid);
} else {
  echo "Invalid request.";
}

// Close the connection
oci_close($dbconn);
?>
