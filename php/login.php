<!DOCTYPE html>
<html>

<head>
    <title>GReco | Σύνδεση</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./stylesheets/login-form.css">
    <link rel='icon' href='./images/favicon.png' type='image/x-icon'>
</head>

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

<body>


    <?php
    
      session_start();
      include("config.php");

      //Is user alredy logged in?
      if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
      {
        echo '<script>goBack();</script>';
        exit;
      }

      $username = $password = "";
      $username_err = $password_err = "";

      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        // Check if username is empty
        if(empty(trim($_POST["username"])))
        {
          $username_err = "Παρακαλώ εισάγετε το όνομα χρήστη.";
        }
        else
        {
          $username = trim($_POST["username"]);
        }

        // Check if password is empty
        if(empty(trim($_POST["password"])))
        {
          $password_err = "Παρακαλώ εισάγετε τον κωδικό πρόσβασης.";
        } 
        else
        {
          $password = trim($_POST["password"]);
        }

        if(empty($username_err) && empty($password_err))
        {
          $userQuery = "SELECT ID, Password FROM user WHERE Username = ?";
          if($stmt = mysqli_prepare($conn, $userQuery))
          {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt))
            {
              mysqli_stmt_store_result($stmt);

              //Checks if user exist
              if(mysqli_stmt_num_rows($stmt) == 1)
              {
                mysqli_stmt_bind_result($stmt, $userID, $UserPassword);
                if(mysqli_stmt_fetch($stmt))
                {
                  if($password == $UserPassword)
                  {
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["ID"] = $userID;
                    $_SESSION["username"] = $username;
                    echo '<script>goBack();</script>';
                    exit;
                  }
                  else
                  {
                    $password_err = "Λάθος Κωδικός.";
                  }
                }
              }
              else
              {
                $username_err = "Ο λογαριασμός δεν βρέθηκε.";
              }
            }
            else
            {
              echo "Κάτι πήγε στραβά.";
            }
            mysqli_stmt_close($stmt);
          }
        }
        mysqli_close($conn);
      }
    ?>


    <a href="homepage.php"><img src="./images/grecogreen.png" class="logo"></a>


    <!-- RESPONSIVE NAVIGATION MENU -->

 <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="topnavmobile" style="display: none;">
  <div class="bar">
    <form method="post" action="search.php">
   <input style="float: right;"type="text" placeholder="Αναζήτηση..." id="search"name="search"></input>
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
        <a href="login.php">Σύνδεση</a>
  </div>

  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" id ="icon"class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<!-- -------------------- -->
    

    <div class="topnav">
        <a class="active" href="homepage.php">Αρχική</a>
      <a href="about.php">Σχετικά με εμάς</a>
        <a href="contactform.php">Επικοινωνία</a>
        <a href="EventsFullList.php">Όλα τα Event</a>
        <a href="Forum.php" target="_blank">Forum</a>
      <form action="search.php" method="POST">
      <input type="text" placeholder="Αναζήτηση..." name="search">
      </form>         <a href="login.php" id="login">Σύνδεση</a>
        <a href="EventCreation.php" id="create">Δημιουργία Event</a>
     </div>


    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="da-form">
        <div class="grid">

            <header class="grid-item" id="sign-in">
                <h1>Σύνδεση</h1>
            </header>
            
            <div class="grid-item" id="address-field">
                <label for="email">Όνομα Χρήστη</label> <br>
                <input class="blur" type="username" id="email" name="username" required>
                <span id="test2"style="color:#d13a30;"class="help-block"><br><?php echo $username_err; ?></span>
            </div>

            <div class="grid-item" id="pw-field">
                <label style="margin-top: -20px;" for="password">Κωδικός</label> <br>
                <input class="blur" type="password" id="password" name="password" required>
                <span id="test1"style="color:#d13a30; "class="help-block"><br><?php echo $password_err; ?></span>
            </div>

            <div class="grid-item" id="submit-butt">
                <input type="submit" id="submit" name="submit" value="Υποβολή">
            </div>

            <a id="sign-up" href="signUp.php">Δημιουργία Λογαριασμού</a>
            
        </div> 
    </form>
    
</body>

</html>