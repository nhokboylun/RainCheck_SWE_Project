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
    
    /* Store data into database*/
    if(isset($_POST['submit'])){
      $firstname_c =  $_POST['firstname'];
      $lastname_c =  $_POST['lastname'];
      $email_c =  $_POST['email'];
      $password_c = $_POST['pass'];
      $tel_c = $_POST['phonenumber'];
      $sql = "INSERT INTO Users (firstname, lastname, email,password,phonenumber) VALUES ('$firstname_c', '$lastname_c', '$email_c', '$password_c', '$tel_c')";
    }
    mysqli_query($conn, $sql);
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
          for an email from the company and click on the link provided to verify
          your email. Once verified, please follow the instructions to sign in.
        </p>
      </div>
      <div class="image-container">
        <img src="./Logo.png" alt="Placeholder Image" />
      </div>
    </div>
  </body>
</html>