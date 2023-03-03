<?php
  /* Connect to database */
  ob_start(); //This is optional. require by our specific website host only.
  $servername = "localhost";
  $username="id20358687_softwareengineeringspring2023";
  $password= "Heoboy123$%^&*(";
  $db_name="id20358687_softwareengineering";
  $conn= new mysqli($servername, $username, $password, $db_name);
  if($conn->connect_error){
    die("connection failed".$conn->connect_error);
  }

  /* Store data into database*/
  if(isset($_POST['submit']))
  {
    $firstname_c =  $_POST['firstname'];
    $lastname_c =  $_POST['lastname'];
    $email_c =  $_POST['email'];
    $password_c = $_POST['pass'];
    $tel_c = $_POST['phonenumber'];
    $sql = "INSERT INTO Users (firstname, lastname, email,password,phonenumber) VALUES ('$firstname_c', '$lastname_c', '$email_c', '$password_c', '$tel_c')";

    if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
  ob_end_flush();
  mysqli_close($conn);
?>