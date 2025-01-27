<?php
// Assuming you have a database connection established
require_once('../../testdatabase.php'); // Ensure this uses oci_connect to establish the Oracle connection

$username = $_REQUEST['username'];
$email = $_REQUEST['email'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$phone_num = $_REQUEST['phone_num'];
$address = $_REQUEST['address'];
$gender = $_REQUEST['gender'];
$password = $_REQUEST['password'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the username or email already exists
$query = "SELECT 1 FROM customers WHERE email = :email OR username = :username";
$statement = oci_parse($dbconn, $query);

// Bind parameters to prevent SQL injection
oci_bind_by_name($statement, ':email', $email);
oci_bind_by_name($statement, ':username', $username);

oci_execute($statement);

if (oci_fetch($statement)) {
    // Email or username already taken, display an error message
    echo '<script>alert("Email or username already taken."); window.location.href = "add.php";</script>';
} else {
    // Username or email is available, insert the new user into the database
    $insertQuery = "INSERT INTO customers (username, email, first_name, last_name, phone_num, address, gender, password) 
                    VALUES (:username, :email, :first_name, :last_name, :phone_num, :address, :gender, :hashed_password)";
    $insertStatement = oci_parse($dbconn, $insertQuery);

    // Bind parameters to prevent SQL injection
    oci_bind_by_name($insertStatement, ':username', $username);
    oci_bind_by_name($insertStatement, ':email', $email);
    oci_bind_by_name($insertStatement, ':first_name', $first_name);
    oci_bind_by_name($insertStatement, ':last_name', $last_name);
    oci_bind_by_name($insertStatement, ':phone_num', $phone_num);
    oci_bind_by_name($insertStatement, ':address', $address);
    oci_bind_by_name($insertStatement, ':gender', $gender);
    oci_bind_by_name($insertStatement, ':hashed_password', $hashed_password);

    // Execute the insert query
    if (oci_execute($insertStatement)) {
        // User registered successfully, redirect to index.php
        echo '<script>alert("New user was added successfully."); window.location.href = "../admin customer.php";</script>';
        exit();
    } else {
        // Error occurred while registering the user, display an error message
        $e = oci_error($insertStatement); // Get the error details
        echo "Error registering the user: " . $e['message'];
    }

    oci_free_statement($insertStatement); // Free the insert statement resource
}

oci_free_statement($statement); // Free the select statement resource
oci_close($dbconn); // Close the database connection
?>
