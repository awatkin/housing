<?php

// admin function to get error or success messages and output then, then clear them off
function admin_error(&$session){  // uses passes by reference no by value, so you can edit the session variable data properly

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


// function to check if a super exists or not
function super_checker($conn){
    try {
        $sql = "SELECT priv FROM admin_users WHERE priv = 'SUPER'"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        //$stmt->bindParam(1, "SUPER");
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
        error_log("Database error in super_checker: " . $e->getMessage());
        // Throw the exception
        throw $e; // Re-throw the exception
    }
}


// function to register an admin to the system
function reg_admin($conn, $post) {

    // Validate the post data
    if (!isset($post['email'], $post['password'], $post['priv'])) {
        throw new Exception("Missing required fields.");
    } else{
        try {
            // Prepare and execute the SQL query
            $sql = "INSERT INTO admin_users (email, password, priv) VALUES (?, ?, ?)";  //prepare the sql to be sent
            $stmt = $conn->prepare($sql); //prepare to sql

            $stmt->bindParam(1, $post['email']);  //bind parameters for security
            // Hash the password
            $hpswd = password_hash($post['password'], PASSWORD_DEFAULT);  //has the password
            $stmt->bindParam(2, $hpswd);
            $stmt->bindParam(3, $post['priv']);

            $stmt->execute();  //run the query to insert
            $conn = null;  // closes the connection so cant be abused.
            return true; // Registration successful
        }  catch (PDOException $e) {
            // Handle database errors
            error_log("Database error: " . $e->getMessage()); // Log the error
            throw new Exception("Database error". $e); //Throw exception for calling script to handle.
        } catch (Exception $e) {
            // Handle validation or other errors
            error_log("Registration error: " . $e->getMessage()); //Log the error
            throw new Exception("Registration error: " . $e->getMessage()); //Throw exception for calling script to handle.
        }
    }
}

function reg_staff($conn, $post) {

    // Validate the post data
    if (!isset($post['email'], $post['password'])) {
        throw new Exception("Missing required fields.");
    } else{
        try {
            // Prepare and execute the SQL query
            $sql = "INSERT INTO staff (f_name, s_name, role, email, password, created_on) VALUES (?, ?, ?, ?, ?, ?)";  //prepare the sql to be sent
            $stmt = $conn->prepare($sql); //prepare to sql


            $stmt->bindParam(1, $post['f_name']);  //bind parameters for security
            $stmt->bindParam(2, $post['s_name']);  //bind parameters for security
            $stmt->bindParam(3, $post['role']);  //bind parameters for security
            $stmt->bindParam(4, $post['email']);  //bind parameters for security
            // Hash the password
            $hpswd = password_hash($post['password'], PASSWORD_DEFAULT);  //has the password
            $stmt->bindParam(5, $hpswd);
            $timenow = time();
            $stmt->bindParam(6, $timenow);

            $stmt->execute();  //run the query to insert
            $conn = null;  // closes the connection so cant be abused.
            return true; // Registration successful
        }  catch (PDOException $e) {
            // Handle database errors
            error_log("Database error: " . $e->getMessage()); // Log the error
            throw new Exception("Database error". $e); //Throw exception for calling script to handle.
        } catch (Exception $e) {
            // Handle validation or other errors
            error_log("Registration error: " . $e->getMessage()); //Log the error
            throw new Exception("Registration error: " . $e->getMessage()); //Throw exception for calling script to handle.
        }
    }
}