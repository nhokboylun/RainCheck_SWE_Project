<?PHP 
  if (isset($_POST['submitFromSignIn'])) {
    ob_start();
    $servername = "localhost";
    $username = "u647272286_swe2023";
    $password = "Heoboy123$%^&*(";
    $db_name = "u647272286_swe";
    $conn = new mysqli($servername, $username, $password, $db_name);
    if ($conn->connect_error) {
      die("connection failed" . $conn->connect_error);
    }
    $username_c = $_POST["username"];
    $password_c = $_POST["password"];
    $sqlCheckMatchPassword = "SELECT password FROM Users WHERE email ='$username_c'";
    $resultCheckMatchPassword = $conn->query($sqlCheckMatchPassword);
    $db_password = $resultCheckMatchPassword->fetch_assoc()['password'];
    $sql = "SELECT email, password FROM Users WHERE email = '$username_c' AND EmailStatus = 1";
    $result = $conn->query($sql);
    ob_end_flush();
    mysqli_close($conn);
    if ($result->num_rows === 1 && password_verify($password_c, $db_password)) {
      session_start();
      $_SESSION['user'] = $username_c;
      header("Location: ./Home.php");
      exit();
    }
    echo "<script>alert('Either username or password or both is incorrect. Or email is not activate. Please try again!')</script>";
    echo "<p>You are being redirected to the login page.</p>";
    echo "<meta http-equiv='refresh' content='2;url=https://melvin-projects.com/RainCheck/index.html'>";
  } else {
    header("Location: https://melvin-projects.com/RainCheck/index.html");
    exit();
  }
?>
