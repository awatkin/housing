<?php

echo "<div id='admin_navbar'>";
echo " :: ";

echo "<a href='admin_index.php'> Home </a>";

echo " :: ";

if (!isset($_SESSION["admin_ssnlogin"])) {
    echo "<a href='admin_login.php'> Login </a>";
} else {
//    if super
    if ($_SESSION["priv"] == "SUPER") {
        echo "<a href='add_staff.php'> Add Staff </a>";
        echo " :: ";
    }
    if ($_SESSION["priv"] != "EDITOR") {
        echo "<a href='add_booking.php'> Add Booking </a>";
        echo " :: ";

    }
    echo "<a href='update_staff.php'> Update Staff Details</a>";
    echo " :: ";
}
// everyone
echo "<a href='../logout.php'> Logout </a>";
echo " :: ";
echo "</div>";