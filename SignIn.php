<?PHP 
  if(isset($_POST['submitFromSignIn'])){
    ob_start(); //This is optional. require by our specific website host only.
    $servername = "localhost";
    $username="u647272286_swe2023";
    $password= "Heoboy123$%^&*(";
    $db_name="u647272286_swe";
    $conn= new mysqli($servername, $username, $password, $db_name);
    if($conn->connect_error){
      die("connection failed".$conn->connect_error);
    }
    $username_c = $_POST["username"];
    $password_c = $_POST["password"];
    $sql= "SELECT email FROM Users WHERE email = '$username_c' AND password = '$password_c' AND EmailStatus = 1";
    $result = $conn->query($sql);
    ob_end_flush();
    mysqli_close($conn);
    if ($result->num_rows === 1){
      header("Location: https://melvin-projects.com/RainCheck_SWE_Project/Home.html");
      exit();
    } 
    echo "<script>alert('Either username or password or both is incorrect. Or email is not activate. Please try again!')</script>";
    echo "<p>You are being redirected to the login page.</p>";
    echo "<meta http-equiv='refresh' content='2;url=https://melvin-projects.com/RainCheck_SWE_Project/index.html'>";
  } else {
    header("Location: https://melvin-projects.com/RainCheck_SWE_Project/index.html");
    exit();
  }
?>