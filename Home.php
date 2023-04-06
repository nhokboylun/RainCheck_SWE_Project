<?PHP 
  session_start();
  if(isset($_SESSION['user'])){
    if (isset($_POST['logout'])) {
      session_destroy();
      header("Location: https://melvin-projects.com/RainCheck_SWE_Project/index.html");
      exit();
    }
  } else {
    session_destroy();
    header("Location: https://melvin-projects.com/RainCheck_SWE_Project/index.html");
    exit();
  }
?>
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
  </head>
  <body>
    <header>
    <div class="title">
      <img src="./Logo.png" alt="Logo" />
      <span>RAINCHECK</span>
    </div>
      <nav>
        <a href="./Home.php" class="nav-item">Home</a>
        <a href="./About.html" class="nav-item">About Us</a>
        <a href="#" class="nav-item">FAQ</a>
        <!-- <a href="#" class="nav-item logout">Log Out</a> -->
        <form method="post">
          <input class="nav-item logout" type="submit" name="logout" value="Logout">
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
        <button onclick="getCurrentLocation()">Get Current Location</button>
      </div>
      <div id="weatherInfo"></div>
      <div id="photo-container"></div>
    </main>
    <script src="Home.js"></script>
  </body>
</html>
