<!DOCTYPE html>
<html>
    <head>
        <title>GReco | Προφίλ</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="./stylesheets/social-icons.css">
        <link rel="stylesheet" type="text/css" href="./stylesheets/profile-style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="./js/profile.js"></script>
        <link rel='icon' href='./images/favicon.png' type='image/x-icon'>
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
    <body onload="profile();">


        <a href="homepage.php"><img src="./images/grecogreen.png" class="logo"></a>


 <!-- RESPONSIVE NAVIGATION MENU -->

 <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="topnavmobile" style="display: none;">
  <div class="bar">
    <form action="search.php" method="POST">
   <input id ="search"style="float: right;"type="text" placeholder="Αναζήτηση..." name="search"></input>
</form>
  </div>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
       <a class="active" href="homepage.php">Αρχική</a>
        <a href="about.php">Σχετικά με εμάς</a>
        <a href="contactform.php">Επικοινωνία</a>
         <a href="EventsFullList.php">Όλα τα Event</a>
        <a href="Forum.php" target="_blank">Forum</a>
        <?php
        session_start();

        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
        {
          echo '<a href="login.php" id="login">Σύνδεση</a>';
        }
        else
        {
            echo '<a href="profile.php?UserID=' . $_SESSION["ID"] . '">Λογαριασμός</a>';
          echo '<a href="logout.php">Αποσύνδεση</a>';
        }
        ?>
        <a href="EventCreation.php">Δημιουργία Event</a>
  </div>

  <!--  "Bar icon" to toggle the navigation links -->
  <a style="height: 19px !important;
width: 18px!important; "href="javascript:void(0);" class="icon1"  onclick="myFunction()">
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

      
                <?php
                if(isset($_GET['UserID']))
                    {
                $thisuserid = intval($_GET['UserID']);
                }
                

                if(isset($_POST['UserID']))
                    {
                $thisuserid = intval($_POST['UserID']);
                    }
                $currUserID= $thisuserid;
                if (isset($_SESSION['ID']) && $thisuserid==$_SESSION['ID']  ){
                    $currUserID= $_SESSION['ID'];

                echo '<div class="submenus">
                <button class="tablinks menu-butt" id="overview-menu" onclick="openTab('."'overview'".')"">Επισκόπηση</button><button class="tablinks menu-butt" id="acc-menu" onclick="openTab('."'account'".')">Λογαριασμός</button>
                </div>';
                }
                ?>
                
            <div id="overview" class="grid tabcontent">
                
                   <div id="bg-image">

                     <div class="row">

                        <div id="avatar">
                            <img id="icon" src="images/profileicon.jpg">
                        </div>


                    <?php 

                    include("config.php");
                    $sql = "SELECT * FROM user WHERE ID = " .$currUserID;
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    ?>      
        

                    <div  id="username">
                        <h1 id="user"> <?php echo $row['Username']; ?></h1> 
                    </div>
                    </div>
                    <div class="row">
                
                    <div id="pitch"><i class="glyphicon glyphicon-time"></i> 
                        <h3 id="pitch-text"><?php echo $row['Τίτλος']; ?></h3>
                    </div>
                
                </div>
               

                </div>

           <div class="container">

                <div id="biography">
                     <?php 
                     $sql = "SELECT user.Bio FROM user WHERE user.ID='$currUserID'";
                $result = $conn->query($sql);

                $row = $result->fetch_assoc();
                ?>
                    <span id="bio"><?php echo $row['Bio']?></span> 
                </div>
                
                <div id="post-history">
                    <label>Δημοσιεύσεις</label>
                </div>

                <div id="postlist">
                
            <?php

                $sql = "SELECT event.ID ,event.UserID, event.SDG, event.Τύπος, event.Τίτλος, event.Περιγραφή, event.Ημερομηνία,
