<?php
$WEATHER_API_KEY = "6e7bc156ddf0165f9cea962f15c3ead2";
$base_url_weather = 'https://api.openweathermap.org/data/2.5/';
$endpoint = $_GET['endpoint'];
$params = $_SERVER['QUERY_STRING'];

if ($endpoint === 'weather') {
  $url = $base_url_weather . $endpoint . '?' . $params . '&appid=' . $WEATHER_API_KEY;
  $response = file_get_contents($url);
  if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch weather data.']);
  } else {
    header('Content-Type: application/json');
    echo $response;
  }
} else {
  http_response_code(404);
  echo json_encode(['error' => 'Invalid endpoint.']);
}
?>
