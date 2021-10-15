<!DOCTYPE html>
<html>
	<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="./stylesheets/styleForHomepage.css">
		<title>GReco | Αρχική Σελίδα </title>
		<link rel='icon' href='./images/favicon.png' type='image/x-icon'/ >
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

<!-- -------------------- -->

		<div class="main">

		<div class="topnav">
  			<a class="active" href="homepage.php">Αρχική</a>
 			<a href="about.php">Σχετικά με εμάς</a>
  			<a href="contactform.php">Επικοινωνία</a>
  			<a href="EventsFullList.php">Όλα τα Event</a>
  			<a href="Forum.php" target="_blank">Forum</a>
  			<form action="search.php" method="POST">
			<input type="text" placeholder="Αναζήτηση..." name="search">
			</form> 
  		
  			<?php

			if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
			{
			echo '<a href="login.php"id="login">Σύνδεση </a>';
			}
			else
			{
			echo '<a href="profile.php?UserID=' . $_SESSION["ID"] . '" id="icon"><img class="avatar" src="./images/profileicon.jpg" /></a>';
			echo '<a href="logout.php" id="login">Αποσύνδεση</a>';
			}
			?>
  			<a href="EventCreation.php" id="create">Δημιουργία Event</a>
	   </div>

	   <div class="containerPhoto">
	   <img src="./images/bg.jpg" alt="">
  		<p class="motto">Η αλλαγή ξεκινά με εσένα.</p>
  		<p class="motto">Κάνε το πρώτο βημα.</p>
  		<h1 class="signup"><a class="signuplink" href="EventsFullList.php">Πάρε Mέρος</a></h1>
	   </div>
	   <div class="container">
  		<p>Στην GReco, θέλουμε να βοηθήσουμε οποιονδήποτε αναζητά να κάνει εθελοντισμό στην πόλη του σε events τα οποία συνισφέρουν στην προστασία του περιβάλλοντος. Ψάξε για events που έχουν δημιουργήσει άτομα σε όλη την Ελλάδα και συμμετέιχε, ή  δημιούργησε το δικό σου event! Η επιλογή είναι δική σου.</p>
  		<p>Παίρνουμε μέρος και υποστηρίζουμε τους Στόχους Βιώσυμης Ανάπτυξης του ΟΗΕ, συγκεκριμένα τους Στόχους 13 (Climate Change), 14 (Life Below Water) και 15 (Life on Land). </p>
	   </div>
	   <div class="textforevents">
	   	<h3>ΕΠΕΡΧΟΜΕΝΑ EVENT ΣΕ ΟΛΗ ΤΗΝ ΕΛΛΑΔΑ </h3>
	   </div>
	   <div class="events">

      <?php 
             include("config.php");
             $sql = "SELECT event.ID, event.UserID, event.SDG, event.Τύπος ,event.Τίτλος, event.Περιγραφή, event.Ημερομηνία,event.Τοποθεσία FROM event ORDER BY event.ID DESC LIMIT 6 OFFSET 0";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
              while($row = $result->fetch_assoc()) {
              echo '<div class="event filterDiv ';
              echo $row["SDG"];
              echo '"><a href="eventpage.php?eventID=' . $row["ID"] . '"><img src="./images/';
              echo $row["Τύπος"];
              echo '.jpg" /></a><img id="time" src="./images/time.png"/><p class="mins">';
              echo $row["Ημερομηνία"];
              echo '</p><a href="eventpage.php?eventID=' . $row["ID"] . '"><h2>';
              echo $row["Τίτλος"];
              echo ' - ';
              echo $row["Τοποθεσία"];
              echo '</h2></a></div>';  
                }
            } 
        ?>


        </div>



        <div class="textforevents">
	   	<h3><a id="findmore" href="EventsFullList.php">Βρές Περισσότερα...</a></h3>
	   </div>


        </div>
        

<footer>
	<div class="footer-distributed">

 
			<div class="footer-left">
          
				<h3>About <span>GReco</span></h3>
 
				<p class="footer-links">
					<a href="homepage.php">Αρχική</a>
					|
					<a href="about.php">Σχετικά με εμάς</a>
					|
					<a href="contactform.php">Επικοινωνία</a>
				</p>
 
				<p class="footer-company-name">© 2019 GReco Team.</p>
			</div>
 
			<div class="footer-center">
				<div>
					  <p><span>Αριστοτέλειο Πανεπιστήμιο Θεσσαλονίκης, Ελλάδα</p>
				</div>
 
				<div>
					<p>+30 000 0000 0</p>
				</div>
				<div>
					<p>support@greco.com</p>
				</div>
			</div>
			<div class="footer-right">
				<div class="footer-icons">
					<a href="https://el-gr.facebook.com/"><img src="./images/fb.png"></a>
          <a href="https://twitter.com/explore"><img src="./images/tw.png"></a>
          <a href="https://www.instagram.com/?hl=el"><img src="./images/insta.png"></a>
          <a href="https://www.linkedin.com/"><img src="./images/lnk.png"></a>
          <a href="https://www.youtube.com/?hl=el&gl=GR"><img src="./images/yt.png"></a>
				</div>
			</div>
		</footer>


	</body>

</html>