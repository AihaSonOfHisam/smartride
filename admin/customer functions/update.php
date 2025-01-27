<?php
// Assuming you have a database connection established
require_once('../../testdatabase.php'); // Ensure this file sets up the Oracle connection in $connection

if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name'];
  $email = $_POST['email'];
}

if (isset($_POST['ic'])) {
  $ic = $_POST['ic'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phoneNumber = $_POST['phone_num'];
  $address = $_POST['address'];
  $role = $_POST['role'];
  $salary = $_POST['salary'];
  $gender = $_POST['gender'];

  // Update the customers information in the Oracle database
  $query = "UPDATE customers 
            SET name = :name, 
                email = :email, 
                phone_num = :phone_num, 
                address = :address, 
                role = :role, 
                salary = :salary, 
                gender = :gender 
            WHERE ic = :ic";
  
  $statement = oci_parse($connection, $query);
  
  // Bind variables to the placeholders
  oci_bind_by_name($statement, ":name", $name);
  oci_bind_by_name($statement, ":email", $email);
  oci_bind_by_name($statement, ":phone_num", $phoneNumber);
  oci_bind_by_name($statement, ":address", $address);
  oci_bind_by_name($statement, ":role", $role);
  oci_bind_by_name($statement, ":salary", $salary);
  oci_bind_by_name($statement, ":gender", $gender);
  oci_bind_by_name($statement, ":ic", $ic);

  // Execute the query and check if successful
  $result = oci_execute($statement, OCI_COMMIT_ON_SUCCESS);

  if ($result) {
    // Success message or redirection to a success page
    echo '<script>alert("Successfully updated customers information."); window.location.href = "../admin customers.php";</script>';
  } else {
    // Error message or redirection to an error page
    $e = oci_error($statement); // Fetch error details
    echo '<script>alert("Failed to update customers information: ' . htmlentities($e['message']) . '"); window.location.href = "../admin customers.php";</script>';
  }

  // Free the statement
  oci_free_statement($statement);
} else {
  echo "Invalid request.";
}

// Close the connection
oci_close($connection);
?>
