<!DOCTYPE html>
<html>
  <head>
    <title>Verification</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
  </head>
  <body>
    <?PHP
    include 'SendMail.PHP';
    /* Connect to database */
    ob_start(); //This is optional. require by our specific website host only.
    $servername = "localhost";
    $username="u647272286_swe2023";
    $password= "Heoboy123$%^&*(";
    $db_name="u647272286_swe";
    $conn= new mysqli($servername, $username, $password, $db_name);
    if($conn->connect_error){
      die("connection failed".$conn->connect_error);
    }
    if(isset($_POST['submitFromForgotPassword'])){
      $code = str_pad(rand(800000, 999999), 6, '0', STR_PAD_LEFT);
      while (true){
        $sqlCheck = "SELECT Code FROM Users WHERE Code = $code";
        $result = $conn->query($sqlCheck);
        if ($result->num_rows == 0) {
          break;
        }
        $code = str_pad(rand(800000, 999999), 6, '0', STR_PAD_LEFT);
      }
      $emailReset = $_POST['emailFromForgotPassword'];
      sendmail($emailReset, $code);
      $sqlInputResetCode = "UPDATE Users SET Code = $code WHERE email = '$emailReset';";
      $conn->query($sqlInputResetCode);
    }

    /* User input verification code*/ 
    if(isset($_POST['Verify'])){
      $verify = $_POST['VerificationCode'];
      $sqlcompare="SELECT Code FROM Users WHERE Code = $verify";
      $resultVerify = $conn->query($sqlcompare);
      if ($resultVerify->num_rows === 1){
        if ($verify < 800000 && $verify > 0) {
          $sqlActive = "UPDATE Users SET EmailStatus = '1' WHERE Code = $verify;";
          $sqlDelete ="UPDATE Users SET Code= 'NULL' WHERE Code = $verify;";
          $conn->query($sqlActive);
          $conn->query($sqlDelete);
          ob_end_flush();
          mysqli_close($conn);
          header("Location: https://melvin-projects.com/RainCheck_SWE_Project/index.html");
          exit();
        } else if ($verify >= 800000){
          ob_end_flush();
          mysqli_close($conn);
          header("Location: https://melvin-projects.com/RainCheck_SWE_Project/ResetPassword.html");
          exit();
        }
      } else {
        $codeDelete = $_POST['CodeToDelete'];
        if ($codeDelete < 800000 && $codeDelete >0 ){
          echo '
          <div class="container">
          <div class="login-container Verification-container">
            <img src="./Brand-Logo.png" alt="Placeholder Image" />
            <h1>Failed !</h1>
            <p>
              You put the wrong code. Please hit the link below to Sign Up again.
            </p>
            <a href=https://melvin-projects.com/RainCheck_SWE_Project/SignUp.html>Sign Up</a>
          </div>
          <div class="image-container">
            <img src="./Logo.png" alt="Placeholder Image" />
          </div>
        </div> 
      </body>
    </html>
          ';
          $sqlDeletee ="DELETE FROM Users WHERE Code = $codeDelete;";
          $conn->query($sqlDeletee);
          ob_end_flush();
          mysqli_close($conn);
          exit();
        } else {
          ob_end_flush();
          mysqli_close($conn);
          header("Location: https://melvin-projects.com/RainCheck_SWE_Project/ResetPassword.html");
          exit();
        }
      }
    }
    /* User come from sign up page. Store data into database*/
    if(isset($_POST['submit'])){
      $code = str_pad(rand(1, 799999), 6, '0', STR_PAD_LEFT);
      while (true){
        $sqlCheck = "SELECT Code FROM Users WHERE Code = $code";
        $result = $conn->query($sqlCheck);
        if ($result->num_rows == 0) {
          break;
        }
        $code = str_pad(rand(1, 799999), 6, '0', STR_PAD_LEFT);
      }
      $firstname_c =  $_POST['firstname'];
      $lastname_c =  $_POST['lastname'];
      $email_c =  $_POST['email'];
      $password_c = $_POST['pass'];
      $tel_c = $_POST['phonenumber'];
      $sql = "INSERT INTO Users (firstname,lastname,email,password,phonenumber,Code) VALUES ('$firstname_c', '$lastname_c', '$email_c', '$password_c', '$tel_c', '$code')";
      sendmail($_POST['email'], $code);
      mysqli_query($conn, $sql);
    }
    ob_end_flush();
    mysqli_close($conn);
    ?>
    <div class="container">
      <div class="login-container Verification-container">
        <img src="./Brand-Logo.png" alt="Placeholder Image" />
        <ion-icon name="checkmark-circle-outline"></ion-icon>
        <h1>Success !</h1>
        <p>
          An email has been sent to your email address. Please check your inbox
          for an email from our company and then put your verification code down below.
        </p>
        <form 
          class="Verification-form"
          name="Verification"
          action="Verification.php"
          method="POST"
        >
          <input style="width: 226px" type="text" name="VerificationCode" placeholder="Verification Code" maxlength="6"/>
          <input type="submit" id="btn-ForgotPassword" name="Verify" value="Verify">
          <input type="hidden" name="CodeToDelete" value="<?PHP echo $code; ?>">
        </form>
      </div>
      <div class="image-container">
        <img src="./Logo.png" alt="Placeholder Image" />
      </div>
    </div> 
  </body>
</html>