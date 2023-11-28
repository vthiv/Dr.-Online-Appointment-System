<?php

$server = "localhost";
$username ="root"; //mysql username
$password ="123"; 	//<PASSWORD> password
$database = "app_booking";

$connection = mysqli_connect("$server", "$username", "$password", "$database");
$select_db = mysqli_select_db($connection, $database);

if(!$select_db)
{
    echo("connection terminated");
}

?>


