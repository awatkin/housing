<?php

// function to compare 2 passwords to ensure they match
function pwrd_checker($pass, $cpass) {  //takes in 2 parameters

    if($pass!=$cpass){  // do the passwords not match
        return false; // return false
    }
    elseif(strlen($pass)<8){  // is the password long enough?
        return false;
    }
    else{
        return true;
    }
}

function usr_error(&$session){

    if(isset($session['ERROR'])){  // checks for the session variable being set with an error
        $error = 'ERROR: '. $session['ERROR'];  //echos out the stored error from session
        $session['ERROR'] = "";
        unset($session['ERROR']);  //
        return $error;
    }
    elseif(isset($session['SUCCESS'])){  // checks for the session variable being set with an error
        $success = 'SUCCESS: '. $session['SUCCESS'];  //echos out the stored error from session
        $session['SUCCESS'] = "";
        unset($session['SUCCESS']);  //
        return $success;
    }
    else {
        return "";
    }
}

function only_user($conn, $username){
    try {
        $sql = "SELECT email FROM user WHERE email = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->bindParam(1, $username);
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    catch (PDOException $e) { //catch error
        // Log the error (crucial!)
        error_log("Database error in only_user: " . $e->getMessage());
        // Throw the exception
        throw $e; // Re-throw the exception
    }
}

function reg_user($conn,$post){
    if (!isset($post['email'], $post['password'], $post['fname'], $post['sname'])) {
        throw new Exception("Missing required fields.");
    } else{
        try {
            // Prepare and execute the SQL query
            $sql = "INSERT INTO user (f_name, s_name, addressln1, addressln2, city, postcode, email, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";  //prepare the sql to be sent
            $stmt = $conn->prepare($sql); //prepare to sql

            $stmt->bindParam(1, $post['fname']);  //bind parameters for security
            $stmt->bindParam(2, $post['sname']);  //bind parameters for security
            $stmt->bindParam(3, $post['addressln1']);  //bind parameters for security
            if(!isset($post['addressln2'])){
                $stmt->bindParam(4, " ");
            } else {
                $stmt->bindParam(4, $post['addressln2']);  //bind parameters for security
            }
            $stmt->bindParam(5, $post['city']);  //bind parameters for security
            $stmt->bindParam(6, $post['postcode']);  //bind parameters for security
            $stmt->bindParam(7, $post['email']);  //bind parameters for security
            $stmt->bindParam(8, $post['phone']);  //bind parameters for security

            // Hash the password
            $hpswd = password_hash($post['password'], PASSWORD_DEFAULT);  //has the password
            $stmt->bindParam(9, $hpswd);

            $stmt->execute();  //run the query to insert
            $conn = null;  // closes the connection so cant be abused.
            return true; // Registration successful
        }  catch (PDOException $e) {
            // Handle database errors
            error_log("User Reg Database error: " . $e->getMessage()); // Log the error
            throw new Exception("User Reg Database error". $e); //Throw exception for calling script to handle.
        } catch (Exception $e) {
            // Handle validation or other errors
            error_log("User Registration error: " . $e->getMessage()); //Log the error
            throw new Exception("User Registration error: " . $e->getMessage()); //Throw exception for calling script to handle.
        }
    }

}

function validlogin($conn, $email){

    $sql = "SELECT * FROM user WHERE email = ?"; //set up the sql statement
    $stmt = $conn->prepare($sql); //prepares
    $stmt->bindParam(1,$email);  //binds the parameters to execute
    $stmt->execute(); //run the sql code
    $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
    $conn = null;  // nulls off the connection so cant be abused.


}