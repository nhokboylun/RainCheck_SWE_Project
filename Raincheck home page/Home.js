const locationSearch = document.getElementById("locationSearch");
const weatherInfo = document.getElementById("weatherInfo");

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
  searchActivities(lat, lon);
  try {
    const response = await fetch(
      `proxy.php?endpoint=weather&lat=${lat}&lon=${lon}&units=imperial`
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

function searchActivities(latitude, longitude) {
  const location = new google.maps.LatLng(latitude, longitude);
  const map = new google.maps.Map(document.createElement("div"));

  const request = {
    location: location,
    radius: "5000",
    type: "restaurant",
  };

  const request1 = {
    location: location,
    radius: "50000",
    type: "spa",
  };

  const service = new google.maps.places.PlacesService(map);

  function processResults(results, status, pagination) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
      const photoContainer = document.getElementById("photo-container");
      for (let i = 0; i < 5; i++) {
        const rating = document.createElement("div");
        rating.innerHTML = `
        <p>Name: ${results[i].name}</p>
        <p>Address: ${results[i].vicinity}</p>
        <p>Rating: ${results[i].rating}</p>
        <p>Rating Total: ${results[i].user_ratings_total}</p>
        <p>Type: ${results[i].types}</p>
        `;
        const photoUrl = results[i].photos[0].getUrl();
        const img = document.createElement("img");
        img.src = photoUrl;
        img.alt = results[i].name;
        img.style.width = "200px";
        img.style.height = "200px";
        img.style.margin = "10px";
        photoContainer.appendChild(img);
        photoContainer.appendChild(rating);
      }
    } else {
      console.error("Error: " + status);
    }
  }

  service.nearbySearch(request, processResults);
  //service.nearbySearch(request1, processResults);
}

// Call getCurrentLocation() to request the user's location upon loading the page
getCurrentLocation();
