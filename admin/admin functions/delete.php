<?php
require_once('./connectdb.php');

// Check if the admin ID is provided via GET request
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Delete the admin from the database
    $query = "DELETE FROM admin WHERE username='$username'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Admin deleted successfully."); window.location.href = "../admin admins.php";</script>';
    } else {
        echo "Failed to delete the admin.";
    }
} else {
    echo "Admin ID not provided.";
}
?>
