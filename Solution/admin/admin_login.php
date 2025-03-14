<?php
session_start();

require_once 'admin_functions.php';
require_once '../db_connect.php';

if (isset($_SESSION['admin_ssnlogin'])){
    $_SESSION['ERROR'] = "Admin already logged in";
    header("Location: index.php");
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){  // if superuser doesn't exist and posted to this page
    try {  //try this code, catch errors

        $conn = dbconnect();
        $sql = "SELECT admin_user_id, password, priv FROM admin_users WHERE email = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1,$_POST['email']);  //binds the parameters to execute
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        $conn = null;  // nulls off the connection so cant be abused.

        if($result){  // if there is a result returned

            if (password_verify($_POST["password"], $result["password"])) { // verifies the password is matched
                $_SESSION["admin_ssnlogin"] = true;  // sets up the session variables
                $_SESSION["email"] = $_POST['email'];
                $_SESSION["admin_id"] = $result["admin_user_id"];
                $_SESSION["priv"] = $result["priv"];
                $_SESSION['SUCCESS'] = "Admin Successfully Logged In";
                header("location:index.php");  //redirect on success
                exit();

            } else{
                $_SESSION['ERROR'] = "Admin login passwords not match";
                header("Location: admin_login.php");
                exit; // Stop further execution
            }

        } else {
            $_SESSION['ERROR'] = "Admin user not found";
            header("Location: admin_login.php");
            exit; // Stop further execution

        }

    } catch (Exception $e) {
        $_SESSION['ERROR'] = "Admin login".$e->getMessage();
        header("Location: admin_login.php");
        exit; // Stop further execution
    }
}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";

    echo "<link rel='stylesheet' href='admin_styles.css'>";

    echo "<title> Admin Login</title>";

    echo "</head>";

    echo "<body>";

    echo "<div id='list container'>";

    include_once "../title.php";

    include_once "nav.php";

    echo "<div id='content'>";

    echo "<h4> Admin Login</h4>";

    echo "<br>";

    echo admin_error($_SESSION);

    echo "<form method='post' action='admin_login.php'>";

    echo "<input type='text' name='email' placeholder='email' required><br>";

    echo "<input type='password' name='password' placeholder='Password' required><br>";

    echo "<input type='submit' name='submit' value='Login'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}