<?php
session_start();

require_once 'db_connect.php';
require_once 'common_functions.php';

if (isset($_SESSION['user_ssnlogin'])){
    $_SESSION['ERROR'] = "You are already logged in!";
    header("Location: index.php");
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){  // if superuser doesn't exist and posted to this page
    try {  //try this code, catch errors




        if(validlogin(dbconnect(),$_POST)){  // if there is a result returned

            if (password_verify($_POST["password"], $result["password"]) && auditor(dbconnect_insert(), $_POST['username'], $short_code, $long_code)) { // verifies the password is matched
                $_SESSION["user_ssnlogin"] = true;  // sets up the session variables
                $_SESSION['user_id'] = get_userid(dbconnect_select(),$_POST);
                $_SESSION["username"] = $_POST['username'];
                $_SESSION["user_type_id"] = $result["user_type_id"];
                $_SESSION['SUCCESS'] = "User Successfully Logged In";
                header("location:index.php");  //redirect on success
                exit();

            } else{
                $_SESSION['ERROR'] = "User login passwords not match";
                header("Location: user_login.php");
                exit; // Stop further execution
            }

        } else {
            $_SESSION['ERROR'] = "User not found";
            header("Location: user_login.php");
            exit; // Stop further execution

        }

    } catch (Exception $e) {
        $_SESSION['ERROR'] = "User login".$e->getMessage();
        header("Location: user_login.php");
        exit; // Stop further execution
    }
}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";

    echo "<link rel='stylesheet' href='styles.css'>";

    echo "<title> RZL User Login</title>";

    echo "</head>";

    echo "<body>";

    echo "<div id='list container'>";

    echo "<div id='title'>";

    echo "<h3 id='banner'>RZL User System</h3>";

    echo "</div>";

    echo "<div id='content'>";

    echo "<h4> User Login</h4>";

    echo "<br>";

    echo usr_error($_SESSION);

    echo "<form method='post' action='user_login.php'>";

    echo "<input type='text' name='username' placeholder='Username' required><br>";

    echo "<input type='password' name='password' placeholder='Password' required><br>";

    echo "<input type='submit' name='submit' value='Login'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}