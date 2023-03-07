<?PHP 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    function sendmail($email, $code){

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

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = "RainCheck verification code";
    $mail->Body = "Dear our valued customer, here is your verification code: $code";

    $mail->send();
  }
?>