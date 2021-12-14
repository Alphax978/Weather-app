<?php

// sets the time according to given location
date_default_timezone_set('Asia/KATHMANDU');


// Selects weather data for given parameters
$sql = "SELECT *FROM weathers WHERE city = '{$_GET['city']}' AND weather_when >= DATE_SUB(NOW(), INTERVAL 10 SECOND) ORDER BY weather_when DESC limit 1";
$result = $mysqli -> query($sql);


// On findng zero records
if ($result->num_rows == 0) {
  $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $_GET['city'] . '&appid=202fa1cd0ae29680eeda83a529ec06e0&units=metric';


  // Reteives the  data from openweathermap and stores in JSON object
  $data = file_get_contents($url);
  $json = json_decode($data, true);

  // Fetches the data
  $weather_description = $json['weather'][0]['description'];
  $weather_temperature = $json['main']['temp'];
  $weather_windspeed = $json['wind']['speed'];
  $weather_when = date("Y-m-d H:i:s"); // now
  $city = $json['name'];
  $weather_humidity = $json['main']['humidity'];
  $weather_pressure = $json['main']['pressure'];


  // Inserts the data in created table which is weathers
  $sql = "INSERT INTO  weathers(weather_description, weather_temperature, weather_windspeed, weather_when, city, weather_humidity, weather_pressure)
  VALUES('{$weather_description}', {$weather_temperature}, {$weather_windspeed},'{$weather_when}','{$city}', {$weather_humidity}, {$weather_pressure})";

  // Runs SQL statement and report errors
  if (!$mysqli -> query($sql)) {
  echo("<h4>Error encountered in SQL: " . $mysqli -> error . "</h4>");
  }
}
?>
