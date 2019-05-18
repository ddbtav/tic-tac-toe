<?php
session_start();
include_once "functions.php";


if (isset($_POST["submit-logout"])) {
    unset($_SESSION["user"]);
    reset_stats();
    // unset statistics
}

if (isset($_SESSION['user'])) {
    echo "You are logged in as: " . $_SESSION['user'] . ".<br>";
    draw_logout_button();
    draw_proceed_to_settings_button();
} else {
    echo "You are not logged in. <br>";
}

if (isset($_GET['register_error']) && $_GET['register_error'] == "username_taken") {
    $taken_username = $_GET['username'];
    echo "This username ($taken_username) is already taken. Please login or register a new one.<br>";
}

if (isset($_GET['login_error']) && $_GET['login_error'] == "wrong_credentials") {
    $username_entered = $_GET['username'];
    echo "Login failed. Wrong username ($username_entered) or password.<br>";
}

if (isset($_GET['register']) && $_GET['register'] == "success") {
    $username_registered = $_GET['username'];
    echo "Successfully registered \"$username_registered\". Please login.<br>";
}

if (isset($_GET['fail_to_register']) && $_GET['fail_to_register'] == "psw_miss") {
    $username_tried = $_GET['username'];
    echo "Registration failed. Password mismatch for username ($username_tried).<br>";
}


if (isset($_POST["submit-login"])) {
    if (isset($_POST["username"]) && isset($_POST["password"]) && ! empty(($_POST["username"])) && ! empty($_POST["password"])) {
        echo "username is " . $_POST["username"];
        echo "<br>";
        echo "password is " . $_POST["password"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if (checkLoginCredentials($username, $password)) {
            echo "successfully logged in ";
            session_start();
            $_SESSION["user"] = $username;
            // make sure has the name of the project
            reset_stats();
            header("Location: settings.php?login=success");
            exit();
        } else {
            header("Location: index.php?login_error=wrong_credentials&username=$username");
            exit();
        }
    }
}


if (isset($_POST["submit-register"])) {
    if (isset($_POST["username"]) && isset($_POST["password"]) && ! empty(($_POST["username"])) && ! empty($_POST["password"]) && isset($_POST["passwordRe"]) && ! empty(($_POST["passwordRe"]))) {
        echo "username is " . $_POST["username"];
        echo "<br>";
        echo "password is " . $_POST["password"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if ($password != $_POST["passwordRe"]){
            header("Location: index.php?fail_to_register=psw_miss&username=$username");
            exit();
        }
        
        if (username_exists($username)) {
            header("Location: index.php?register_error=username_taken&username=$username");
            exit();
        } else {
            if (insertIntoTable($username, $password)) {
                // echo "succesfully created account ";
                // make sure it is the same project name
                header("Location: index.php?register=success&username=$username");
                exit();
            }
        }
    }
}


?>


<html>
<body>
<h3>Please login or register</h3>


<form method="POST" action="">
	<table>
		<tr>
			<td>Username</td> 
			<td><input type="text" name="username" placeholder="first name" maxlength="10" pattern="(?=.*[A-Za-z0-9]).{5,10}" required> (Letters and numbers only, 5-10 characters.)</td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password" placeholder="password" pattern="(?=.*\d)(?=.*[A-Za-z])(?=.*[$&+,:;=?@#|'.^*()%!-]).{8,}" required> (At least one letter, one number and one special character (&,%,#) at least 8 characters.)</td>
		</tr>
		<tr>
			<td>Reenter password</td>
			<td><input type="password" name="passwordRe" placeholder="password" required></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit-register" value="Register"></td>
		</tr>
	</table>
</form>


<form method="POST" action="">
		<input type="text" name="username" placeholder="username" required> 
		<input type="password" name="password" placeholder="password" required> 
		<input type="submit" value="Login" name="submit-login">
</form>

</body>
</html>
