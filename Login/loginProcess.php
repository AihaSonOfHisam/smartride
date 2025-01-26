<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <center>

    <?php
    require_once('../testdatabase.php'); // Ensure this file contains the correct Oracle DB connection setup

    // Retrieve form data
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $loginType = $_REQUEST['login'];

    if ($loginType === "user") {
        // Query for customers
        $query = "SELECT * FROM customers WHERE username = :username AND password = :password";
        $statement = oci_parse($dbconn, $query);

        // Bind parameters to prevent SQL injection
        oci_bind_by_name($statement, ":username", $username);
        oci_bind_by_name($statement, ":password", $password);

        // Execute the query
        oci_execute($statement);

        if ($row = oci_fetch_assoc($statement)) {
            // User exists and credentials are valid, set session variables
            session_start();
            $_SESSION['username'] = $username;
            
            // Redirect to the user homepage
            header("Location: ../index.php");
            exit();
        } else {
            // User does not exist or invalid credentials, display an error message
            echo '<script>alert("Invalid username or password!"); window.location.href = "Login.html";</script>';
        }

        oci_free_statement($statement); // Free resources
    } elseif ($loginType === "admin") {
        // Query for admin
        $query = "SELECT * FROM admin WHERE username = :username AND password = :password";
        $statement = oci_parse($dbconn, $query);

        // Bind parameters to prevent SQL injection
        oci_bind_by_name($statement, ":username", $username);
        oci_bind_by_name($statement, ":password", $password);

        // Execute the query
        oci_execute($statement);

        if ($row = oci_fetch_assoc($statement)) {
            // Admin exists and credentials are valid, set session variables
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['loginType'] = $loginType;
            
            // Redirect to the admin dashboard
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            // Admin does not exist or invalid credentials, display an error message
            echo '<script>alert("Invalid username or password!"); window.location.href = "Login.html";</script>';
        }

        oci_free_statement($statement); // Free resources
    }

    // Close the Oracle connection
    oci_close($dbconn);
    ?>

    </center>
</body>
</html>
