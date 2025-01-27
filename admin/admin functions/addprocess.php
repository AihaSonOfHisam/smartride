<?php
require_once('./connectdb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_num'];
    $ic = $_POST['ic'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Insert the admin data into the database
    $query = "INSERT INTO admin (username, email, phone_num, ic, address, gender, password)
              VALUES ('$name', '$email', '$phoneNumber', '$ic', '$address', '$gender', '$password')";

    $result = mysqli_query($connection, $query);

    if ($result) {
       echo '<script>alert("New admin was added successfully."); window.location.href = "../admin admins.php";</script>';
    } else {
        echo "Failed to add the admin.";
    }
}
?>
