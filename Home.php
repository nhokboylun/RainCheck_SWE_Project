<!-- PHP parts
session_start();
if(isset($_SESSION['user'])){
  if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: https://melvin-projects.com/RainCheck/index.html");
  exit();
}
} else {
session_destroy();
header("Location: https://melvin-projects.com/RainCheck/index.html");
exit();
} -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="Home.css" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDedATs1gxl-sUVIeqFtK4oq-xQ6P8PN8s&libraries=places"></script>
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
  </head>
  <body>
    <header>
      <div class="title">
        <img style="width: 10%" src="./Logo.png" alt="Logo" />
        <span>RAINCHECK</span>
      </div>
      <nav>
        <a class="nav-item">Home</a>
        <a href="./About.html" class="nav-item">About Us</a>
        <a href="./faq.html" class="nav-item">FAQ</a>
        <form method="post">
          <input
            class="nav-item logout"
            type="submit"
            name="logout"
            value="Logout"
          />
        </form>
      </nav>
    </header>

    <main>
      <div class="search">
        <input
          id="locationSearch"
          type="text"
          placeholder="Search for a location"
        />
        <div class="dropdown">
          <button class="filter-btn">Filter</button>
          <div class="dropdown-content hidden">
            <h3>Indoor Activities</h3>
            <h3>Outdoor Activities</h3>
            <div class="indoor-categories">
              <label
                ><input
                  class="activity-checkbox indoor-activity"
                  type="checkbox"
                  value="gym"
                />
                Gym</label
              >
              <label
                ><input
                  class="activity-checkbox indoor-activity"
                  type="checkbox"
                  value="bar"
                />
                Bar</label
              >
              <label
                ><input
                  class="activity-checkbox indoor-activity"
                  type="checkbox"
                  value="cafe"
                />
                Cafe</label
              >
              <label
                ><input
                  class="activity-checkbox indoor-activity"
                  type="checkbox"
                  value="restaurant"
                />
                Restaurant</label
              >
              <label
                ><input
                  class="activity-checkbox indoor-activity"
                  type="checkbox"
                  value="spa"
                />
                Spa</label
              >
              <label
                ><input
                  class="activity-checkbox indoor-activity"
                  type="checkbox"
                  value="hair_care"
                />
                Salon</label
              >
              <label
                ><input
                  class="activity-checkbox indoor-activity"
                  type="checkbox"
                  value="bowling_alley"
                />
                Bowling</label
              >
              <label
                ><input
                  class="activity-checkbox indoor-activity"
                  type="checkbox"
                  value="art_gallery"
                />
                Art</label
              >
            </div>
            <div class="activity-checkbox outdoor-categories">
              <label
                ><input
                  class="activity-checkbox outdoor-activity"
                  type="checkbox"
                  value="park"
                />
                Park</label
              >
              <label
                ><input
                  class="activity-checkbox outdoor-activity"
                  type="checkbox"
                  value="city_hall"
                />
                City Hall</label
              >
              <label
                ><input
                  class="activity-checkbox outdoor-activity"
                  type="checkbox"
                  value="stadium"
                />
                Stadium</label
              >
              <label
                ><input
                  class="activity-checkbox outdoor-activity"
                  type="checkbox"
                  value="zoo"
                />
                Zoo</label
              >
              <label
                ><input
                  class="activity-checkbox outdoor-activity"
                  type="checkbox"
                  value="aquarium"
                />
                Aquarium</label
              >
              <label
                ><input
                  class="activity-checkbox outdoor-activity"
                  type="checkbox"
                  value="campground"
                />
                Camping</label
              >
              <label
                ><input
                  class="activity-checkbox outdoor-activity"
                  type="checkbox"
                  value="golf_course"
                />
                Golf</label
              >
              <label
                ><input
                  class="activity-checkbox outdoor-activity"
                  type="checkbox"
                  value="natural_feature"
                />
                Natural</label
              >
            </div>
          </div>
        </div>
        <button onclick="getCurrentLocation()">Get Current Location</button>
      </div>

      <div id="weatherInfo"></div>
      <div id="photo-container"></div>
    </main>
    <script src="Home.js"></script>
  </body>
</html>
