<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <style>
        /* CSS styles for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('cloud.jpg'); /* Replace 'cloud.jpg' with the path to your cloud background image */
            background-size: cover;
        }

        /* Styles for the weather container */
        #weather-container {
            margin-top: 20px;
            text-align: center; /* Center align the content */
        }

        /* Styles for error messages */
        #error-message {
            color: red;
        }

        /* Styles for weather icons */
        .weather-icon {
            width: 50px; 
            height: 50px;
        }

        /* Styles for historical data container */
        #historical-data {
            margin-top: 20px;
            text-align: center; /* Center align the historical data */
        }
    </style>
</head>
<body>

    <h1>Welcome to the Weather App</h1>

    <!-- Input field for location and search button -->
    <h3><label for="location">Enter your location:</label></h3>
    <input type="text" id="location" placeholder="City, Country">
    <button onclick="searchWeather()">Search</button>

    <!-- Containers for displaying weather information and errors -->
    <div id="weather-container"></div>
    <div id="error-message"></div>
    <div id="historical-data"></div>

    <!-- JavaScript code for fetching and displaying weather data -->
    <script>
        function searchWeather() {
            // Get the location entered by the user
            const location = document.getElementById('location').value;

            // Check if the location is empty
            if (!location) {
                document.getElementById('error-message').innerText = 'Please enter a location.';
                return;
            }

            // Clear previous error messages
            document.getElementById('error-message').innerText = '';

            // Make an AJAX call to the OpenWeatherMap API
            const apiKey = '8093e392f6ae0ed701e8cadc583d8538';
            const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(location)}&units=metric&appid=${apiKey}`;

            // Fetch weather data from the API
            fetch(apiUrl)
                .then(response => response.json()) // Parse response as JSON
                .then(data => {
                    // Display weather information
                    displayWeather(data);
                    // Insert historical data and retrieve it
                    insertAndRetrieveHistoricalData(location, data.main.temp, data.weather[0].description, data.weather[0].icon);
                })
                .catch(error => {
                    // Display error message if fetching data fails
                    document.getElementById('error-message').innerText = 'Error fetching weather data.';
                    console.error('Error fetching weather data:', error);
                });
        }

        // Function to display current weather information
        function displayWeather(data) {
            const weatherContainer = document.getElementById('weather-container');
            weatherContainer.innerHTML = '';

            // Check if location is not found
            if (data.cod === '404') {
                document.getElementById('error-message').innerText = 'Location not found.';
            } else {
                // Extract weather details from the API response
                const cityName = data.name;
                const temperature = data.main.temp;
                const description = data.weather[0].description;
                const iconCode = data.weather[0].icon;

                // Create elements to display weather information
                const weatherInfo = document.createElement('div');
                weatherInfo.innerHTML = `<h2>${cityName}</h2><p>Temperature: ${temperature}°C</p><p>Description: ${description}</p>`;

                // Display weather icon
                const weatherIcon = document.createElement('img');
                weatherIcon.src = `https://openweathermap.org/img/wn/${iconCode}.png`;
                weatherIcon.alt = 'Weather Icon';
                weatherIcon.className = 'weather-icon';
                weatherInfo.appendChild(weatherIcon);
                
                // Add weather information to the container
                weatherContainer.appendChild(weatherInfo);
            }
        }

        // Function to insert and retrieve historical data
        function insertAndRetrieveHistoricalData(location, temperature, description, weatherIcon) {
            // Make an AJAX call to insert data into the database
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log('Data inserted successfully.');
                        // Now retrieve historical data for the same location
                        retrieveHistoricalData(location);
                    } else {
                        console.error('Error inserting data:', xhr.statusText);
                    }
                }
            };
            xhr.open('POST', '', true); // Empty URL means current page
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`location=${encodeURIComponent(location)}&temperature=${temperature}&description=${encodeURIComponent(description)}&weather_icon=${encodeURIComponent(weatherIcon)}`);
        }

        // Function to retrieve historical data
        function retrieveHistoricalData(location) {
            // Make an AJAX call to retrieve historical data from the database
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const historicalData = JSON.parse(xhr.responseText);
                        displayHistoricalData(historicalData);
                    } else {
                        console.error('Error fetching historical data:', xhr.statusText);
                    }
                }
            };
            xhr.open('GET', `?location=${encodeURIComponent(location)}`, true); // Pass location as a parameter
            xhr.send();
        }

        // Function to display historical data
        function displayHistoricalData(historicalData) {
            const historicalContainer = document.getElementById('historical-data');
            historicalContainer.innerHTML = '';

            if (historicalData.length > 0) {
                const heading = document.createElement('h3');
                heading.textContent = 'Historical Data';
                historicalContainer.appendChild(heading);

                historicalData.forEach(historical => {
                    const historicalInfo = document.createElement('p');
                    historicalInfo.textContent = `Temperature: ${historical.temperature}°C, Description: ${historical.description}`;
                    historicalContainer.appendChild(historicalInfo);
                });
            } else {
                const noHistoricalData = document.createElement('p');
                noHistoricalData.textContent = 'No historical data available for this location.';
                historicalContainer.appendChild(noHistoricalData);
            }
        }
    </script>

<?php
// Check if the location is provided
if (isset($_REQUEST['location'])) {
    // Sanitize the input
    $location = filter_var($_REQUEST['location'], FILTER_SANITIZE_STRING);

    // Your database connection code here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "weather";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to retrieve historical data
    $stmt = $conn->prepare("SELECT temperature, description FROM weather_api WHERE location_searched = ?");
    $stmt->bind_param("s", $location);

    // Execute SQL statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $historicalData = array();

        // Fetch data
        while ($row = $result->fetch_assoc()) {
            $historicalData[] = $row;
        }

        // Output JSON
        echo json_encode($historicalData);
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: Location not provided.";
}
?>


<?php
// Check if the location, temperature, description, and weather icon are set
if (isset($_POST['location'], $_POST['temperature'], $_POST['description'], $_POST['weather_icon'])) {
    // Sanitize the input
    $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
    $temperature = filter_var($_POST['temperature'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $weather_icon = filter_var($_POST['weather_icon'], FILTER_SANITIZE_STRING);
    $time = date('Y-m-d H:i:s'); // Current time

    // Your database connection code here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "weather";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO weather_api (location_searched, time_searched, temperature, description, weather_icon) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $location, $time, $temperature, $description, $weather_icon);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: Required parameters not provided.";
}
?>
</body>
</html>
