<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./stylesheets/styleForSignUp.css">
    <title>GReco | Εγγραφή</title>
    <link rel='icon' href='./images/favicon.png' type='image/x-icon'>
    <script>
    function goBack()
    {
      window.history.back();
    }
     function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
    </script>
  </head>
  <body>       

    <a href="homepage.php"><img src="./images/grecogreen.png" class="logo"></a>
    
     <!-- RESPONSIVE NAVIGATION MENU -->

 <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="topnavmobile" style="display: none;">
  <div class="bar">
     <form action="search.php" method="POST">
   <input style="float: right;"type="text" placeholder="Αναζήτηση..." name="search"></input>
 </form>
  </div>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
       <a href="homepage.php">Αρχική</a>
        <a href="about.php">Σχετικά με εμάς</a>
        <a href="contactform.php">Επικοινωνία</a>
        <a href="EventsFullList.php">Όλα τα Event</a>
        <a href="Forum.php" target="_blank">Forum</a>
        <a href="EventCreation.php">Δημιουργία Event</a>
        <?php
      session_start();
      if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
      {
      echo '<a href="login.php">Σύνδεση</a>';
      }
      else
      {
      echo '<a href="profile.php?UserID=' . $_SESSION["ID"] . '" >Λογαριασμός</a>';
      echo '<a href="logout.php">Αποσύνδεση</a>';
      }
      ?>
  </div>
   <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

    <div class="topnav">
      <a  href="homepage.php">Αρχική</a>
      <a href="about.php">Σχετικά με εμάς</a>
      <a href="contactform.php">Επικοινωνία</a>
      <a href="Forum.php" target="_blank">Forum</a>
      <form action="search.php" method="POST">
      <input type="text" placeholder="Αναζήτηση..." name="search">
      </form> 
      <a href="login.php" id="login">Σύνδεση</a>
      <a href="EventCreation.php" id="create">Δημιουργία Event</a>
    </div>

    <div class="text">
      <h1>Εγγραφή</h1>
      <p>Παρακαλώ, συμπληρώστε την φόρμα για να δημιουργήσετε λογαριασμό.</p>
    </div>

   
  <div class="container">

    <?php

      //Is user alredy logged in?
      if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
      {
        echo '<script>goBack();</script>';
        exit;
      }

      include("config.php");

      $username = $email = $pass = $passConfirm = "";
      $username_err = $email_err = $pass_err = $passConfirm_err = "";
      $errorMsg = "";

      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        //Checks if Email is empty
        if(empty(trim($_POST["email"])))
        {
          $email_err = "Παρακαλώ εισάγετε ένα email.";
        }
        else
        {
          $email = trim($_POST["email"]);
        }

        //Checks if Username is empty
        if(empty(trim($_POST["username"])))
        {
          $username_err = "Παρακαλώ εισάγετε ένα όνομα χρήστη.";
        }
        else
        {
          $username = trim($_POST["username"]);
        }
        
        //Checks if Password is empty
        if(empty(trim($_POST["psw"])))
        {
          $pass_err = "Παρακαλώ εισάγετε έναν κωδικό.";
        }
        else
        {
          $pass = trim($_POST["psw"]);
        }

        //Checks if Confirm Password is empty
        if(empty(trim($_POST["pswrepeat"])))
        {
          $passConfirm_err = "Παρακαλώ εισάγετε ξανά τον κωδικό.";
        }
        else
        {
          $passConfirm = trim($_POST["pswrepeat"]);
        }

        //Checks if passwords fields are same
        if($pass != $passConfirm)
        {
          $pass_err = $passConfirm_err = "Τα πεδία των κωδικών δεν ταιριάζουν";
        }

        //Check if user already exist
        $userQuery = "SELECT * from user WHERE username = '" . $username . "'";
        $userRes = mysqli_query($conn, $userQuery);
        if(mysqli_num_rows($userRes) > 0)
        {
          $username_err = "Υπάρχει ήδη λογαριασμός με αυτό το όνομα χρήστη";
        }

        //If no errors occured
        if(empty($email_err) && empty($username_err) && empty($pass_err) && empty($passConfirm_err))
        {
          $insertQuery = "INSERT INTO user (ID, Username, Password, Email, Avatar, Τύπος, Τίτλος, Bio) 
          VALUES (NULL, '" . $username . "', '" . $pass . "', '"  . $email . "', NULL, 'User', NULL, NULL)";
          if(mysqli_query($conn, $insertQuery))
          {
            $userIDQuery = "SELECT ID from user WHERE username = '". $username . "'";
            $userIDRes = mysqli_query($conn, $userIDQuery);
            $userID = mysqli_fetch_assoc($userIDRes)["ID"];
            $_SESSION["loggedin"] = true;
            $_SESSION["ID"] = $userID;
            $_SESSION["username"] = $username;
            header("Location: homepage.php");
            exit;
          }
          else
          {
            $errorMsg = "Κάτι πήγε στραβά";
          }
        }
      }
    ?>


  <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">

    <label style="margin-top: 22px; display: inline-block;"><b>Email</b></label>
    <input id="email" type="email" placeholder="Συμπληρώστε Email" name="email" required> </input>
    <div class="help-block"><?php echo $email_err; ?></div>

    <label for="username" style="margin-top: 22px; display: inline-block;"><b>Όνομα Χρήστη</b></label>
    <input id="username" type="text" placeholder="Συμπληρώστε Όνομα Χρήστη" name="username" required></input>
    <div class="help-block"><?php echo $username_err; ?></div>

    <label for="psw" style="margin-top: 22px; display: inline-block;"><b>Κωδικός</b></label>
    <input type="password" placeholder="Συμπληρώστε Κωδικό" name="psw" required></input>
    <div class="help-block"><?php echo $pass_err; ?></div>

    <label for="psw-repeat" style="margin-top: 22px; display: inline-block;"><b>Επαναλάβετε Κωδικό</b></label>
    <input type="password" placeholder="Επαναλάβετε Κωδικό" name="pswrepeat" required></input>
    <div class="help-block"><?php echo $passConfirm_err; ?></div>
    <hr>

    <p>Δημιουργόντας λογαριασμό, συμφωνείτε με την <a href="#">Πολιτική Απορρήτου & Όροι Χρήσης</a>.</p>
    
    <div class="container login">
      <input name ="registerbtn" type="submit" class="registerbtn" value="Εγγραφή"></input>
      <span><?php echo $errorMsg;?></span>
      <p>Έχετε ήδη λογαριασμό; <a href="login.php">Log in</a>.</p>
    </div>

  </form>


  </div>

  
</body>
</html>
