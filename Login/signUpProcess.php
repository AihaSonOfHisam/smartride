<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
    <center>
        <?php
        require_once('../testdatabase.php'); // Ensure this file contains your Oracle DB connection as $dbconn

        // Retrieve and sanitize input
        $username = htmlspecialchars(trim($_REQUEST['username']));
        $email = htmlspecialchars(trim($_REQUEST['email']));
        $first_name = htmlspecialchars(trim($_REQUEST['first_name']));
        $last_name = htmlspecialchars(trim($_REQUEST['last_name']));
        $phone_num = htmlspecialchars(trim($_REQUEST['phone_num']));
        $address = htmlspecialchars(trim($_REQUEST['address']));
        $gender = htmlspecialchars(trim($_REQUEST['gender']));
        $password = htmlspecialchars(trim($_REQUEST['password']));

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if the username or email already exists
        $checkQuery = "SELECT COUNT(*) AS COUNT FROM customers WHERE email = :email OR username = :username";
        $stmt = oci_parse($dbconn, $checkQuery);
        oci_bind_by_name($stmt, ':email', $email);
        oci_bind_by_name($stmt, ':username', $username);
        oci_execute($stmt);

        $row = oci_fetch_assoc($stmt);

        if ($row['COUNT'] > 0) {
            // Email or username already taken
            echo '<script>alert("Email or username already taken."); window.location.href = "SignupUser.html";</script>';
        } else {
            // Insert the new user into the database
            $insertQuery = "INSERT INTO customers (username, email, first_name, last_name, phone_num, address, gender, password)
                            VALUES (:username, :email, :first_name, :last_name, :phone_num, :address, :gender, :hashed_password)";
            $insertStmt = oci_parse($dbconn, $insertQuery);

            // Bind parameters
            oci_bind_by_name($insertStmt, ':username', $username);
            oci_bind_by_name($insertStmt, ':email', $email);
            oci_bind_by_name($insertStmt, ':first_name', $first_name);
            oci_bind_by_name($insertStmt, ':last_name', $last_name);
            oci_bind_by_name($insertStmt, ':phone_num', $phone_num);
            oci_bind_by_name($insertStmt, ':address', $address);
            oci_bind_by_name($insertStmt, ':gender', $gender);
            oci_bind_by_name($insertStmt, ':hashed_password', $hashed_password);

            $insertResult = oci_execute($insertStmt);

            if ($insertResult) {
                // Commit the transaction and start session
                oci_commit($dbconn);
                session_start();
                $_SESSION['username'] = $username;
                header("Location: ../index.php");
                exit();
            } else {
                // Error occurred while registering the user
                $error = oci_error($insertStmt);
                echo "Error registering the user: " . $error['message'];
            }
        }

        // Free resources and close the connection
        oci_free_statement($stmt);
        oci_free_statement($insertStmt);
        oci_close($dbconn);
        ?>
    </center>
</body>
</html>
