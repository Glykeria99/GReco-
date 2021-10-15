<!DOCTYPE html>
<html lang="el">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='icon' href='./images/favicon.png' type='image/x-icon'>
    <link rel="stylesheet" type="text/css" href="./stylesheets/Forum.css">
    <title>GReco | Forum</title>
  </head>

  <body>

    <a href="homepage.php"><img src="./logo/grecoblue.png" class="logo"></a>

    <nav>
      <div class="navbar">
        <a href="homepage.php">Αρχική</a>
        <a href="about.php" target="_blank">Σχετικά Με Εμάς</a>
        <a href="contactform.php" target="_blank">Επικοινωνία</a>
        <a href="Forum.php">Forum</a>
        <form class="navsearch" action="search.php" method="POST">
          <input class="navsearchbar" type="text" placeholder="Αναζήτηση στο greco..." name="search">
          <button class="navsearchbutton" type="submit">
            <svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25">
              <path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"/>
            </svg>
          </button>
        </form>
        <?php
        session_start();

        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
        {
          echo '<a href="login.php" class="login">Σύνδεση</a>';
        }
        else
        {
          echo '<a href="logout.php" class="login">Αποσύνδεση</a>';
        }

        /*Cookie Acceptance*/
        $cookieName = 'cookieAcceptance';
        if(!isset($_COOKIE[$cookieName]))
        {
          echo '
          <div class="cookie-consent" id="cookie-consent">
            <div class="cookie-consent-content">
              <label>Αυτός ο ιστότοπος χρησιμοποιεί cookies. </label>
              <button class="cookie-button" onClick="closecookieConsent()">OK</button>
            </div>
          </div>';
          $cookieAcceptance = true;
          setcookie($cookieName, $cookieAcceptance, time() + 10*365*24*60*60);
        }
        ?>  
      </div>
    </nav>

    <img class="forum-foto" src="./images/maountainlake.jpg">

    <div class="row">
      <div class="leftcolumn">
        <form class="search" action="Category.php" method="GET">
          <button class="searchbutton" type="submit">
            <svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25">
              <path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"/>
            </svg>
          </button>
          <input class="searchbar" type="text" placeholder="Αναζήτηση..." name="search">
        </form>

        <?php
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
        {
          echo '
        <a href="NewTopic.php"><button class="newtopic" type="submit">
          Έναρξη Νέας Συζήτησης
        </button></a>';
        }
        else
        {
          echo '
        <a href="login.php"><button class="newtopic" type="submit">
          Έναρξη Νέας Συζήτησης
        </button></a>';
        }
        
        include("config.php");

        $months = array("Ιανουαρίου", "Φεβρουαρίου", "Μαρτίου", "Απριλίου", "Μαΐου", 
        "Ιουνίου", "Ιουλίου", "Αυγούστου", "Σεπτεμβρίου", "Οκτωβρίου", "Νοεμβρίου", "Δεκεμβρίου");
        $categoriesQuery = "SELECT * FROM category";
        $categories = mysqli_query($conn, $categoriesQuery);
    
        if(mysqli_num_rows($categories) > 0)
        {
          while($category = mysqli_fetch_assoc($categories))
          {
            echo
            '<table class="card">
            <tr class="category">
              <td>
                <a href="Category.php' . '?categoryID=' . $category["ID"] .'" class="category-title">'. $category["Όνομα"] . '</a>
              </td>
              <td class="count-cell">';

              $numOfTopicsQuery = "SELECT COUNT(ID) FROM topic WHERE CategoryID = " . $category["ID"];
              $numOfTopicsres = mysqli_query($conn, $numOfTopicsQuery);
              $numOfTopics = mysqli_fetch_assoc($numOfTopicsres);

              echo "Θέματα: " . $numOfTopics["COUNT(ID)"];
              echo '
              </td>
            </tr> ';

            $topicsQuery = "SELECT * FROM topic WHERE CategoryID =" . $category["ID"];
            $topics = mysqli_query($conn, $topicsQuery);

            for($i = 0; $i < min(mysqli_num_rows($topics), 3); $i++)
            {
              $topic = mysqli_fetch_assoc($topics);
              echo
              '<tr>
              <td colspan="2" class="topic-title">
                <a href="TopicName.php?topicID=' . $topic["ID"] . '">' . $topic["Τίτλος"] . '</a>
                <div class="topic-date" style="float:right;"> ';

                $dateArr = explode('-', $topic["Ημερομηνία"]);
                $date = (int) $dateArr[2] . " " . $months[(int) $dateArr[1] - 1] . " " . $dateArr[0];
                
                echo $date . '</div>
                <svg fill="#999" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                width="14px" height="17px" viewBox="0 0 559.98 559.98" style="float: right; margin-right: 5px; enable-background:new 0 0 559.98 559.98;"
                xml:space="preserve">
                  <path d="M279.99,0C125.601,0,0,125.601,0,279.99c0,154.39,125.601,279.99,279.99,279.99c154.39,0,279.99-125.601,279.99-279.99
                    C559.98,125.601,434.38,0,279.99,0z M279.99,498.78c-120.644,0-218.79-98.146-218.79-218.79
                    c0-120.638,98.146-218.79,218.79-218.79s218.79,98.152,218.79,218.79C498.78,400.634,400.634,498.78,279.99,498.78z"/>
                  <path d="M304.226,280.326V162.976c0-13.103-10.618-23.721-23.716-23.721c-13.102,0-23.721,10.618-23.721,23.721v124.928
                    c0,0.373,0.092,0.723,0.11,1.096c-0.312,6.45,1.91,12.999,6.836,17.926l88.343,88.336c9.266,9.266,24.284,9.266,33.543,0
                    c9.26-9.266,9.266-24.284,0-33.544L304.226,280.326z"/>
                </svg>
              </td>
            </tr>';
            }
            
            echo '</table>';
          }
        }
        ?>    

      </div>     

      <div class="rightcolumn">
        <div class="rightcard">
          <h3 style="padding-bottom: 10px; border-bottom: rgb(4, 74, 121) 3px solid;">Ο Λογαριασμός Μου</h3>
          <?php 
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
          {
            echo '
            <a href="profile.php?UserID=' . $_SESSION["ID"] . '"><img class="avatar" src="./images/profileicon.jpg"></a>
            <div class="account-card">
              <p><a href="profile.php?UserID=' . $_SESSION["ID"] . '">' . $_SESSION["username"] . '</a></p>
              <a href="profile.php?UserID=' . $_SESSION["ID"] . '">Επεξεργασία</a>
            </div>';
          }
          else
          {
            echo '
            <div class="account-card">
              <p><a href="login.php">Σύνδεση</a></p>
              <a href="signUp.php">Δημιουργία</a>
            </div>';
          }
          echo '</div>';

          $popularTopicsQuery = "SELECT * FROM topic ORDER BY Προβολές DESC" ;
          $popularTopics = mysqli_query($conn, $popularTopicsQuery);
          if(mysqli_num_rows($popularTopics) > 0)
          {
            echo 
          '<div class="rightcard">
            <h3 style="padding-bottom: 10px; border-bottom: rgb(4, 74, 121) 3px solid;">Δημοφιλής Θέματα</h3>';
            
            for($i = 0; $i < min(mysqli_num_rows($popularTopics), 3); $i++)
            {
              $popularTopic = mysqli_fetch_assoc($popularTopics);
              echo '
            <div class="popular-topic">
              <div class="popular-topic-title">
                <a href="TopicName.php?topicID=' . $popularTopic["ID"] . '">' . $popularTopic["Τίτλος"] . '</a>
              </div>
              <svg fill="#999" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                width="14px" height="19px" viewBox="0 0 559.98 559.98" style="float: left; margin-right: 5px; enable-background:new 0 0 559.98 559.98;"
                xml:space="preserve">
                <path d="M279.99,0C125.601,0,0,125.601,0,279.99c0,154.39,125.601,279.99,279.99,279.99c154.39,0,279.99-125.601,279.99-279.99
                C559.98,125.601,434.38,0,279.99,0z M279.99,498.78c-120.644,0-218.79-98.146-218.79-218.79
                c0-120.638,98.146-218.79,218.79-218.79s218.79,98.152,218.79,218.79C498.78,400.634,400.634,498.78,279.99,498.78z"/>
                <path d="M304.226,280.326V162.976c0-13.103-10.618-23.721-23.716-23.721c-13.102,0-23.721,10.618-23.721,23.721v124.928
                c0,0.373,0.092,0.723,0.11,1.096c-0.312,6.45,1.91,12.999,6.836,17.926l88.343,88.336c9.266,9.266,24.284,9.266,33.543,0
                c9.26-9.266,9.266-24.284,0-33.544L304.226,280.326z"/>
              </svg>
              <div class="topic-date" style="margin-bottom: 5px;">';
                
                $dateArr = explode('-', $popularTopic["Ημερομηνία"]);
                $date = (int) $dateArr[2] . " " . $months[(int) $dateArr[1] - 1] . " " . $dateArr[0];
                
                echo $date . 
              '</div>
            </div>';
            }
            echo'
          </div>';
          }

          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
          {
            $myTopicsQuery = "SELECT * FROM topic WHERE UserID =" . $_SESSION["ID"];
            $myTopics = mysqli_query($conn, $myTopicsQuery);
            if(mysqli_num_rows($myTopics) > 0)
            {
              echo 
            '<div class="rightcard">
              <h3 style="padding-bottom: 10px; border-bottom: rgb(4, 74, 121) 3px solid;">Οι Συζητήσεις Μου</h3>';
              
              for($i = 0; $i < min(mysqli_num_rows($myTopics), 3); $i++)
              {
                $myTopic = mysqli_fetch_assoc($myTopics);
                echo '
              <div class="my-topic">
                <div class="my-topic-title">
                  <a href="TopicName.php?topicID=' . $myTopic["ID"] . '">' . $myTopic["Τίτλος"] . '</a>
                </div>
                <svg fill="#999" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                  width="14px" height="19px" viewBox="0 0 559.98 559.98" style="float: left; margin-right: 5px; enable-background:new 0 0 559.98 559.98;"
                  xml:space="preserve">
                  <path d="M279.99,0C125.601,0,0,125.601,0,279.99c0,154.39,125.601,279.99,279.99,279.99c154.39,0,279.99-125.601,279.99-279.99
                  C559.98,125.601,434.38,0,279.99,0z M279.99,498.78c-120.644,0-218.79-98.146-218.79-218.79
                  c0-120.638,98.146-218.79,218.79-218.79s218.79,98.152,218.79,218.79C498.78,400.634,400.634,498.78,279.99,498.78z"/>
                  <path d="M304.226,280.326V162.976c0-13.103-10.618-23.721-23.716-23.721c-13.102,0-23.721,10.618-23.721,23.721v124.928
                  c0,0.373,0.092,0.723,0.11,1.096c-0.312,6.45,1.91,12.999,6.836,17.926l88.343,88.336c9.266,9.266,24.284,9.266,33.543,0
                  c9.26-9.266,9.266-24.284,0-33.544L304.226,280.326z"/>
                </svg>
                <div class="topic-date" style="margin-bottom: 5px;">';
                  
                  $dateArr = explode('-', $myTopic["Ημερομηνία"]);
                  $date = (int) $dateArr[2] . " " . $months[(int) $dateArr[1] - 1] . " " . $dateArr[0];
                  
                  echo $date . 
                '</div>
              </div>';
              }
              echo
              (mysqli_num_rows($myTopics) > 3)?'<a href="Category.php" class="showmore">Περισσότερα...</a>':'';  
              echo
            '</div>';
            }
          }
          ?>
      </div>
    </div>

    <footer>
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
            <p><span>Αριστοτέλειο Πανεπιστήμιο Θεσσαλονίκης, Ελλάδα</span></p>
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
          <a href="https://el-gr.facebook.com/" target="_blank"><svg version="1.1" fill="white" width="24px" height="24px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M448,0H64C28.704,0,0,28.704,0,64v384c0,35.296,28.704,64,64,64h192V336h-64v-80h64v-64c0-53.024,42.976-96,96-96h64v80 h-32c-17.664,0-32-1.664-32,16v64h80l-32,80h-48v176h96c35.296,0,64-28.704,64-64V64C512,28.704,483.296,0,448,0z"/></svg></a>
          <a href="https://twitter.com/explore" target="_blank"><svg version="1.1" fill="white" width="24px" height="24px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016
            c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992
            c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056
            c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152
            c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792
            c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44
            C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568
            C480.224,136.96,497.728,118.496,512,97.248z"/></svg></a>
          <a href="https://www.instagram.com/?hl=el" target="_blank"><svg height="24px" fill="white" viewBox="0 0 511 511.9" width="24px" height="24px" xmlns="http://www.w3.org/2000/svg"><path d="m510.949219 150.5c-1.199219-27.199219-5.597657-45.898438-11.898438-62.101562-6.5-17.199219-16.5-32.597657-29.601562-45.398438-12.800781-13-28.300781-23.101562-45.300781-29.5-16.296876-6.300781-34.898438-10.699219-62.097657-11.898438-27.402343-1.300781-36.101562-1.601562-105.601562-1.601562s-78.199219.300781-105.5 1.5c-27.199219 1.199219-45.898438 5.601562-62.097657 11.898438-17.203124 6.5-32.601562 16.5-45.402343 29.601562-13 12.800781-23.097657 28.300781-29.5 45.300781-6.300781 16.300781-10.699219 34.898438-11.898438 62.097657-1.300781 27.402343-1.601562 36.101562-1.601562 105.601562s.300781 78.199219 1.5 105.5c1.199219 27.199219 5.601562 45.898438 11.902343 62.101562 6.5 17.199219 16.597657 32.597657 29.597657 45.398438 12.800781 13 28.300781 23.101562 45.300781 29.5 16.300781 6.300781 34.898438 10.699219 62.101562 11.898438 27.296876 1.203124 36 1.5 105.5 1.5s78.199219-.296876 105.5-1.5c27.199219-1.199219 45.898438-5.597657 62.097657-11.898438 34.402343-13.300781 61.601562-40.5 74.902343-74.898438 6.296876-16.300781 10.699219-34.902343 11.898438-62.101562 1.199219-27.300781 1.5-36 1.5-105.5s-.101562-78.199219-1.300781-105.5zm-46.097657 209c-1.101562 25-5.300781 38.5-8.800781 47.5-8.601562 22.300781-26.300781 40-48.601562 48.601562-9 3.5-22.597657 7.699219-47.5 8.796876-27 1.203124-35.097657 1.5-103.398438 1.5s-76.5-.296876-103.402343-1.5c-25-1.097657-38.5-5.296876-47.5-8.796876-11.097657-4.101562-21.199219-10.601562-29.398438-19.101562-8.5-8.300781-15-18.300781-19.101562-29.398438-3.5-9-7.699219-22.601562-8.796876-47.5-1.203124-27-1.5-35.101562-1.5-103.402343s.296876-76.5 1.5-103.398438c1.097657-25 5.296876-38.5 8.796876-47.5 4.101562-11.101562 10.601562-21.199219 19.203124-29.402343 8.296876-8.5 18.296876-15 29.398438-19.097657 9-3.5 22.601562-7.699219 47.5-8.800781 27-1.199219 35.101562-1.5 103.398438-1.5 68.402343 0 76.5.300781 103.402343 1.5 25 1.101562 38.5 5.300781 47.5 8.800781 11.097657 4.097657 21.199219 10.597657 29.398438 19.097657 8.5 8.300781 15 18.300781 19.101562 29.402343 3.5 9 7.699219 22.597657 8.800781 47.5 1.199219 27 1.5 35.097657 1.5 103.398438s-.300781 76.300781-1.5 103.300781zm0 0"/><path d="m256.449219 124.5c-72.597657 0-131.5 58.898438-131.5 131.5s58.902343 131.5 131.5 131.5c72.601562 0 131.5-58.898438 131.5-131.5s-58.898438-131.5-131.5-131.5zm0 216.800781c-47.097657 0-85.300781-38.199219-85.300781-85.300781s38.203124-85.300781 85.300781-85.300781c47.101562 0 85.300781 38.199219 85.300781 85.300781s-38.199219 85.300781-85.300781 85.300781zm0 0"/><path d="m423.851562 119.300781c0 16.953125-13.746093 30.699219-30.703124 30.699219-16.953126 0-30.699219-13.746094-30.699219-30.699219 0-16.957031 13.746093-30.699219 30.699219-30.699219 16.957031 0 30.703124 13.742188 30.703124 30.699219zm0 0"/></svg></a>
          <a href="https://www.linkedin.com/" target="_blank"><svg version="1.1" fill="white" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            width="24px" height="24px" viewBox="0 0 22.258 22.258" style="enable-background:new 0 0 22.258 22.258;"
            xml:space="preserve">
           <path d="M5.366,2.973c0,1.376-1.035,2.479-2.699,2.479H2.636C1.034,5.453,0,4.348,0,2.973c0-1.409,1.067-2.482,2.698-2.482
             C4.331,0.49,5.336,1.564,5.366,2.973z M0.28,21.766h4.772V7.413H0.28V21.766z M16.764,7.077c-2.531,0-3.664,1.39-4.301,2.37v0.046
             h-0.031c0.012-0.014,0.023-0.03,0.031-0.046V7.414H7.692c0.062,1.345,0,14.353,0,14.353h4.771v-8.016
             c0-0.432,0.029-0.855,0.157-1.164c0.346-0.854,1.132-1.747,2.446-1.747c1.729,0,2.42,1.319,2.42,3.247v7.68h4.771v-8.229
             C22.258,9.126,19.902,7.077,16.764,7.077z"/>
         </svg></a>
          <a href="https://www.youtube.com/?hl=el&gl=GR" target="_blank"><svg id="regular" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24" fill="white" xmlns="http://www.w3.org/2000/svg"><path d="m9.939 7.856c-.497-.297-1.134.062-1.134.644v7c0 .585.638.939 1.134.645l5.869-3.495c.488-.291.487-.997.001-1.289zm.366 6.325v-4.36l3.655 2.183z"/><path d="m19.904 3.271c-4.653-.691-11.153-.691-15.808 0-1.862.276-3.329 1.738-3.649 3.636-.596 3.523-.596 6.664 0 10.186.32 1.899 1.787 3.36 3.649 3.636 2.332.346 5.124.519 7.915.519 2.786 0 5.571-.172 7.894-.518 1.86-.276 3.326-1.737 3.648-3.636.596-3.523.596-6.665 0-10.188-.32-1.897-1.787-3.359-3.649-3.635zm2.17 13.573c-.213 1.256-1.173 2.222-2.39 2.402-4.518.671-10.838.671-15.368-.001-1.218-.181-2.179-1.146-2.391-2.402-.574-3.394-.574-6.291 0-9.687.213-1.256 1.173-2.22 2.392-2.402 2.262-.335 4.973-.503 7.682-.503 2.711 0 5.422.168 7.684.503 1.218.181 2.179 1.146 2.391 2.402.574 3.396.574 6.293 0 9.688z"/></svg></a>
        </div>
      </div>
    </footer>

    <script src="js/Forum.js"></script>
  </body>
</html>