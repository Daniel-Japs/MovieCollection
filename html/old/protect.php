<?php 
include_once 'db_conn.php';

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
<h2>Login</h2>

<?php

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	echo 'Bitte melde dich mit deinen Zugangsdaten an.';
}

?>
<form action="" method="post">

    <label for="username">Username:</label><br>
    <input type="text" id="username" maxlength="250" name="username"><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" maxlength="250" name="password"><br><br>

    <input type="submit" value="Login">
</form>
<?php if (isset($_GET['error'])) { ?>
    <p class="error"><?php echo $_GET['error']; ?></p>
<?php } ?>
</body>
</html>
<?php
exit();
?>
