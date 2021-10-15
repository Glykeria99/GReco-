<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>GReco | Σχετικά με εμάς</title>
  <link rel="stylesheet" type="text/css" href="./stylesheets/about.css">
  <link rel='icon' href='./images/favicon.png' type='image/x-icon'/>
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
   <input style="float: right;"type="text" placeholder="Αναζήτηση..."  name="search"></input>
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
        include("config.php");
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
        <a class="active" href="about.php">Σχετικά με εμάς</a>
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
        ?>
        <a href="EventCreation.php" id="create">Δημιουργία Event</a>
     </div>

  <div class="background">
    <p class="title">Σχετικά με εμάς</p>
  </div>
  
  <div class="about-container">
  
    <p class="about"> Η GReco αποτελείται απο μια ομάδα 4 ατόμων στην Θεσσαλονίκη, η οποία ξεκίνησε την δημιουργία αυτού του ιστοτόπου με σκοπό την δραστηριοποίηση πάνω στην κλιματική αλλαγή, ό,τι έχει να κάνει σχετικά με την ζωή στη γή, αλλα και στο νερό. </p>
    <p class="about"> Πιο συγκεκριμένα, στον ιστότοπο αυτό υπάρχει δυνανότητα δημιουργίας και οργάνωσης εκδηλώσεων απο τον καθένα με θέμα οποιοδήποτε απο τα παραπάνω. </p>
    <p class="about"> Καλούμε λοιπον, όλους εσάς να κινητοποιηθείται και να μας βοηθήσετε στο έργο μας. </p>
    <p class="about">Πιο κάτω παραθέτουμε κάποιους απο τους τρόπους με τους οποίους βοηθάμε, έστω και λίγο, τη φύση. </p>
  </div>
  
  <div class="container">

    <div class="row">

      <div class="col">
        <figure>
          <h3 class="titles"> Δεντροφύτευση </h3>
          <div class ="images">
            <img src="./images/dentrofitefsi.jpeg">
          </div>
          <figcaption>Τα δέντρα αποτελούν ένα από μεγαλύτερα εφόδια της φύσης. Γι’ αυτό, δράσεις όπως η δεντροφύτευση αποτελούν μια απο τις πιό σημαντικές περιβαλλοντολογικές κινήσεις και βοηθούν καθοριστικά τον πλανήτη γη να ανασάνει με αυτοπεποίθηση. </figcaption>
        </figure>
      </div> 
    
      <div class="col">
        <figure>
          <h3 class="titles"> Καθαρισμός Ακτών </h3>
          <div class ="images">
            <img src="./images/katharismos.jpg">
          </div>
          <figcaption>Είναι πολύ σημαντικό να διατηρούμε τις ακτές μας καθαρές καθώς με την ύπαρξη πάσης φύσεως σκουπιδιών σε αυτές, υπάρχει μεγάλη πιθανότητα ρύπανσης, πράγμα µοιραίο για αρκετούς θαλάσσιους οργανισµούς. 
          </figcaption>
        </figure>
      </div>
      <div class="col">
        <figure>
          <h3 class="titles"> Φροντίδα αδέσποτων ζώων </h3>
         <div class ="images">
          <img src="./images/skilia.jpg">
         </div>
         <figcaption>Τα αδέποτα ζώα αποτελούν και αυτά μέρος της ζωής στη γή. Είναι καθήκον μας να τα προστατεύουμε και να τα φροντίζουμε.</figcaption>
        </figure>
      </div>
    </div>
    
    <div class="row">

     <div class="col">
       <figure>
        <h3 class="titles"> Ενημέρωση </h3> 
         <div class ="images">
            <img src="./images/awareness.jpeg">
         </div>
         <figcaption>Αρκετά σηματική είναι και η κινητοποιήση στους δρόμους με διάφορες διαδηλώσεις με στόχο την αφύπνιση για τις συνέπειες της κλιματικής αλλαγής στην χώρα μας.</figcaption>
       </figure>
      </div>
     
    
      <div class="col">
        <figure>
          <h3 class="titles"> Καλλιτεχνικό event </h3>
          <div class ="images">
           <img src="./images/trashcan.jpg">
          </div>
          <figcaption>Η διοργάνωση διάφορων θεατρικών παραστάσεων ή και προβολή ταινιών με θέμα την κλιματική αλλαγή, μπορεί να συμβάλλει στην κινητοποίηση των πολιτών. </figcaption>
        </figure>
      </div>
      <div class="col">
        <figure>
          <h3 class="titles">Διαδραστικά Workshops </h3>
         <div class ="images">
          <img src="./images/plant.jpeg">
         </div>
         <figcaption>Ένας άλλος τρόπος που μπορεί να βοηθήσει στην αφύπνιση των πολιτών έιναι η οργάνωση διάφορων εκπαιδευτικών προγραμμάτων, τα οποία περιέχουν πρακτικά παραδείγματα για την κλιματική δραστηριοποίηση.</figcaption>
        </figure>
      </div>     
    </div>

    <div class="row">
   
      <div class="col">
        <figure>
          <h3 class="titles"> Thrifting </h3>
         <div class ="images">
          <img src="./images/thrifting.jpeg">
         </div>
         <figcaption>To thrifting είναι ένας πολύ καλός τρόπος ανακύκλωσης.Είναι μια δράση όπου οι άνρθωποι μπορούν να δωρίσουν ρούχα και ανικείμενα που δεν χρησιμοποιούν αλλο, αλλά και οι ίδοι να αγοράσουν.  Το thrifting αποτελεί ένα μεγάλο βήμα στην καταπολέμηση της γρήγορης μόδας, αλλα και στην μείωση του μεγέθους των απόβλητων.</figcaption>
        </figure>
      </div>
    </div>
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