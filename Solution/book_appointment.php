<?php

session_start();

require_once "common_functions.php";
require_once "db_connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    foreach($_POST as $bits){
        echo $bits;
        echo "<br>";
    }
//    $result = valid_appointment(dbconnect(),$_POST);
//    if($result="wrongstaff"){
//        $_SESSION['message'] = "That member of staff cannot complete that appointment type";
//        header("Location: book_appointment.php");
//        exit;
//    }

}

echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";
echo "<link rel='stylesheet' href='styles.css'>";
echo "<title> Housing</title>";
echo "</head>";

echo "<body>";

echo "<div id='container'>";

include_once "title.php";

include 'user_nav.php';

echo "<div id='content'>";

echo "<h4> Book your appointment</h4>";

echo "<br>";
echo usr_error($_SESSION);
echo "<br>";

echo "Choose your booking slot ";
echo "<br>";
echo "<br>";

// create a form for the user to make a booking

echo "<form action='book_appointment.php' method='post'>";

// label for date and time picker

echo "<label for='meeting-time'>Choose a time for your appointment:</label>";
// using the code below, we get a date picker which will only allow appointments from today to 1 week from today
echo "<input type='datetime-local'
  id='meeting-time' name='meeting-time' value=".get_time("current")." min=".get_time("current")." max=".get_time("future")." required />";

echo "<br>";
echo "<br>";
// add booking type (consult or install)
echo "<label for='staff_pick'>Choose an appointment type:</label>";

echo "<select name='staff_pick' required>";

    $staff = get_appt_staff(dbconnect());  // calls function to get the ticket types and their id numbers

    foreach ($staff as $type) {  // uses a loop to display them
        echo "<option value=".$type['staff_id'].">".$type['f_name']." ".$type['s_name']."</option>";  // sets the ticket id as the "value" to be able to use it later, but displays the ticket type text
    }
    echo "</select>";
echo "<br>";
echo "<br>";

echo "<label for='apt_pick'>Choose an appointment type:</label>";
echo "<select name='apt-pick' required>";
echo "<option value='INSTALLER'> Installation </option>";
echo "<option value='CONSULTANT'> Consultation </option>";
echo "</select>";

echo "<br>";
echo "<br>";
// add staff picker (with type of installation that they do
echo "<input type='submit' name='submit' value='Book'>";

echo "</form>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";