const locationSearch = document.getElementById("locationSearch");
const weatherInfo = document.getElementById("weatherInfo");

const apiKey = "6e7bc156ddf0165f9cea962f15c3ead2";

function initAutocomplete() {
  const autocomplete = new google.maps.places.Autocomplete(locationSearch);

  autocomplete.addListener("place_changed", () => {
    const place = autocomplete.getPlace();
    if (!place.geometry) {
      alert("No details available for the selected location.");
      return;
    }
    getWeather(place.geometry.location.lat(), place.geometry.location.lng());
  });
}

async function getWeather(lat, lon) {
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=imperial`
    );

    if (!response.ok) {
      throw new Error("Failed to fetch weather data.");
    }

    const data = await response.json();
    displayWeather(data);
  } catch (error) {
    alert(`Error: ${error.message}`);
  }
}

function displayWeather(data) {
  weatherInfo.innerHTML = `
    <h2>${data.name}, ${data.sys.country}</h2>
    <p>Temperature: ${data.main.temp.toFixed(2)} °F</p>
    <p>Weather: ${data.weather[0].description}</p>
  `;
}

function getCurrentLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        getWeather(position.coords.latitude, position.coords.longitude);
      },
      (error) => {
        alert("Error: Unable to fetch current location.");
      }
    );
  } else {
    alert("Error: Geolocation is not supported by this browser.");
  }
}

initAutocomplete();
