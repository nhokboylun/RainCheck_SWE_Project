<?PHP 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    function sendmail($email, $code, $Tran){

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = "raincheckswe@gmail.com"; 
    $mail->Password = $Tran;

    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('raincheckswe@gmail.com');

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = "RainCheck verification code";
    $randomNumber = rand(1, 10);
    if ($randomNumber === 1){
      $mail->Body = "Dear our valued customer, here is your verification code: $code";
    } else if ($randomNumber === 2){
      $mail->Body = "We have sent you a verification code: $code. Please enter it to verify your account.";
    } else if ($randomNumber === 3){
      $mail->Body = "Thank you for registering with us! Your verification code is: $code.";
    } else if ($randomNumber === 4){
      $mail->Body = "Your verification code is: $code. Please do not share this code with anyone.";
    } else if ($randomNumber === 5){
      $mail->Body = "Use the following verification code to verify your account: $code.";
    } else if ($randomNumber === 6){
      $mail->Body = "To complete your verification, please enter the verification code we sent you: $code.";
    } else if ($randomNumber === 7){
      $mail->Body = "Your verification code is: $code. Please keep it safe and secure.";
    } else if ($randomNumber === 8){
      $mail->Body = "Please enter the following verification code to verify your account: $code.";
    } else if ($randomNumber === 9){
      $mail->Body = "We have sent you a verification code to confirm your identity. Please enter the code: $code.";
    } else if ($randomNumber === 10){
      $mail->Body = "To continue enjoying our app,please enter the verification code we sent you: $code.";
    }
    $mail->send();
  }
