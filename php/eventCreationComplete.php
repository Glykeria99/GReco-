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
      echo '<a href="login.php" id="login">Σύνδεση</a>';
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
        <a class="active" href="homepage.php">Αρχική</a>
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
      }
      else
      {
      echo '<a href="profile.php?UserID=' . $_SESSION["ID"] . '" id="icon"><img class="avatar" src="./images/profileicon.jpg" /></a>';
      echo '<a href="logout.php" id="login">Αποσύνδεση</a>';
      }


      if(isset($_GET['eventID']))
        {
          $EventID = intval($_GET['eventID']);
        }
if(isset($_POST['eventID']))
        {
          $EventID = intval($_POST['eventID']);
        }
      ?>
        <a href="EventCreation.php" id="create">Δημιουργία Event</a>
     </div>
  
  <div class="welcome">
    <h1>ΤΟ ΕVENT ΣΟΥ ΕΧΕΙ ΔΗΜΙΟΥΡΓΗΘΕΙ!</h1>
    <p>Μπορείς να βρείς το event σου στο προφιλ σου ή στην σελίδα αναζήτησης event.</p>
  </div>
  <?php
      

    $sql = "SELECT ID FROM event WHERE ID=$EventID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      $row = $result->fetch_assoc();
    echo'<div class="question">
      <h4>Πατα <a href="eventpage.php?eventID=' . $row['ID'] . '">εδω</a> για να δεις το event σου.</h4>
      </div>';
      }      
  ?>
</body>
</html>