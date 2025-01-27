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
        // Query to fetch hashed password for the given username
        $query = "SELECT password FROM customers WHERE username = :username";
        $statement = oci_parse($dbconn, $query);

        // Bind parameters to prevent SQL injection
        oci_bind_by_name($statement, ":username", $username);

        // Execute the query
        oci_execute($statement);

        if ($row = oci_fetch_assoc($statement)) {
            // Verify the password with the hashed password from the database
            $hashedPassword = $row['PASSWORD'];
            if (password_verify($password, $hashedPassword)) {
                // Password matches, set session variables
                session_start();
                $_SESSION['username'] = $username;

                // Redirect to the user homepage
                header("Location: ../index.php");
                exit();
            } else {
                // Invalid password
                echo '<script>alert("Invalid username or password!"); window.location.href = "Login.html";</script>';
            }
        } else {
            // Username does not exist
            echo '<script>alert("Invalid username or password!"); window.location.href = "Login.html";</script>';
        }

        oci_free_statement($statement); // Free resources
    } elseif ($loginType === "admin") {
        // Query to fetch hashed password for admin
        $query = "SELECT password FROM admin WHERE username = :username";
        $statement = oci_parse($dbconn, $query);

        // Bind parameters to prevent SQL injection
        oci_bind_by_name($statement, ":username", $username);

        // Execute the query
        oci_execute($statement);

        if ($row = oci_fetch_assoc($statement)) {
            // Verify the password with the hashed password from the database
            $hashedPassword = $row['PASSWORD'];
            if (password_verify($password, $hashedPassword)) {
                // Password matches, set session variables
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['loginType'] = $loginType;

                // Redirect to the admin dashboard
                header("Location: ../admin/dashboard.php");
                exit();
            } else {
                // Invalid password
                echo '<script>alert("Invalid username or password!"); window.location.href = "Login.html";</script>';
            }
        } else {
            // Admin username does not exist
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
