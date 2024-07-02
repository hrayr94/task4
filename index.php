<?php

$api_key = '03b234130a743444a38c212a4233c4dd';
$city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : 'london';  // Default city is 'london'
$api = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$api_key}&units=metric";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $api);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$resp = curl_exec($curl);
curl_close($curl);

$data = json_decode($resp, true);

$error = '';

if ($data['cod'] == 200) {
    $temp = $data['main']['temp'];
    $description = $data['weather'][0]['description'];
    $humidity = $data['main']['humidity'];
    $windSpeed = $data['wind']['speed'];
} else {
    $error = 'Unable to fetch weather data. Please try another city.';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .weather-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .weather-detail {
            margin: 10px 0;
        }
        .error {
            color: red;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 200px;
            margin-right: 10px;
        }
        .search-form input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .search-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="weather-container">
    <h2>Weather Information</h2>
    <form class="search-form" method="post" action="">
        <input type="text" name="city" placeholder="Enter city" value="<?= htmlspecialchars($city) ?>">
        <input type="submit" value="Get Weather">
    </form>
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php else: ?>
        <div class="weather-detail">City: <?= htmlspecialchars($city) ?></div>
        <div class="weather-detail">Temperature: <?= htmlspecialchars($temp) ?>°C</div>
        <div class="weather-detail">Description: <?= htmlspecialchars($description) ?></div>
        <div class="weather-detail">Humidity: <?= htmlspecialchars($humidity) ?>%</div>
        <div class="weather-detail">Wind Speed: <?= htmlspecialchars($windSpeed) ?> m/s</div>
    <?php endif; ?>
</div>
</body>
</html>
