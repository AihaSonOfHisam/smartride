<html>
<head>
    <title>Feedback</title>
</head>
<body>
    <center>

    <?php
    require_once('testdatabase.php');

    // Retrieve form data
    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $feedback = $_REQUEST['feedback'];

    // Verify user credentials
    $query = "SELECT * FROM customers WHERE username = :username AND email = :email";
    $stid = oci_parse($dbconn, $query);

    // Bind the parameters
    oci_bind_by_name($stid, ":username", $username);
    oci_bind_by_name($stid, ":email", $email);

    // Execute the query
    oci_execute($stid);

    if (oci_fetch_all($stid, $results) > 0) {
        // User credentials are valid, check if the feedback already exists
        $existingFeedbackQuery = "SELECT * FROM feedback WHERE username = :username";
        $existingFeedbackStid = oci_parse($dbconn, $existingFeedbackQuery);

        // Bind the username parameter
        oci_bind_by_name($existingFeedbackStid, ":username", $username);

        // Execute the existing feedback query
        oci_execute($existingFeedbackStid);

        if (oci_fetch_all($existingFeedbackStid, $existingFeedbackResults) > 0) {
            // Feedback already exists, update it
            $updateQuery = "UPDATE feedback SET feedback = :feedback WHERE username = :username";
            $updateStid = oci_parse($dbconn, $updateQuery);

            // Bind the parameters
            oci_bind_by_name($updateStid, ":feedback", $feedback);
            oci_bind_by_name($updateStid, ":username", $username);

            // Execute the update query
            $updateResult = oci_execute($updateStid);

            if ($updateResult) {
                echo '<script>alert("Feedback updated successfully!"); window.location.href = "index.php";</script>';
            } else {
                echo '<script>alert("Error updating feedback. Please try again."); window.location.href = "feedback.php";</script>';
            }
        } else {
            // Feedback does not exist, insert it as a new entry
            $insertQuery = "INSERT INTO feedback (username, feedback) VALUES (:username, :feedback)";
            $insertStid = oci_parse($dbconn, $insertQuery);

            // Bind the parameters
            oci_bind_by_name($insertStid, ":username", $username);
            oci_bind_by_name($insertStid, ":feedback", $feedback);

            // Execute the insert query
            $insertResult = oci_execute($insertStid);

            if ($insertResult) {
                echo '<script>alert("Feedback submitted successfully!"); window.location.href = "index.php";</script>';
            } else {
                echo '<script>alert("Error submitting feedback. Please try again."); window.location.href = "feedback.php";</script>';
            }
        }
    } else {
        echo '<script>alert("Invalid username or email. Please try again."); window.location.href = "feedback.php";</script>';
    }

    // Free statements
    oci_free_statement($stid);
    oci_free_statement($existingFeedbackStid);
    oci_free_statement($updateStid);
    oci_free_statement($insertStid);
    ?>

    </center>
</body>
</html>
