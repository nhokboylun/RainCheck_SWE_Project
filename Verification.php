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
      $code = str_pad(rand(0, 499999), 6, '0', STR_PAD_LEFT);
      while (false){
        $sqlCheck = "SELECT * FROM mytable WHERE code = $code";
        $result = $conn->query($sqlCheck);
        if ($result->num_rows == 0) {
          break;
        }
        $code = str_pad(rand(0, 499999), 6, '0', STR_PAD_LEFT);
      }
      $firstname_c =  $_POST['firstname'];
      $lastname_c =  $_POST['lastname'];
      $email_c =  $_POST['email'];
      $password_c = $_POST['pass'];
      $tel_c = $_POST['phonenumber'];
      $sql = "INSERT INTO Users (firstname,lastname,email,password,phonenumber,Code) VALUES ('$firstname_c', '$lastname_c', '$email_c', '$password_c', '$tel_c', '$code')";
    }
    mysqli_query($conn, $sql);
    /* Send Confirmation email for user*/
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = "raincheckswe@gmail.com";
    $mail->Password = "uzjzhymleiatmfkc";
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('raincheckswe@gmail.com');

    $mail->addAddress($_POST['email']);

    $mail->isHTML(true);

    $mail->Subject = "Rain Check";
    $mail->Body = "Here is your verification code: $code";

    $mail->send();
    // if(isset($_POST['verified'])){

    // }
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
        <form 
          class="Verification-form"
          name="Verification"
          action="Verification.php"
          method="POST"
        >
          <input type="text" name="VerificationCode" placeholder="VerificationCode" />
          <input type="submit" name="Verify" value="Verify">
        </form>
      </div>
      <div class="image-container">
        <img src="./Logo.png" alt="Placeholder Image" />
      </div>
    </div> 
  </body>
</html>