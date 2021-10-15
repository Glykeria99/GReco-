<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>GReco | Event</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="./stylesheets/eventpage.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script  type="text/javascript" src="./js/eventpage.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel='icon' href='./images/favicon.png' type='image/x-icon'/>
</head>

<style>

</style>

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
    <form method="post" action="search.php">
   <input id ="search"style="float: right;"type="text" placeholder="Αναζήτηση..." name="search"></input>
 </form>
  </div>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
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

 if(isset($_GET['eventID']))
        {
          $EventID = intval($_GET['eventID']);
        }
if(isset($_POST['eventID']))
        {
          $EventID = intval($_POST['eventID']);
        }
  $sql = "SELECT user.ID, user.Username ,event.ID, event.UserID, event.SDG,event.Τίτλος, event.Περιγραφή, event.Ημερομηνία,event.Τοποθεσία, event.Τύπος FROM event JOIN user ON user.ID=event.UserID WHERE event.ID=$EventID";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc(); 
 
  echo '<div class="event-photo">
       <img src="./images/';
              echo $row["Τύπος"];
              echo 'event.jpg"> </div>';
              ?>
 
  <div class="container" type="Info">
    
    <div class="row">
      <div class="col-4 " style="float: left;">
        <?php 
        include("config.php"); 
           
        
        ?>
        <div class="date">
          <p class="header"><i class="glyphicon glyphicon-calendar"></i> <?php echo  substr($row['Ημερομηνία'], -17,8);?></p>
        </div>
        
        <div class="time">
         <p class="header"><i class="glyphicon glyphicon-time"></i> <?php echo  substr($row['Ημερομηνία'], -8,5);?> </p>
        </div>
      </div>
        <div class="col-4 " style="float: left;">
  
        <div class="location">
          <p class="header"><i class="glyphicon glyphicon-map-marker"></i> <?php echo $row['Τοποθεσία']; ?></p>
        </div>
        <div class="creator">
          <p class="header" >Διοργανωτής:<?php echo '<a href="profile.php?UserID=' . $row["UserID"] . '">'?> <?php echo $row['Username']; ?></a> </p>
          </div>
        </div>


        
      <div class="col-4">
    
        <div class="event-type">
          <h3> 
            <?php 
              if ($row['SDG']=='life below water') 
                echo '<img src="./images/goal14.png">';
              else if ($row['SDG']=='life on land')
                echo '<img src="./images/goal15.png">';
              else if($row['SDG']=='climate action')
                echo '<img src="./images/goal13.png">';
            ?> 
          </h3>
        </div>
      
      </div>

      <div class="col-4 " style="float: left;">
            <?php

            if (isset($_SESSION["ID"])){

            $userTypeQuery = "SELECT Τύπος FROM user WHERE ID = " . $_SESSION["ID"];
            $userTypeRes = mysqli_query($conn, $userTypeQuery);
            $userType = mysqli_fetch_assoc($userTypeRes);
            if($userType["Τύπος"] == "Administrator" || $_SESSION["ID"] == $row["UserID"])
            { 
              echo '<form method="post"><input style="float:left;" name ="deleteEvent" type="submit" class= "enter" id="deleteEvent" onclick=" return DeleteEvent();" value="Διαγραφή Event" id="enterbutton"></input><input type="hidden" id="deleteconf" value="" /></form>';
            }

          }

          //delete post

          if (isset($_POST['deleteEvent'])) {
                  $del = "DELETE FROM  event WHERE event.ID = $EventID";
                  $resultdel = $conn->query($del);
                  echo "<script> location.href='EventsFullList.php'; </script>";
                }

            ?>
        </div> 
    </div>
 
 
    
    <div class="row"></div>
      <div class="title">
        <label><?php echo $row['Τίτλος']; ?></label>
      </div>
       
      <div class="description">
        <p><?php echo $row['Περιγραφή']; ?></p> 
      </div>

      <div class="container" id="enter-container" type="enter-container">
        <div class="row align-items-center">
          <div class=".col-1">

            <?php 
                if (isset($_SESSION["ID"])){
                  $currUserID = $_SESSION["ID"];
                  $sql = "SELECT user_participated_on_event.userID, user_participated_on_event.EventID FROM user_participated_on_event WHERE userID='$currUserID' AND EventID=$EventID";
                  $result = $conn->query($sql);
                  $row = $result->fetch_assoc();
                  if ($result->num_rows > 0) {
                    echo ' <form method="post"> <input style="float:left;" name ="enterbutton" type="submit"  class= "enter" value="Συμμετέχετε!" id="enterbutton"></input></form></div>';
                    }
                  else echo ' <form method="post"> <input style="float:left;" name ="enterbutton" type="submit" class= "enter" value="Συμμετοχή" id="enterbutton"></input></form>  </div>';
                  if (isset($_POST['enterbutton'])) {
                    $check= mysqli_query($conn, "SELECT userID,EventID FROM user_participated_on_event WHERE userID='$currUserID' AND EventID='$EventID'");
                    if (mysqli_num_rows($check) <= 0){
                    
        
                  $newid =$maxid[0]+1;
                  $sql = "INSERT INTO user_participated_on_event (ID, UserID, EventID)
                  VALUES (NULL,'$currUserID','$EventID')";
                  $conn->query($sql);
                  echo "<meta http-equiv='refresh' content='0'>";
                    }}
                $sql = "SELECT user_participated_on_event.userID, user_participated_on_event.EventID FROM user_participated_on_event WHERE userID='$currUserID' AND EventID=$EventID";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if ($result->num_rows > 0) {
                  echo '<div class=".col-10"><form method="post"> <input type="submit" style="float:left;"value="Ακύρωση" class= "cancel" id="cancelbutton" name="cancelbutton"></input></form></div>';           
                } 
              
                if (isset($_POST['cancelbutton'])) {
                  $currUserID = $_SESSION["ID"] ;
                  $sql = "DELETE FROM  user_participated_on_event WHERE user_participated_on_event.userID = '$currUserID'";
                  $result = $conn->query($sql);
                  echo "<meta http-equiv='refresh' content='0'>";
                }
              }
            else 
               echo '<div class=".col-1"> <a href="login.php"><input name ="enterbutton" type="submit"class= "enter" value="Συμμετοχή" id="enterbutton"></input></a></div>';

            ?>
        
          <div class=".col-1">

            <p style="float: right;"id="participants" class="num-of-participants"><?php echo "Θα πάνε: "; ?>
              <?php

                $sql ="SELECT count(*) AS sum FROM user_participated_on_event WHERE user_participated_on_event.EventID = '$EventID'";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) 
                echo $row['sum'];
