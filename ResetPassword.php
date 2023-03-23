<?PHP
if ((isset($_POST['pass'])) || (isset($_GET['email']) && isset($_GET['code']))) {
  if (isset($_POST['submitFromResetPassword'])) {
    ob_start();
    $servername = "localhost";
    $username = "u647272286_swe2023";
    $password = "Heoboy123$%^&*(";
    $db_name = "u647272286_swe";
    $conn = new mysqli($servername, $username, $password, $db_name);
    if ($conn->connect_error) {
      die("connection failed" . $conn->connect_error);
    }
    $pass = $_POST['pass'];
    $email = $_POST['secretValue1'];
    $code = $_POST['secretValue2'];
    $code = $code / 2;
    $sql = "UPDATE Users SET password='$pass' WHERE email= '$email' AND code = $code AND EmailStatus = 1";
    $conn->query($sql);
    $sql = "UPDATE Users SET code = NULL WHERE code = $code";
    $conn->query($sql);
    ob_end_flush();
    mysqli_close($conn);
    header("Location: https://melvin-projects.com/RainCheck_SWE_Project/index.html");
    exit();
  }
} else {
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
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script>
    function validatePassword() {
      const password = document.getElementsByName("pass")[0];
      const confirmPassword = document.getElementsByName("confirmPass")[0];
      const passwordRequirements =
        /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

      if (
        !passwordRequirements.test(password.value) ||
        !passwordRequirements.test(confirmPassword.value)
      ) {
        alert(
          "Password and Confirm Password must be at least 8 characters long, contain one upper case letter, one lower case letter, one number, and one special character."
        );
        return false;
      }

      if (password.value !== confirmPassword.value) {
        alert("Password and Confirm Password do not match.");
        return false;
      }

      return true;
    }

    function validateForm() {
      return validatePassword();
    }

    function updateRequirements() {
      const password = document.getElementsByName("pass")[0].value;
      const confirmPassword = document.getElementsByName("confirmPass")[0].value;
      const requirements = {
        length: /(?=.{8,})/,
        lowerCase: /(?=.*[a-z])/,
        upperCase: /(?=.*[A-Z])/,
        number: /(?=.*\d)/,
        specialChar: /(?=.*[!@#$%^&*])/,
      };

      for (const key in requirements) {
        const reqElement = document.getElementById(key);
        if (requirements[key].test(password)) {
          reqElement.classList.add("matched");
          reqElement.classList.remove("not-matched");
        } else {
          reqElement.classList.add("not-matched");
          reqElement.classList.remove("matched");
        }
      }

      const confirmPasswordElement = document.getElementById("confirm-password");
      if (password === confirmPassword && confirmPassword !== '') {
        confirmPasswordElement.classList.add("matched");
        confirmPasswordElement.classList.remove("not-matched");
      } else {
        confirmPasswordElement.classList.add("not-matched");
        confirmPasswordElement.classList.remove("matched");
      }
    }
  </script>
</head>

<body class="ResetPasswordPage">
  <div class="Left"><img src="./Logo.png" alt="Logo" /></div>
  <form class="sign-up-form ResetPassword" action="ResetPassword.php" name="ResetPassword" method="POST" onsubmit="return validateForm()">
    <img src="./Brand-Logo.png" alt="Brand Logo" />
    <h1>Reset Password</h1>
    <input type="password" name="pass" placeholder="New Password" oninput="updateRequirements()" required />
    <ul style="width: 218.64px" class="password-requirements">
      <li id="length" class="not-matched">8 characters minimum</li>
      <li id="upperCase" class="not-matched">One uppercase letter</li>
      <li id="lowerCase" class="not-matched">One lowercase letter</li>
      <li id="number" class="not-matched">One number</li>
      <li id="specialChar" class="not-matched">
        One special character (!@#$%^&*)
      </li>
    </ul>
    <input type="password" name="confirmPass" placeholder="Confirm Password" oninput="updateRequirements()" required/>
    <ul class="password-requirements">
      <li id="confirm-password" class="not-matched">
        Confirm password match password
      </li>
    </ul>
    <input type="submit" id="btn" value="Reset" name="submitFromResetPassword" />
    <input type="hidden" name="secretValue1" value="<?PHP $email = $_GET['email'];
                                                    echo $email; ?>">
    <input type="hidden" name="secretValue2" value="<?PHP $code = $_GET['code'];
                                                    echo $code; ?>">
  </form>
</body>

</html>
