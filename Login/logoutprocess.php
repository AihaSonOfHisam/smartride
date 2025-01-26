<html>
<head>
<title>Log Out</title>
</head>

<body>

<?php
session_start();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: Login.html");
exit();
?>

</body>
</html>