?>              
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="container" type="comments-container">
    <div class="row">
  
      <div class="col-md-8">
    
        <h2 class="page-header">Σχόλια</h2>
        <div class="comment-list" id = "comment-list">
          
          <!-- Σχόλια -->
          <?php 
            
            $sql = "SELECT comment.Ημερομηνία, comment.ID AS comID, comment.Κείμενο, user.Username, user.ID FROM comment JOIN user ON user.ID=comment.userID WHERE EventID='$EventID'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            // output data of each row
              while($row = $result->fetch_assoc()) {
                $commentID=$row["comID"];
                echo '<div  type="commentrow" ><div class="col" style="float: left; margin-left: -40px;"><div class="panel-body"><figure class="thumbnail" style="float:left;"><img style="float:left; "class="avatar" src="./images/profileicon.jpg" />';
                echo'</figure> <header class="text-left"> <a href="profile.php?UserID=' . $row["ID"] . '" style="text-decoration: none;"><div class="username" style="float: left; margin-right: 10px; margin-left: -10px; margin-top: -19px;">';
                echo $row["Username"];
                echo '</div></a><i class="fa fa-clock-o" style="float:left; margin-left:0px; margin-top: -16px;"></i><div class="date" style="float: left; margin-left: 15px; margin-top: -19px;">';
                echo $row["Ημερομηνία"];
                echo '</div>';
                if (isset($_SESSION["ID"])){

                  $userTypeQuery = "SELECT Τύπος FROM user WHERE ID = " . $_SESSION["ID"];
                  $userTypeRes = mysqli_query($conn, $userTypeQuery);
                  $userType = mysqli_fetch_assoc($userTypeRes);
                if($userType["Τύπος"] == "Administrator" || $_SESSION["ID"] == $row["ID"])
                  { 

                  echo '<form method="post" action="">';
                  echo '<input type="hidden" name="comment_to_delete" value="'.$commentID.'">';
              
                  echo '<input style="float: left;margin-top: -19px;"onclick="return Delete();" name="deletebutton" id="deletebutton" type="submit" value="Διαγραφή"></input>
                  </form>';
                   }
              }

                  echo'</header><p class="comment-post" id ="comment-post" style="margin-top:9px;margin-right: -10px; margin-left: 10px;" >';
                echo $row["Κείμενο"];
                echo '</p></div></div>';
                
                

                echo '</div>';     

            }
            }

            else 
                echo "Χωρίς Σχόλια.";


               if (isset($_POST['deletebutton'])) {
                 
                  $commentid= $_POST['comment_to_delete'];

                $sql = "SELECT ID, UserID, EventID FROM comment WHERE EventID=$EventID AND ID=$commentid";
                $result = $conn->query($sql);
        
              if ($result->num_rows > 0) {

              while($row = $result->fetch_assoc()) {
                $comid=$row['ID'];       
                $sql= "DELETE FROM comment WHERE ID='$comid'";
                $result = $conn->query($sql);
                echo "<meta http-equiv='refresh' content='0'>";}
                
              }

            }
          ?>
          <template id="test1" type="commentrow" >
             
              <div class="col" style="float: left; margin-left: -40px;">
                
                <div class="panel-body">
                   <a href="profile.html" style="text-decoration: none; float: left;">
                    <figure class="thumbnail">
                      <img class="avatar" src="./images/avatar.jpg" />
                      <figcaption class="text-center">username</figcaption>
                   </figure>
                   </a>
                  <header class="text-left">
                    <div><i class="fa fa-clock-o" style="float: left; margin-right: 6px; margin-left: 3px; margin-top: 2px;"></i><p class="date"> 10/4/20</p></div>
                  </header>
                  <p class="comment-post" id ="comment-post" style="float: left;"> comment
                  </p>
                </div>
              </div>
            </template>
        </div>
      </div>
    </div>
  </div>
  <div class="container" type="new-comment">
    <div class="row">

      <h3>Γράψε ένα σχόλιο</h3>
    </div>
                      <!-- Δημιουργία σχόλιου-->
    <div class="row">
      <form  id="commentform"action="" method="post" onsubmit="return validateForm()">
        <div class="row">
          <?php
            echo '<div class="col"><a href="profile.html" style="text-decoration: none; float: left;"><figure class="thumbnail" style="border-style: none;width:70px; height: 80px; margin-left:11px;"><img class="avatar" style="margin-top:18px;"src="./images/profileicon.jpg" /></figure></a></div>'; 
          ?>
         <textarea name ="txt"class="textarea" id="txt"placeholder="Γράψε κάτι εδώ.." style="float: left;" required></textarea> 
        </div>
        <?php 
        if (isset($_SESSION["ID"]))
        echo '<div class="row"><input style="margin-left: 22px;"type="submit" name="submit" value="Αποστολή"> </input></div></form>';
        else 
          echo '</form><div class="row"> <a href="login.php"><input style="margin-left: 22px;"type="submit" name="submit" value="Αποστολή"> </input></a></div>';
        ?>
      
      <?php 
        $result = mysqli_query($conn, "SELECT MAX(ID) FROM comment");
        $maxid = mysqli_fetch_array($result);
        if(!isset($maxid[0])) 
        {
          $maxid[0]=0;
        }
        
        
        $newid =$maxid[0]+1;
        $date = date('Y-m-d H:i:s', time());
        if (isset($_POST['txt'])) {
          $txt=$_POST['txt'];
          $currUserID = $_SESSION["ID"];
          $sql = "INSERT INTO comment (ID, UserID, EventID,Ημερομηνία,  Κείμενο)
                  VALUES ('$newid', '$currUserID','$EventID','$date','$txt')";
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
