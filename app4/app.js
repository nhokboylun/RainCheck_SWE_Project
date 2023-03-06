const geoApiKey = "c93e7d8567094f36bec707581abb6295";
const weatherApiKey = "6e7bc156ddf0165f9cea962f15c3ead2";

const getWeatherBtn = document.getElementById("getWeatherBtn");
const getCurrentLocationBtn = document.getElementById("getCurrentLocationBtn");
const streetInput = document.getElementById("street");
const cityInput = document.getElementById("city");
const stateInput = document.getElementById("state");
const zipInput = document.getElementById("zip");
const weatherDiv = document.getElementById("weather");

// Get weather data from API and display it on the page
function getWeather(latitude, longitude) {
  const weatherUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=${weatherApiKey}&units=imperial`;

  // Show loading spinner
  weatherDiv.innerHTML = `
    <div class="loading">
      <img src="loading.gif" alt="Loading...">
    </div>
  `;

  fetch(weatherUrl)
    .then((response) => {
      if (!response.ok) {
        throw new Error(response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      const weather = data.weather[0].main;
      const temp = data.main.temp;
      const feelsLike = data.main.feels_like;
      const windSpeed = data.wind.speed;

      // Display weather data on the page
      weatherDiv.innerHTML = `
        <p>Weather: ${weather}</p>
        <p>Temperature: ${temp}°F</p>
        <p>Feels like: ${feelsLike}°F</p>
        <p>Wind speed: ${windSpeed} mph</p>
      `;
    })
    .catch((error) => {
      alert(`Error: ${error}. Please try again.`);
      streetInput.focus();
    });
}

// Get current location from browser and call getWeather function
function getCurrentLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        getWeather(latitude, longitude);
      },
      (error) => {
        weatherDiv.innerHTML = `<p>Error: ${error.message}. Please try again.</p>`;
      }
    );
  } else {
    weatherDiv.innerHTML = "<p>Your browser doesn't support geolocation.</p>";
  }
}

// Get location data from input fields and call getWeather function
function getLocationData() {
  const street = streetInput.value.trim();
  const city = cityInput.value.trim();
  const state = stateInput.value.trim();
  const zip = zipInput.value.trim();

  if (!street || !city || !state || !zip) {
    alert("Please enter a valid address.");
    streetInput.focus();
    return;
  }

  const location = `${street}, ${city}, ${state} ${zip}`;
  const geoUrl = `https://api.opencagedata.com/geocode/v1/json?q=${location}&key=${geoApiKey}&language=en&pretty=1&no_annotations=1`;

  

  fetch(geoUrl)
    .then((response) => response.json())
    .then((data) => {
      if (data.results.length === 0) {
        throw new Error("Unable to find location. Please enter a valid address.");
      }
      const latitude = data.results[0].geometry.lat;
      const longitude = data.results[0].geometry.lng;
      getWeather(latitude, longitude);
    })
    .catch((error) => {
      alert(`Error: ${error}. Please try again.`);
      streetInput.focus();
    });
}

// Add event listeners to buttons
getWeatherBtn.addEventListener("click", getLocationData);
getCurrentLocationBtn.addEventListener("click", getCurrentLocation);








