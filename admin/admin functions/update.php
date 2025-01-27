<?php
// Assuming you have a database connection established
require_once('./connectdb.php');

if (isset($_POST['ic'])) {
  $ic = $_POST['ic'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phoneNumber = $_POST['phone_num'];
  $address = $_POST['address'];
  $role = $_POST['role'];
  $salary = $_POST['salary'];
  $gender = $_POST['gender'];

  // Update the staff information in the database
  $query = "UPDATE staff SET name = '$name', email = '$email', phone_num = '$phoneNumber', address = '$address', role = '$role', salary = '$salary', gender = '$gender' WHERE ic = '$ic'";
  $result = mysqli_query($connection, $query);

  // Check if the update was successful
  if ($result) {
    // Success message or redirection to a success page
    echo '<script>alert("Successfully updated staff information."); window.location.href = "../admin staff.php";</script>';
  } else {
    // Error message or redirection to an error page
    echo '<script>alert("Failed to update staff information."); window.location.href = "../admin staff.php";</script>';
  }
} else {
  echo "Invalid request.";
}

// Close the connection
mysqli_close($connection);
?>
