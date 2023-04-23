// Call getCurrentLocation() to request the user's location upon loading the page
getCurrentLocation();

let combineResults = [];
const defaultPhotoUrl = "./Logo.png";
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
  try {
    document.getElementById("photo-container").innerHTML = "";
    const response = await fetch(
      `proxy.php?endpoint=weather&lat=${lat}&lon=${lon}&units=imperial`
    );

    if (!response.ok) {
      throw new Error("Failed to fetch weather data.");
    }

    const data = await response.json();

    // Move this block inside the try block and after fetching weather data
    if (data.main.temp > 70) {
      const outdoorCheckboxes = document.querySelectorAll(".outdoor-activity");
      outdoorCheckboxes.forEach((checkbox) => {
        checkbox.checked = true;
      });
    } else {
      const indoorCheckboxes = document.querySelectorAll(".indoor-activity");
      indoorCheckboxes.forEach((checkbox) => {
        checkbox.checked = true;
      });
    }

    const checkedActivities = document.querySelectorAll(
      ".activity-checkbox:checked"
    );
    const activityTypes = Array.from(checkedActivities).map(
      (checkbox) => checkbox.value
    );

    displayWeather(data);
    await searchActivities(lat, lon, activityTypes);
    displayCombineResults();
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

function searchActivities(latitude, longitude, activityTypes) {
  return new Promise((resolve) => {
    const location = new google.maps.LatLng(latitude, longitude);
    const map = new google.maps.Map(document.createElement("div"));
    const service = new google.maps.places.PlacesService(map);

    // Create an array to store promises
    const searchPromises = [];

    activityTypes.forEach((activityType) => {
      const request = {
        location: location,
        radius: "5000", // 2.5 miles
        type: activityType,
      };

      // Create a new Promise for each nearbySearch and push it into the array
      const searchPromise = new Promise((searchResolve) => {
        service.nearbySearch(request, (results, status) => {
          processResults(results, status, request.type);
          searchResolve();
        });
      });
      searchPromises.push(searchPromise);
    });

    // Create an async function to wait for all Promises in the array to resolve
    async function waitForAllSearches() {
      await Promise.all(searchPromises);
      resolve();
    }

    // Invoke the async function
    waitForAllSearches();

    function processResults(results, status, businessType) {
      if (results.length >= 6) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          const photoContainer = document.getElementById("photo-container");

          const cardContainer = document.createElement("div");
          cardContainer.classList.add("card-container");
          cardContainer.id = businessType;
          for (let i = 0; i < 6; i++) {
            // Create place card div and add class
            const Card = document.createElement("div");
            Card.classList.add("place-card");

            // Business type
            businessType =
              businessType.charAt(0).toUpperCase() + businessType.slice(1);
            const typeTag = document.createElement("span");
            typeTag.classList.add("type-tag");
            typeTag.textContent = businessType;

            // Create image element
            const photoUrl =
              results[i].photos && results[i].photos.length > 0
                ? results[i].photos[0].getUrl()
                : defaultPhotoUrl;
            const img = document.createElement("img");
            img.src = photoUrl;
            img.alt = results[i].name;
            img.style.width = "100%";
            img.style.height = "150px";

            // Create rating div element
            const rating = document.createElement("div");
            rating.classList.add("business-info");
            rating.innerHTML = `
              <h2>${results[i].name}</h2>
              <p>${results[i].vicinity}</p>
            `;

            // Star
            const stars = printStar(Math.round(results[i].rating));
            const ratingElement = document.createElement("p");
            ratingElement.innerHTML = `${results[i].rating} ${stars}(${results[i].user_ratings_total})`;
            rating.appendChild(typeTag);
            rating.appendChild(ratingElement);

            // Add "Get Directions" button
            const directionsButton = document.createElement("button");
            directionsButton.classList.add("directions-button");
            directionsButton.innerHTML = `<ion-icon name="arrow-redo-circle-outline"></ion-icon>`;
            directionsButton.addEventListener("click", () => {
              const origin = `${latitude},${longitude}`;
              const destination = `${results[
                i
              ].geometry.location.lat()},${results[i].geometry.location.lng()}`;
              window.open(
                `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}`,
                "_blank"
              );
            });
            rating.appendChild(directionsButton);

            // Append img and rating elements to restaurant card
            Card.appendChild(img);
            Card.appendChild(rating);

            // Append restaurant card to photo container
            cardContainer.appendChild(Card);
            photoContainer.appendChild(cardContainer);
          }
        } else {
          console.error("Error: " + status);
        }
      } else if (results.length >= 0) {
        // Push results and businessType into the combineResults array
        results.forEach((result) => {
          combineResults.push({ result, businessType });
          console.log(combineResults);
        });
      }
    }
  });
}

function printStar(rating) {
  let stars = "";

  for (let i = 0; i < rating; i++) {
    stars += "&#9733;";
  }

  return stars;
}

const filterButton = document.querySelector(".filter-btn");
const dropdownContent = document.querySelector(".dropdown-content");

filterButton.addEventListener("click", function () {
  dropdownContent.classList.toggle("hidden");
});

function displayCombineResults() {
  const photoContainer = document.getElementById("photo-container");
  const cardContainer = document.createElement("div");
  cardContainer.classList.add("card-container");
  let resultsLength = combineResults.length;
  end = false;
  let j;

  // Iterate through the first 6 items in combineResults and create cards
  while (!end) {
    if (resultsLength < 6) {
      end = true;
      j = 0;
    } else {
      j = resultsLength - 6;
    }
    for (let i = j; i < resultsLength; i++) {
      const { result, businessType } = combineResults[i];

      const Card = document.createElement("div");
      Card.classList.add("place-card");

      const typeTag = document.createElement("span");
      typeTag.classList.add("type-tag");
      typeTag.textContent = businessType;

      const photoUrl =
        result.photos && result.photos.length > 0
          ? result.photos[0].getUrl()
          : defaultPhotoUrl;
      const img = document.createElement("img");
      img.src = photoUrl;
      img.alt = result.name;
      img.style.width = "100%";
      img.style.height = "150px";

      const rating = document.createElement("div");
      rating.classList.add("business-info");
      rating.innerHTML = `
      <h2>${result.name}</h2>
      <p>${result.vicinity}</p>
    `;

      const stars = printStar(Math.round(result.rating));
      const ratingElement = document.createElement("p");
      ratingElement.innerHTML = `${result.rating} ${stars}(${result.user_ratings_total})`;
      rating.appendChild(typeTag);
      rating.appendChild(ratingElement);

      const directionsButton = document.createElement("button");
      directionsButton.classList.add("directions-button");
      directionsButton.innerHTML = `<ion-icon name="arrow-redo-circle-outline"></ion-icon>`;
      directionsButton.addEventListener("click", () => {
        const origin = `${latitude},${longitude}`;
        const destination = `${result.geometry.location.lat()},${result.geometry.location.lng()}`;
        window.open(
          `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}`,
          "_blank"
        );
      });
      rating.appendChild(directionsButton);

      Card.appendChild(img);
      Card.appendChild(rating);

      cardContainer.appendChild(Card);
    }

    // Append cardContainer to photoContainer
    photoContainer.appendChild(cardContainer);
    resultsLength = resultsLength - 6;
  }
  combineResults = [];
}