event.Τοποθεσία FROM event WHERE UserID='$currUserID'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                     // output data of each row
                    while($row = $result->fetch_assoc()) {
                         
                        echo'<div class="post"><a style =" color: black; text-decoration: none;"class="postlink" href="eventpage.php?eventID=' . $row["ID"] . '"><div class="card"><img class="sdg-icon"';
                        if ($row['SDG']=='life below water') 
                            echo 'src="./images/goal14.png">';
                        else if ($row['SDG']=='life on land')
                            echo 'src="./images/goal15.png">';
                        else if($row['SDG']=='climate action')
                            echo 'src="./images/goal13.png">';
                        echo'<div class="title-cell"><h4 class="post-title">';
                        echo $row['Τίτλος'];
                        echo'</h4></div><div class="date-cell ';
                        if ($row['SDG']=='life below water') 
                            echo 'goal14';
                        else if ($row['SDG']=='life on land')
                            echo 'goal15';
                        else if($row['SDG']=='climate action')
                            echo 'goal13';
                        echo'"><div class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> ';
                        echo  substr($row['Ημερομηνία'], -17,8);
                        echo '</div></div></div></a></div>';

                    } 
                }
                else 
                    echo "<label style='margin-left:4px;'>Χωρίς Δημοσιεύσεις.</label>";
            
            ?>
                <div id="event-history">
                    <label>Συμμετοχές</label>
                </div>

                <div id="enteredlist">
                
            <?php

                $sql = "SELECT event.ID ,event.UserID, event.SDG, event.Τύπος, event.Τίτλος, event.Περιγραφή, event.Ημερομηνία,event.Τοποθεσία FROM event JOIN user_participated_on_event ON user_participated_on_event.EventID= event.ID WHERE user_participated_on_event.UserID='$currUserID' ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                     // output data of each row
                    while($row = $result->fetch_assoc()) {
                         
                        echo'<div class="post"><a style =" color: black; text-decoration: none;"class="postlink" href="eventpage.php?eventID=' . $row["ID"] . '"><div class="card"><img class="sdg-icon"';
                        if ($row['SDG']=='life below water') 
                            echo 'src="./images/goal14.png">';
                        else if ($row['SDG']=='life on land')
                            echo 'src="./images/goal15.png">';
                        else if($row['SDG']=='climate action')
                            echo 'src="./images/goal13.png">';
                        echo'<div class="title-cell"><h4 class="post-title">';
                        echo $row['Τίτλος'];
                        echo'</h4></div><div class="date-cell ';
                        if ($row['SDG']=='life below water') 
                            echo 'goal14';
                        else if ($row['SDG']=='life on land')
                            echo 'goal15';
                        else if($row['SDG']=='climate action')
                            echo 'goal13';
                        echo'"><div class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> ';
                        echo  substr($row['Ημερομηνία'], -17,8);
                        echo '</div></div></div></a></div>';

                    } 
                }
                else 
                    echo "<label>Δεν υπάρχουν σεμμετοχές σε events.</label>";
            
            ?>
      

               
                </div>


                <span class="redundant" id="frt"></span>

                <div class="grid-item" id="contact">
                    <label style="margin:8px;">Επικοινωνία</label>
                </div>

                <div style="padding: 5px;"class="social-icons">
                    <a href="https://el-gr.facebook.com/"class="fa fa-facebook icon-border"></a>
                    <a href="https://twitter.com/explore"class="fa fa-twitter icon-border"></a>
                    <a href="https://www.instagram.com/?hl=el"class="fa fa-instagram icon-border"></a>
                    <a href="https://www.linkedin.com/"class="fa fa-linkedin icon-border"></a>
                    <a href="https://www.google.gr/?hl=el"class="fa fa-google icon-border"></a>
                </div>

                
         
        </div>
            </div>
                </div>


            
            <div id="account" class="grid-acc tabcontent">

                <span class="redundant" id="fif"></span>

                <div id="set-header">
                    <h1 id="set-text">Ρυθμίσεις Λογαριασμού</h1>
                </div>

                <div class="header" id="username-header">
                    <label class="text" id="username-text">Όνομα Χρήστη & Τίτλος</label>
                </div>

                <label class="current" id="cur-username">Όνομα</label>
                
                <div id="username-settings">
                    <form method="post">
                    <?php  
                        $sql = "SELECT user.Username FROM user WHERE user.ID='$currUserID'";
                        $result = $conn->query($sql);

                        $row = $result->fetch_assoc();
      
                        echo'<input name = "username-field" class="field" id="username-field" type="text" value="';
                        echo $row['Username'];
                        echo'" disabled>';
                    ?>

                    <input onclick="Edit('username-edit-butt','username-field','username-edit-input');" class="edit-butt"  value="Επεξεργασία" id="username-edit-butt" type="button" style="display:inline-block;" />
                     <input  class="edit-butt" name="username-sub" value="Υποβολή" id="username-edit-input" type="submit" style="display:none;" />
                    <?php
                    if (isset($_POST['username-sub'])) {
                        $Username=$_POST['username-field'];
                        echo $Username;
                        $sql = "UPDATE user SET Username = '$Username' WHERE ID = $currUserID";
                        $conn->query($sql);
                        echo "<meta http-equiv='refresh' content='0'>";
                        }
                        ?>
        
                </div>
                <label class="current" id="cur-pitcher">Τίτλος</label>

                <div id="pitcher-settings">
                    <form method="post">
                    <?php  
                        $sql = "SELECT user.Τίτλος FROM user WHERE user.ID='$currUserID'";
                        $result = $conn->query($sql);

                        $row = $result->fetch_assoc();
                    echo '<input name="pitcher-field"class="field" id="pitcher-field" type="text" value="';
                    echo $row['Τίτλος'];
                    echo '" disabled>';
                    ?>
                    <input onclick="Edit('pitcher-edit-butt','pitcher-field','pitcher-edit-input');" class="edit-butt" id="pitcher-edit-butt" type="button" style="display:inline-block;" value="Επεξεργασία" />
                    <input name="pitcher-edit-input"class="edit-butt" id="pitcher-edit-input" value = "Υποβολή"type="submit" style="display:none;"/>
                </form>

                 <?php
                    if (isset($_POST['pitcher-edit-input'])) {
                        $pitcher=$_POST['pitcher-field'];
                        $sql = "UPDATE user SET Τίτλος = '$pitcher' WHERE ID = $currUserID";
                        $conn->query($sql);
                        echo "<meta http-equiv='refresh' content='0'>";
                        }
                        ?>
                </div>

                <span class="redundant" id="six"></span>
                
                <div class="header" id="address-header">
                    <label class="text" id="address-text">Διεύθυνση Email & Κωδικός</label>
                </div>

                <span class="redundant" id="sev"></span>

                <label class="current" id="cur-address">Email</label>

                <div id="address-settings">
                    <form method="post">
                    <?php    $sql = "SELECT user.Email FROM user WHERE user.ID='$currUserID'";
                        $result = $conn->query($sql);

                        $row = $result->fetch_assoc();
      
                    echo '<input name ="adress-field" class="field" id="address-field" type="text" value="';
                    echo $row['Email'];
                    echo '" disabled>';
                    ?>
                    <input onclick="Edit('address-edit-butt','address-field','address-edit-input');" class="edit-butt" id="address-edit-butt" type="button" value="Επεξεργασία" style="display:inline-block;"/>
                    <input name="adress-edit-input"  class="edit-butt" id="address-edit-input" type="submit" value="Υποβολή"style="display:none;"/>
                    </form>
                    <?php
                    if (isset($_POST['adress-edit-input'])) {
                        $email=$_POST['adress-field'];
                        $sql = "UPDATE user SET Email = '$email' WHERE ID = $currUserID";
                        $conn->query($sql);
                        echo "<meta http-equiv='refresh' content='0'>";
                        }
                        ?>

                </div>

                <label class="current" id="cur-pw">Κωδικός</label>

                <div id="password-settings">
                <form method="post">
                    <?php
                    $sql = "SELECT user.Password FROM user WHERE user.ID='$currUserID'";
                    $result = $conn->query($sql);

                    $row = $result->fetch_assoc();
                    ?>
                    <input name ="pw-field"class="field" id="pw-field" type="password" value="<?php echo $row["Password"]?>" disabled>
                    <input onclick="Edit('pw-edit-butt','pw-field','pw-edit-input');" class="edit-butt" id="pw-edit-butt" type="button" value="Επεξεργασία" style="display: inline-block;" />
                     <input name="pw-edit-input" class="edit-butt" id="pw-edit-input" type="submit" value="Υποβολή" style="display:none" />
                 </form>

                   <?php
                    if (isset($_POST['pw-edit-input'])) {
                        $password=$_POST['pw-field'];
                        $sql = "UPDATE user SET Password = '$password' WHERE ID = $currUserID";
                        $conn->query($sql);
                        echo "<meta http-equiv='refresh' content='0'>";
                        }
                        ?>
                </div>

                <label class="current" id="cur-bio">Bio</label>

                <div id="bio-settings"> 
                    <form method="post">
                    <?php    $sql = "SELECT user.Bio FROM user WHERE user.ID='$currUserID'";
                        $result = $conn->query($sql);

                        $row = $result->fetch_assoc();
      
                    echo '<input  class="field" name="bio-field" id="bio-field" value="';
                    echo $row['Bio'];
                    echo '" disabled></input>';
                    ?>

                    <input onclick="Edit('bio-edit-butt','bio-field','bio-edit-input');" class="edit-butt" id="bio-edit-butt" type="button" value="Επεξεργασία" style="display: inline-block;" />
                     <input name="bio-edit-input" class="edit-butt" id="bio-edit-input" type="submit" value="Υποβολή" style="display: none;" />
                 </form>
                    <?php
                        if (isset($_POST['bio-edit-input'])) {
                            $bio=$_POST['bio-field'];
                            $sql = "UPDATE user SET Bio = '$bio' WHERE ID = $currUserID";
                            $conn->query($sql);
                            echo "<meta http-equiv='refresh' content='0'>";
                        }
                    ?>

                </div>
                
            </div>

        </div>  

   <footer class="footer-distributed">
      <div class="footer-left">
        <h3>About <span>GReco</span></h3>

        <p class="footer-links">
          <a href="homepage.php">Home</a>
          |
          <a href="about.html">Σχετικά με εμάς</a>
          |
          <a href="contactform.html">Επικοινωνία</a>
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
