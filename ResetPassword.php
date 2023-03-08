<?PHP 
  if((isset($_POST['pass']))||(isset($_GET['email']) && isset($_GET['code']))){
    if(isset($_POST['submitFromResetPassword'])){
      ob_start();
      $servername = "localhost";
      $username="u647272286_swe2023";
      $password= "Heoboy123$%^&*(";
      $db_name="u647272286_swe";
      $conn= new mysqli($servername, $username, $password, $db_name);
      if($conn->connect_error){
        die("connection failed".$conn->connect_error);
      }
      $pass = $_POST['pass'];
      $email = $_POST['secretValue1'];
      $code = $_POST['secretValue2'];
      $code = $code/2;
      $sql="UPDATE Users SET password='$pass' WHERE email= '$email' AND code = $code AND EmailStatus = 1";
      $conn->query($sql);
      $sql="UPDATE Users SET code = NULL WHERE code = $code";
      $conn->query($sql);
      ob_end_flush();
      mysqli_close($conn);
      header("Location: https://melvin-projects.com/RainCheck_SWE_Project/index.html");
      exit();
    }
  }
  else {
    header("Location: https://melvin-projects.com/RainCheck_SWE_Project/index.html");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./SignUp.css" />
    <title>Reset Password Rain Check</title>
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
  </head>
  <body class="ResetPasswordPage">
    <div class="Left"><img src="./Logo.png" alt="Logo" /></div>
    <form class="sign-up-form ResetPassword" action="ResetPassword.php" name="ResetPassword" method="POST">
      <img src="./Brand-Logo.png" alt="Brand Logo" />
      <h1>Reset Password</h1>
      <input type="password" name="pass" placeholder="New Password" />
      <input type="password" placeholder="Confirm Password" />
      <input type="submit" id="btn" value="Reset" name="submitFromResetPassword" />
      <input type="hidden" name="secretValue1" value="<?PHP $email = $_GET['email']; echo $email; ?>">
      <input type="hidden" name="secretValue2" value="<?PHP $code = $_GET['code']; echo $code; ?>">
    </form>
  </body>
</html>
