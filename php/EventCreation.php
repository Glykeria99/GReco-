<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GReco | Δημιουργία Event</title>
  <link rel="stylesheet" type="text/css" href="./stylesheets/styleForEventForm.css">
  <link rel='icon' href='./images/favicon.png' type='image/x-icon'/ >
  <script src="./js/eventForm.js"></script>
</head>

<script>
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
           include("config.php");
        ?>
  <a href="homepage.php"><img src="./images/grecogreen.png" class="logo"></a>

<!-- RESPONSIVE NAVIGATION MENU -->

 <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="topnavmobile" style="display: none;">
  <div class="bar">
     <form action="search.php" method="POST">
   <input style="float: right;"type="text" placeholder="Αναζήτηση..."  name="search"></input>
 </form>
  </div>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
   <a href="about.php">Αρχική</a>
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

<!-- -------------------- -->
  <div class="topnav">
        <a href="homepage.php">Αρχική</a>
      <a href="about.html">Σχετικά με εμάς</a>
        <a href="contactform.php">Επικοινωνία</a>
        <a href="EventsFullList.php">Όλα τα Event</a>
        <a href="Forum.php" target="_blank">Forum</a>
        <form action="search.php" method="POST">
      <input type="text" placeholder="Αναζήτηση..." name="search">
      </form> 
        <?php

      if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
      {
      echo '<a href="login.php" id="login">Σύνδεση</a>';
      echo "<script> location.href='login.php'; </script>";
      }
      else
      {
      echo '<a href="profile.php?UserID=' . $_SESSION["ID"] . '" id="icon"><img class="avatar" src="./images/profileicon.jpg" /></a>';
      echo '<a href="logout.php" id="login">Αποσύνδεση</a>';
      }
      ?>
        <a href="EventCreation.php" id="create">Δημιουργία Event</a>
     </div>
  
  <div class="welcome">
    <h1><strong>Δημιουργησε</strong> το δικο σου εθελοντικο event</h1>
    <p>Επέλεξε εναν Στόχο Βιώσυμης Ανάπτυξης να υποστηρίξεις, μια τοποθεσία και μερικές πληροφορίες και είσαι έτοιμος!</p>
  </div>

  <form onsubmit="setSDG()" method="POST">

  <div class="question">
    <h4>Επελεξε SDG:</h4>

    <div class="answer">
      <img src="./images/goal13.png" id="goal13" onclick="stayActive(id)">
    </div>

    <div class="answer">
      <img src="./images/goal14.png" id="goal14" onclick="stayActive(id)">
    </div>

    <div class="answer">
      <img src="./images/goal15.png" id="goal15" onclick="stayActive(id)">
    </div>
  </div>


  <input type='hidden' name='sdg' id="sdg" value="" />


  <div class="question">
    <h4>Επελεξε τυπο Event:</h4>

    <select name="type" required>
          <option value="trees">Δεντροφύτευση</option>
          <option value="beaches">Καθαρισμός Ακτών</option>
          <option value="animals">Φροντίδα αδέσποτων ζώων</option>
          <option value="talk">Ενημέρωση</option>
          <option value="art">Καλλιτεχνικό event</option>
          <option value="workshop">Διαδραστικά Workshops</option>
          <option value="thrifting">Thrifting</option>
          <option value="other">Άλλο</option>
        </select>
  </div>

  <div class="question">
    <h4>Τιτλος του event:</h4>
    <input type="text" name="title" id="title" placeholder="Δώσε ένα τίτλο για το event σου..." required></input>
  </div>

  <div class="question">
    <h4>Περιγραφη:</h4>
    <textarea name="description" type="text" placeholder="Γράψε περιγραφή..." style="height:200px" required></textarea>
  </div>

  <div class="question">
    <h4>Τοποθεσία:</h4>
    <input type="text" id="location" name="location" placeholder="Γράψε τοποθεσία..." required></input>
  </div>

  <div class="question">
    <h4>Μερα και ωρα:</h4>
    <input type="datetime-local" name="time" required></input>
  </div>

  </div>
    <div class="sub">
      <h3>Εισαι ετοιμος να αλλαξεις τον κοσμο!</h3>
      <input name ="submitbtn" type="submit" class="submitbtn" value="Δημιουργια"></input>
    </div>
</form>

 <?php 
    $userID = $_SESSION["ID"] ;

    if (isset($_POST['submitbtn'])) {

       $result = mysqli_query($conn, "SELECT MAX(ID) FROM event");
        $maxid = mysqli_fetch_array($result);
        if(!isset($maxid[0])) 
        {
          $maxid[0]=0;
        }
        
        $newid =$maxid[0]+1;
       
        $sql = "INSERT INTO event (ID, UserID,  SDG ,Τύπος, Τίτλος,  Περιγραφή, Ημερομηνία, Τοποθεσία)
          VALUES ('$newid', '$userID','$_POST[sdg]','$_POST[type]','$_POST[title]','$_POST[description]','$_POST[time]','$_POST[location]')";
        $conn->query($sql);


            echo '<script> location.href="eventCreationComplete.php?eventID=' . $newid . '"; </script>';

    }
    ?>

    


</body>
</html>