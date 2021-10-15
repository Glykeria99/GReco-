<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GReco | Επικοινωνία</title>
  <link rel="stylesheet" type="text/css" href="./stylesheets/contactform.css">
  <script src="./js/contactform.js"></script>
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
   <input id ="search"style="float: right;"type="text" placeholder="Αναζήτηση..."  name="search"></input>
  </div>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
    
        <a class="active" href="homepage.php">Αρχική</a>
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
        <a href="about.php">Σχετικά με εμάς</a>
        <a class="active" href="contactform.php">Επικοινωνία</a>
        <a href="EventsFullList.php">Όλα τα Event</a>
        <a href="Forum.php" target="_blank">Forum</a>
        <form action="search.php" method="POST">
      <input type="text" placeholder="Αναζήτηση..." name="search">
      </form> 
        <?php
        include("config.php");

        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
        {
          echo '<a href="login.php" id="login">Σύνδεση</a>';
        }
        else
        {  
          echo '<a href="profile.php?UserID=' . $_SESSION["ID"] . '" id="icon"><img class="avatar" src="./images/profileicon.jpg" /></a>';
          echo '<a href="logout.php" id="login">Αποσύνδεση</a>';
        }

        $name = $email = $subject = $text = "";
        $name_err = $email_err = $subject_err = $text_err = "";

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
          //Checks if Name is empty
          if(empty(trim($_POST["name"])))
          {
            $name_err = "Παρακαλώ εισάγετε το ονοματεπώνυμό σας.";
          }
          else
          {
            $name = trim($_POST["name"]);
          }

          //Checks if Email is empty
          if(empty(trim($_POST["email"])))
          {
            $email_err = "Παρακαλώ εισάγετε το email σας.";
          }
          else
          {
            $email = trim($_POST["email"]);
          }

          //Checks if Subject is empty
          if(empty(trim($_POST["subject"])))
          {
            $subject_err = "Παρακαλώ εισάγετε ένα θέμα.";
          }
          else
          {
            $subject = trim($_POST["subject"]);
          }

          //Checks if BodyText is empty
          if(empty(trim($_POST["text"])))
          {
            $text_err = "Παρακαλώ εισάγετε το μήνυμα που θα σταλεί.";
          }
          else
          {
            $text = trim($_POST["text"]);
          }

          if($name !='' && $email != '' && $subject != '' && $text != '')
          {
            ini_set("SMTP", "smtp.gmail.com");
            ini_set("smtp_port", "587");
            ini_set("sendmail_from", "wwwgrecogr@gmail.com");
            mail("wwwgrecogr@gmail.com", $subject, $text, "From: " . $email);  
          }
        }
        ?>

        
          <a href="EventCreation.php" id="create">Δημιουργία Event</a>
     </div>
  
       </div>
  <div class="background">
    <h1>Επικοινωνία</h1>
  </div>

  <div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <label>Ονοματεπώνυμο</label>
      <input type="text" id="fullname" name="name" placeholder="Το ονοματεπώνυμο σου.." required>
      <label>E-mail</label>
      <input type="text" id="email" name="email" placeholder="Το email σου.." required> 
      <label>Θέμα</label>
      <input type="text" id="subject" name="subject" placeholder="Θέμα.." required>
      <label>Κείμενο Μηνύματος</label>
      <textarea class="textarea" id="textarea" name="text" placeholder="Κείμενο.." style="height: 250px;" required></textarea>    
      <input type="submit" id="submit" name="submit" value="Υποβολή"></input>
    </form>
  </div>

  
    <footer class="footer-distributed">
 
      <div class="footer-left">
          
        <h3>About <span>GReco</span></h3>
 
        <p class="footer-links">
          <a href="homepage.php">Home</a>
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
          <i class="footer-links"></i>
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