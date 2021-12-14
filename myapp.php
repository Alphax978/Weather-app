<?php


//does the work of connecting with the given database
$mysqli = new mysqli("localhost","root","","file");
if ($mysqli -> connect_errno) {
echo "Connection Error: " . $mysqli -> connect_error;
exit();
}


//extracts the weather data from dataimport.php file
include("2059734_dataimports.php");


//Executes the sql query
$sql = "SELECT *FROM  weathers WHERE city = '{$_GET['city']}' AND weather_when >= DATE_SUB(NOW(), INTERVAL 10 SECOND) ORDER BY weather_when DESC limit 1";
$result = $mysqli -> query($sql);


//Gets the necessary data, converts it into json and prints
$row = $result -> fetch_assoc();
print json_encode($row);


// Free result set and close connection
$result -> free_result();
$mysqli -> close();
?>
