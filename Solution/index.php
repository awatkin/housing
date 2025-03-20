<?php
session_start();

require_once "common_functions.php";

echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";
echo "<link rel='stylesheet' href='styles.css'>";
echo "<title> rolsa</title>";
echo "</head>";

echo "<body>";

echo "<div id='container'>";

include_once "title.php";

include 'user_nav.php';

echo "<div id='content'>";

echo "<h4> Hello and Welcome to the EV Website</h4>";

echo "<br>";
echo usr_error();
echo "<br>";

echo "Use the links above to complete the tasks needed. ";
echo "<br>";
echo "<br>";

echo "Hello there";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";