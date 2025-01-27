<?php
// Assuming you have a database connection established
require_once('../../testdatabase.php');

$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$phone_num = $_REQUEST['phone_num'];
$ic = $_REQUEST['ic'];
$address = $_REQUEST['address'];
$role = $_REQUEST['role'];
$salary = $_REQUEST['salary'];
$gender = $_REQUEST['gender'];

// Check if the username or email already exists
$query = "SELECT * FROM staff WHERE email = :email OR name = :name";
$stid = oci_parse($dbconn, $query);

// Bind variables
oci_bind_by_name($stid, ":email", $email);
oci_bind_by_name($stid, ":name", $name);

// Execute the query
oci_execute($stid);

// Check if the email or name already exists
if (oci_fetch_all($stid, $result) > 0) {
  // Email or username already taken, display an error message
  echo '<script>alert("Email or username already taken."); window.location.href = "add.php";</script>';
} else {
  // Username or email is available, insert the new staff member into the database
  $insertQuery = "INSERT INTO staff (name, email, phone_num, ic, address, role, salary, gender) 
                  VALUES (:name, :email, :phone_num, :ic, :address, :role, :salary, :gender)";
  $insertStid = oci_parse($dbconn, $insertQuery);

  // Bind variables for insertion
  oci_bind_by_name($insertStid, ":name", $name);
  oci_bind_by_name($insertStid, ":email", $email);
  oci_bind_by_name($insertStid, ":phone_num", $phone_num);
  oci_bind_by_name($insertStid, ":ic", $ic);
  oci_bind_by_name($insertStid, ":address", $address);
  oci_bind_by_name($insertStid, ":role", $role);
  oci_bind_by_name($insertStid, ":salary", $salary);
  oci_bind_by_name($insertStid, ":gender", $gender);

  // Execute the insertion query
  $insertResult = oci_execute($insertStid);

  if ($insertResult) {
    // Staff member added successfully, redirect to admin staff page
    echo '<script>alert("New staff member was added successfully."); window.location.href = "../admin staff.php";</script>';
    exit();
  } else {
    // Error occurred while adding the staff member, display an error message
    $error = oci_error($insertStid);
    echo "Error adding the staff member: " . $error['message'];
  }

  // Free the statement resource for insertion
  oci_free_statement($insertStid);
}

// Free the statement resource for checking existing email/username
oci_free_statement($stid);

// Close the connection
oci_close($dbconn);
?>
