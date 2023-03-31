// const locationSearch = document.getElementById("locationSearch");
// const weatherInfo = document.getElementById("weatherInfo");

// const apiKey = "6e7bc156ddf0165f9cea962f15c3ead2";

// function initAutocomplete() {
//   const autocomplete = new google.maps.places.Autocomplete(locationSearch);

//   autocomplete.addListener("place_changed", () => {
//     const place = autocomplete.getPlace();
//     if (!place.geometry) {
//       alert("No details available for the selected location.");
//       return;
//     }
//     getWeather(place.geometry.location.lat(), place.geometry.location.lng());
//   });
// }

// async function getWeather(lat, lon) {
//   searchActivities(lat, lon);
//   try {
//     const response = await fetch(
//       `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=imperial`
//     );

//     if (!response.ok) {
//       throw new Error("Failed to fetch weather data.");
//     }

//     const data = await response.json();
//     displayWeather(data);
//   } catch (error) {
//     alert(`Error: ${error.message}`);
//   }
// }

// function displayWeather(data) {
//   weatherInfo.innerHTML = `
//     <h2>${data.name}, ${data.sys.country}</h2>
//     <p>Temperature: ${data.main.temp.toFixed(2)} °F</p>
//     <p>Weather: ${data.weather[0].description}</p>
//   `;
// }

// function getCurrentLocation() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(
//       (position) => {
//         getWeather(position.coords.latitude, position.coords.longitude);
//       },
//       (error) => {
//         alert("Error: Unable to fetch current location.");
//       }
//     );
//   } else {
//     alert("Error: Geolocation is not supported by this browser.");
//   }
// }

// initAutocomplete();

// function searchActivities(latitude, longitude) {
//   const location = new google.maps.LatLng(latitude, longitude);
//   const map = new google.maps.Map(document.createElement("div"));

//   const request = {
//     location: location,
//     radius: "5000",
//     type: "restaurant",
//   };

//   const request1 = {
//     location: location,
//     radius: "50000",
//     type: "spa",
//   };

//   const service = new google.maps.places.PlacesService(map);

//   function processResults(results, status, pagination) {
//     if (status === google.maps.places.PlacesServiceStatus.OK) {
//       const photoContainer = document.getElementById("photo-container");
//       for (let i = 0; i < results.length; i++) {
//         console.log(`Name: ${results[i].name}`);
//         console.log(`Address: ${results[i].vicinity}`);
//         console.log(`Rating: ${results[i].rating}`);
//         console.log(`Rating Total: ${results[i].user_ratings_total}`);
//         console.log(`Type: ${results[i].types}`);
//         const rating = document.createElement("p");
//         rating.textContent = `Rating: ${results[i].rating}`;
//         rating.style.margin = "10px";
//         photoContainer.appendChild(rating);
//         const photoUrl = results[i].photos[0].getUrl();
//         const img = document.createElement("img");
//         img.src = photoUrl;
//         img.alt = results[i].name;
//         img.style.width = "200px";
//         img.style.height = "200px";
//         img.style.margin = "10px";
//         photoContainer.appendChild(img);
//       }

//       // Check if there are more results and request the next page
//       if (pagination.hasNextPage) {
//         // Add a delay before fetching the next page to avoid exceeding the QPS limit
//         setTimeout(() => {
//           pagination.nextPage();
//         }, 2000);
//       }
//     } else {
//       console.error("Error: " + status);
//     }
//   }

//   service.nearbySearch(request, processResults);
//   service.nearbySearch(request1, processResults);
// }
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
  searchActivities(lat, lon);
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
      for (let i = 0; i < results.length; i++) {
        console.log(`Name: ${results[i].name}`);
        console.log(`Address: ${results[i].vicinity}`);
        console.log(`Rating: ${results[i].rating}`);
        console.log(`Rating Total: ${results[i].user_ratings_total}`);
        console.log(`Type: ${results[i].types}`);
        const rating = document.createElement("p");
        rating.textContent = `Rating: ${results[i].rating}`;
        rating.style.margin = "10px";
        photoContainer.appendChild(rating);
        const photoUrl = results[i].photos[0].getUrl();
        const img = document.createElement("img");
        img.src = photoUrl;
        img.alt = results[i].name;
        img.style.width = "200px";
        img.style.height = "200px";
        img.style.margin = "10px";
        photoContainer.appendChild(img);
      }

      // Check if there are more results and request the next page
      if (pagination.hasNextPage) {
        // Add a delay before fetching the next page to avoid exceeding the QPS limit
        setTimeout(() => {
          pagination.nextPage();
        }, 2000);
      }
    } else {
      console.error("Error: " + status);
    }
  }

  service.nearbySearch(request, processResults);
  service.nearbySearch(request1, processResults);
}

// Call getCurrentLocation() to request the user's location upon loading the page
getCurrentLocation();
