<html>
<head>
<title>Log Out</title>
</head>

<body>

<?php
session_start();

 echo '<script>
        var confirmed = confirm("Are you sure you want to log out?");
        if (confirmed) {
            ' . "window.location.href = 'logoutprocess.php';" . '
        } else {
            // User canceled, redirect back to the main page
            ' . "window.location.href = '../index.php';" . '
        }
    </script>';
?>

</body>
</html>