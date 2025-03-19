<?php
session_start();

require_once 'db_connect.php';
require_once 'common_functions.php';

if (isset($_SESSION['user_id'])){
    $_SESSION['ERROR'] = "You are already logged in!";
    header("Location: index.php");
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){  // if superuser doesn't exist and posted to this page
    try {  //try this code, catch errors

        if(validlogin(dbconnect(),$_POST['email'])){  // if there is a result returned

            if (pswdcheck(dbconnect(), $_POST['email'])) { // verifies the password is matched
                $_SESSION['user_id'] = get_userid(dbconnect(),$_POST);
                $_SESSION["email"] = $_POST['email'];
                $_SESSION['SUCCESS'] = "User Successfully Logged In";
                header("location:index.php");  //redirect on success
                exit();

            } else{
                $_SESSION['ERROR'] = "User login passwords not match";
                header("Location: login.php");
                exit; // Stop further execution
            }

        } else {
            $_SESSION['ERROR'] = "User not found";
            header("Location: login.php");
            exit; // Stop further execution

        }

    } catch (Exception $e) {
        $_SESSION['ERROR'] = "User login".$e->getMessage();
        header("Location: login.php");
        exit; // Stop further execution
    }
}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";

    echo "<link rel='stylesheet' href='styles.css'>";

    echo "<title> User Login</title>";

    echo "</head>";

    echo "<body>";

    echo "<div id='list container'>";

    include_once "title.php";

    include 'user_nav.php';

    echo "<div id='content'>";

    echo "<h4> User Login</h4>";

    echo "<br>";

    echo usr_error();

    echo "<form method='post' action='login.php'>";

    echo "<input type='text' name='email' placeholder='E-mail' required><br>";

    echo "<input type='password' name='password' placeholder='Password' required><br>";

    echo "<input type='submit' name='submit' value='Login'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}