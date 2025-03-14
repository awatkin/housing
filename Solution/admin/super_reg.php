<?php
session_start();  // connects with or starts a session if not already existing

require_once '../db_connect.php';  // include once the db connect functions

require_once 'admin_functions.php';  // include ones the admin functions


if (super_checker(dbconnect())) {  // calls function in admin_functs to check if superuser exists.
    $_SESSION['ERROR'] = "ADMIN ALREADY EXISTS, LOGIN or ASK FOR to be registered";  // sets the error session variable to be read out by the next page
    header('location: admin_login.php');  // redirects to the needed new page.
    exit;
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){  // if superuser doesn't exist and posted to this page
    try {
        if(reg_admin(dbconnect(),$_POST)) { // Assuming $conn is your database connection
            $_SESSION['SUCCESS'] = "ADMIN REGISTERED";
            header("Location: admin_login.php");
            exit; // Stop further execution
        } else {
            $_SESSION['ERROR'] = "SUPER FAIL, UNKNOWN ERROR";
            header("Location: one_time_super.php");
            exit; // Stop further execution
        }
    }
    catch(Exception $e) {
        // Handle database error within reg_admin or here.
        $_SESSION['ERROR'] = "SUPER REG ERROR: ". $e->getMessage();
        header("Location: one_time_super.php");
        exit; // Stop further execution
    }
}

echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";

echo "<link rel='stylesheet' href='admin_styles.css'>";

echo "<title> Super Admin Reg</title>";

echo "</head>";

echo "<body>";

echo "<div id='container'>";

include_once "../title.php";

include_once "nav.php";

echo "<div id='content'>";

echo admin_error($_SESSION);

echo "<h4> Super Admin registration </h4>";

echo "<br>";

echo "<form method='post' action='super_reg.php'>";

echo "<input type='text' name='email' placeholder='Email' required><br>";

echo "<input type='password' name='password' placeholder='Password' required><br>";

echo "<input type='password' name='cpassword' placeholder='Confirm Password' required><br>";

echo "<input type='hidden' name='priv' value='SUPER'><br>";

echo "<input type='submit' name='submit' value='Register'>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";