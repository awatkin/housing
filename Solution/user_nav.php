<?php

echo "<div id='user_navbar'>";
echo " :: ";

echo "<a href='index.php'> Home </a>";

echo " :: ";
if (isset($_SESSION["user_ssnlogin"])) {
    echo "<a href='logout.php'> Logout </a>";
    echo " :: ";
    echo "<a href='book_appointment.php'> Book Appointment </a>";
    echo " :: ";
    echo "<a href='check_appointment.php'> Book Hotel Room </a>";
    echo " :: ";
    echo "<a href='change_appointment.php'> Book Hotel Room </a>";
    echo " :: ";

} else {
    echo "<a href='login.php'> Login </a>";
    echo " :: ";
    echo "<a href='user_reg.php'> Register </a>";
    echo " :: ";
}



// everyone

echo "</div>";