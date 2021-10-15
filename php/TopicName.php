<!DOCTYPE html>
<html lang="el">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='icon' href='./images/favicon.png' type='image/x-icon'>
    <link rel="stylesheet" type="text/css" href="./stylesheets/TopicName.css">
    <title>GReco | TopicName</title>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
  </head>

  <body>

    <a href="homepage.php"><img src="./logo/grecogreen.png" class="logo"></a>

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
        ?>  
      </div>
    </nav>

    <div class="row">
      <div class="leftcolumn">
        <div class="post">
    
        <?php
        include("config.php");

        $months = array("Ιανουαρίου", "Φεβρουαρίου", "Μαρτίου", "Απριλίου", "Μαΐου", 
        "Ιουνίου", "Ιουλίου", "Αυγούστου", "Σεπτεμβρίου", "Οκτωβρίου", "Νοεμβρίου", "Δεκεμβρίου");
      
        /* pagination */
        if(isset($_GET['pageNo']))
        {
          $pageNo = $_GET['pageNo'];
        }
        else
        {
          $pageNo = 1;
        }
 
        $limit = 10;
        $offset = ($pageNo - 1) * $limit;

        if(isset($_GET['topicID']))
        {
          $topicID = intval($_GET['topicID']);
        }
        if(isset($_POST['topicID']))
        {
          $topicID = intval($_POST['topicID']);
        }

        $numOfPostsQuery = "SELECT COUNT(*) FROM post WHERE TopicID =" . $topicID;
        $numOfPostsResult = mysqli_query($conn, $numOfPostsQuery);
        $numOfPosts = mysqli_fetch_assoc($numOfPostsResult)["COUNT(*)"];
        $totalPages = ceil($numOfPosts / $limit);

        /*Topic*/
        $topicQuery = "SELECT * FROM topic WHERE ID =" . $topicID;
        $topicRes = mysqli_query($conn, $topicQuery);
        $topic = mysqli_fetch_assoc($topicRes);

        /*Cookie for views*/
        $cookieName = 'topic' . $topic["ID"] . 'Counts';
        if(!isset($_COOKIE[$cookieName]))
        {
          $newViewNumber = $topic["Προβολές"] + 1;
          setcookie($cookieName, $newViewNumber, time() + 10*365*24*60*60);
          $updateViewsQuery = "UPDATE topic SET Προβολές =" . $newViewNumber . " WHERE ID =" . $topicID;
          mysqli_query($conn, $updateViewsQuery);
        }

        /*User*/
        $topicCreatorQuery = "SELECT * FROM user WHERE ID =" . $topic["UserID"];
        $topicCreatorRes = mysqli_query($conn, $topicCreatorQuery);
        $topicCreator = mysqli_fetch_assoc($topicCreatorRes);

        $dateArr = explode('-', $topic["Ημερομηνία"]);
        $date = (int) $dateArr[2] . " " . $months[(int) $dateArr[1] - 1] . " " . $dateArr[0];
                
        ob_start();
        echo '<a href="profile.php?UserID=' . $topic["UserID"] . '"><img class="avatar" src="./images/profileicon.jpg"></a>
          <div class="topicinfo">
            <div class="topic-title">' . $topic["Τίτλος"] . '</div>
            <div class="description">' . $topic["Περιγραφή"] . '</div>
            <p>Από τον <span id="postUser0">' . $topicCreator["Username"] . '</span>, <i>' . $topicCreator["Τύπος"] . '</i> στις ' . $date . '</p>
          </div>
          <div class="count-cell">
            Αναρτήσεις: ' . $numOfPosts . 
          '</div>
        </div>';

        echo '<div class="post">
          <table>
            <tr>
              <td style="padding-bottom: 10px" id="0">' . nl2br($topic["Κείμενο"])
              . '</td>
            </tr>
            <tr>
              <td class="reply-buttons">
                <a href="#textarea"><svg style="margin-right: 10px" enable-background="new 0 0 24 24" height="24px" width="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m10 7.002v-4.252c0-.301-.181-.573-.458-.691-.276-.117-.599-.058-.814.153l-8.5 8.25c-.146.141-.228.335-.228.538s.082.397.228.538l8.5 8.25c.217.21.539.269.814.153.277-.118.458-.39.458-.691v-4.25h1.418c4.636 0 8.91 2.52 11.153 6.572l.021.038c.134.244.388.39.658.39.062 0 .124-.007.186-.023.332-.085.564-.384.564-.727 0-7.774-6.257-14.114-14-14.248z"/></svg></a>
                <button class="post-reply-button" '; 
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
                {
                  echo 'onClick="openModal(0)">';
                }
                else
                {
                  echo 'onClick="redirectToLogin()">';
                }
                echo '<svg height="24px" width="24px" viewBox="0 0 512 512.00578" xmlns="http://www.w3.org/2000/svg"><path d="m507.523438 148.890625-138.667969-144c-4.523438-4.691406-11.457031-6.164063-17.492188-3.734375-6.058593 2.453125-10.027343 8.320312-10.027343 14.847656v69.335938h-5.332032c-114.6875 0-208 93.3125-208 208v32c0 7.421875 5.226563 13.609375 12.457032 15.296875 1.175781.296875 2.347656.425781 3.519531.425781 6.039062 0 11.820312-3.542969 14.613281-9.109375 29.996094-60.011719 90.304688-97.28125 157.398438-97.28125h25.34375v69.332031c0 6.53125 3.96875 12.398438 10.027343 14.828125 5.996094 2.453125 12.96875.960938 17.492188-3.734375l138.667969-144c5.972656-6.207031 5.972656-15.976562 0-22.207031zm0 0"/><path d="m448.003906 512.003906h-384c-35.285156 0-63.99999975-28.710937-63.99999975-64v-298.664062c0-35.285156 28.71484375-64 63.99999975-64h64c11.796875 0 21.332032 9.535156 21.332032 21.332031s-9.535157 21.332031-21.332032 21.332031h-64c-11.777344 0-21.335937 9.558594-21.335937 21.335938v298.664062c0 11.777344 9.558593 21.335938 21.335937 21.335938h384c11.773438 0 21.332032-9.558594 21.332032-21.335938v-170.664062c0-11.796875 9.535156-21.335938 21.332031-21.335938 11.800781 0 21.335937 9.539063 21.335937 21.335938v170.664062c0 35.289063-28.714844 64-64 64zm0 0"/></svg></button>
                <a href="https://el-gr.facebook.com/" target="_blank"><svg version="1.1" style="float: right; margin-left: 10px;" width="24px" height="24px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M448,0H64C28.704,0,0,28.704,0,64v384c0,35.296,28.704,64,64,64h192V336h-64v-80h64v-64c0-53.024,42.976-96,96-96h64v80 h-32c-17.664,0-32-1.664-32,16v64h80l-32,80h-48v176h96c35.296,0,64-28.704,64-64V64C512,28.704,483.296,0,448,0z"/></svg></a>
                <a href="https://www.instagram.com/?hl=el" target="_blank"><svg height="24px" style="float: right; margin-left: 10px;" viewBox="0 0 511 511.9" width="24px" height="24px" xmlns="http://www.w3.org/2000/svg"><path d="m510.949219 150.5c-1.199219-27.199219-5.597657-45.898438-11.898438-62.101562-6.5-17.199219-16.5-32.597657-29.601562-45.398438-12.800781-13-28.300781-23.101562-45.300781-29.5-16.296876-6.300781-34.898438-10.699219-62.097657-11.898438-27.402343-1.300781-36.101562-1.601562-105.601562-1.601562s-78.199219.300781-105.5 1.5c-27.199219 1.199219-45.898438 5.601562-62.097657 11.898438-17.203124 6.5-32.601562 16.5-45.402343 29.601562-13 12.800781-23.097657 28.300781-29.5 45.300781-6.300781 16.300781-10.699219 34.898438-11.898438 62.097657-1.300781 27.402343-1.601562 36.101562-1.601562 105.601562s.300781 78.199219 1.5 105.5c1.199219 27.199219 5.601562 45.898438 11.902343 62.101562 6.5 17.199219 16.597657 32.597657 29.597657 45.398438 12.800781 13 28.300781 23.101562 45.300781 29.5 16.300781 6.300781 34.898438 10.699219 62.101562 11.898438 27.296876 1.203124 36 1.5 105.5 1.5s78.199219-.296876 105.5-1.5c27.199219-1.199219 45.898438-5.597657 62.097657-11.898438 34.402343-13.300781 61.601562-40.5 74.902343-74.898438 6.296876-16.300781 10.699219-34.902343 11.898438-62.101562 1.199219-27.300781 1.5-36 1.5-105.5s-.101562-78.199219-1.300781-105.5zm-46.097657 209c-1.101562 25-5.300781 38.5-8.800781 47.5-8.601562 22.300781-26.300781 40-48.601562 48.601562-9 3.5-22.597657 7.699219-47.5 8.796876-27 1.203124-35.097657 1.5-103.398438 1.5s-76.5-.296876-103.402343-1.5c-25-1.097657-38.5-5.296876-47.5-8.796876-11.097657-4.101562-21.199219-10.601562-29.398438-19.101562-8.5-8.300781-15-18.300781-19.101562-29.398438-3.5-9-7.699219-22.601562-8.796876-47.5-1.203124-27-1.5-35.101562-1.5-103.402343s.296876-76.5 1.5-103.398438c1.097657-25 5.296876-38.5 8.796876-47.5 4.101562-11.101562 10.601562-21.199219 19.203124-29.402343 8.296876-8.5 18.296876-15 29.398438-19.097657 9-3.5 22.601562-7.699219 47.5-8.800781 27-1.199219 35.101562-1.5 103.398438-1.5 68.402343 0 76.5.300781 103.402343 1.5 25 1.101562 38.5 5.300781 47.5 8.800781 11.097657 4.097657 21.199219 10.597657 29.398438 19.097657 8.5 8.300781 15 18.300781 19.101562 29.402343 3.5 9 7.699219 22.597657 8.800781 47.5 1.199219 27 1.5 35.097657 1.5 103.398438s-.300781 76.300781-1.5 103.300781zm0 0"/><path d="m256.449219 124.5c-72.597657 0-131.5 58.898438-131.5 131.5s58.902343 131.5 131.5 131.5c72.601562 0 131.5-58.898438 131.5-131.5s-58.898438-131.5-131.5-131.5zm0 216.800781c-47.097657 0-85.300781-38.199219-85.300781-85.300781s38.203124-85.300781 85.300781-85.300781c47.101562 0 85.300781 38.199219 85.300781 85.300781s-38.199219 85.300781-85.300781 85.300781zm0 0"/><path d="m423.851562 119.300781c0 16.953125-13.746093 30.699219-30.703124 30.699219-16.953126 0-30.699219-13.746094-30.699219-30.699219 0-16.957031 13.746093-30.699219 30.699219-30.699219 16.957031 0 30.703124 13.742188 30.703124 30.699219zm0 0"/></svg></a>
                <a href="https://twitter.com/explore" target="_blank"><svg version="1.1" style="float: right; margin-left: 10px;" width="24px" height="24px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016
                  c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992
                  c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056
                  c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152
                  c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792
                  c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44
                  C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568
                  C480.224,136.96,497.728,118.496,512,97.248z"/></svg></a>
              </td>
            </tr>';
            $userTypeQuery = "SELECT Τύπος FROM user WHERE ID = " . $_SESSION["ID"];
            $userTypeRes = mysqli_query($conn, $userTypeQuery);
            $userType = mysqli_fetch_assoc($userTypeRes);
            if($userType["Τύπος"] == "Administrator" || $_SESSION["ID"] == $topic["UserID"])
            {
              echo '
              <tr>
                <td class="edit-buttons">
                  <div class="fas" onClick="openEditTopicDialog(' . $topic["ID"] . ')">
                    &#xf304;
                  </div>
                </td>
              </tr> ';
            }
          echo '</table>
        </div>';

        $postsQuery = "SELECT * FROM post WHERE topicID = $topicID LIMIT $offset, $limit";
        $posts = mysqli_query($conn, $postsQuery);

        if(($pageNo > $totalPages || $pageNo < 1) && $totalPages != 0)
        {
          echo '<div class="post">Η σελίδα δεν βρέθηκε</div>';
        }
        elseif($numOfPosts > 0)
        {
          while($post = mysqli_fetch_assoc($posts))
          {
            $postUserQuery = "SELECT * FROM user WHERE ID = " . $post["UserID"];
            $postUserRes = mysqli_query($conn, $postUserQuery);
            $postUser = mysqli_fetch_assoc($postUserRes);

            $numOfPostsFromUserQuery = "SELECT COUNT(*) FROM post WHERE UserID = " . $postUser["ID"];
            $numOfPostsFromUserRes = mysqli_query($conn, $numOfPostsFromUserQuery);
            $numOfPostsFromUser = mysqli_fetch_assoc($numOfPostsFromUserRes);

            echo '<div class="post">
            <table>
              <tr>';
              if($post["ΑρχικόΚείμενο"] != "")
              {
                echo '<td class="avatar-cell" rowspan="2">
                <a href="'; echo ($postUser["ID"] != 2)?'profile.php?UserID=' . $postUser["ID"]:''; echo '"><img class="avatar" src="./images/profileicon.jpg"></a>
                <div id="postUser' . $post["ID"] . '">' . $postUser["Username"] . '</div>
                <i>' . $postUser["Τύπος"] . '</i>';
                if($postUser["ID"] != 2) /* Check if the user isn't a guest */
                {
                  echo '<br>Αναρτήσεις: ' . $numOfPostsFromUser["COUNT(*)"] ;
                }
                echo '</td>
                <td class="quote">' .
                  $post["ΑρχικόΚείμενο"]
                . '</td>
                </tr>
                <tr>
                <td class="post-text" id="' . $post["ID"] . '"><br>' .
                nl2br($post["Κείμενο"])
              . '</td>
              </tr>';
              }
              else
              {
                echo '<td class="avatar-cell">
                  <a href="'; echo ($postUser["ID"] != 2)?'profile.php?UserID=' . $postUser["ID"]:''; echo '"><img class="avatar" src="./images/profileicon.jpg"></a>
                  <div id="postUser' . $post["ID"] . '">' . $postUser["Username"] . '</div>
                  <i>' . $postUser["Τύπος"] . '</i>';
                  if($postUser["ID"] != 2) /* Check if the user isn't a guest */
                  {
                    echo '<br>Αναρτήσεις: ' . $numOfPostsFromUser["COUNT(*)"] ;
                  }
                
              echo '</td>
                <td class="post-text" id="' . $post["ID"] . '">' .
                nl2br($post["Κείμενο"])
              . '</td>
              </tr>';
              }

              $dateArr = explode('-', $post["Ημερομηνία"]);
              $date = (int) $dateArr[2] . " " . $months[(int) $dateArr[1] - 1] . " " . $dateArr[0];
                  
                
              echo '
              <tr>
                <td class="post-date" colspan="2" style="text-align: right;">' .
                  $date
                . '</td>
              </tr>
              <tr>
                <td class="reply-buttons" colspan="2">
                  <a href="#textarea"><svg type="button" style="margin-right: 10px" enable-background="new 0 0 24 24" height="24px" width="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m10 7.002v-4.252c0-.301-.181-.573-.458-.691-.276-.117-.599-.058-.814.153l-8.5 8.25c-.146.141-.228.335-.228.538s.082.397.228.538l8.5 8.25c.217.21.539.269.814.153.277-.118.458-.39.458-.691v-4.25h1.418c4.636 0 8.91 2.52 11.153 6.572l.021.038c.134.244.388.39.658.39.062 0 .124-.007.186-.023.332-.085.564-.384.564-.727 0-7.774-6.257-14.114-14-14.248z"/></svg></a>
                  <button class="post-reply-button" '; 
                  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
                  {
                    echo 'onClick="openModal(' . $post["ID"] . ')">';
                  }
                  else
                  {
                    echo 'onClick="redirectToLogin()">';
                  }
                  echo '<svg height="24px" width="24px" viewBox="0 0 512 512.00578" xmlns="http://www.w3.org/2000/svg"><path d="m507.523438 148.890625-138.667969-144c-4.523438-4.691406-11.457031-6.164063-17.492188-3.734375-6.058593 2.453125-10.027343 8.320312-10.027343 14.847656v69.335938h-5.332032c-114.6875 0-208 93.3125-208 208v32c0 7.421875 5.226563 13.609375 12.457032 15.296875 1.175781.296875 2.347656.425781 3.519531.425781 6.039062 0 11.820312-3.542969 14.613281-9.109375 29.996094-60.011719 90.304688-97.28125 157.398438-97.28125h25.34375v69.332031c0 6.53125 3.96875 12.398438 10.027343 14.828125 5.996094 2.453125 12.96875.960938 17.492188-3.734375l138.667969-144c5.972656-6.207031 5.972656-15.976562 0-22.207031zm0 0"/><path d="m448.003906 512.003906h-384c-35.285156 0-63.99999975-28.710937-63.99999975-64v-298.664062c0-35.285156 28.71484375-64 63.99999975-64h64c11.796875 0 21.332032 9.535156 21.332032 21.332031s-9.535157 21.332031-21.332032 21.332031h-64c-11.777344 0-21.335937 9.558594-21.335937 21.335938v298.664062c0 11.777344 9.558593 21.335938 21.335937 21.335938h384c11.773438 0 21.332032-9.558594 21.332032-21.335938v-170.664062c0-11.796875 9.535156-21.335938 21.332031-21.335938 11.800781 0 21.335937 9.539063 21.335937 21.335938v170.664062c0 35.289063-28.714844 64-64 64zm0 0"/></svg></button>
                  <a href="https://el-gr.facebook.com/" target="_blank"><svg version="1.1" style="float: right; margin-left: 10px;" width="24px" height="24px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M448,0H64C28.704,0,0,28.704,0,64v384c0,35.296,28.704,64,64,64h192V336h-64v-80h64v-64c0-53.024,42.976-96,96-96h64v80 h-32c-17.664,0-32-1.664-32,16v64h80l-32,80h-48v176h96c35.296,0,64-28.704,64-64V64C512,28.704,483.296,0,448,0z"/></svg></a>
                  <a href="https://www.instagram.com/?hl=el" target="_blank"><svg height="24px" style="float: right; margin-left: 10px;" viewBox="0 0 511 511.9" width="24px" height="24px" xmlns="http://www.w3.org/2000/svg"><path d="m510.949219 150.5c-1.199219-27.199219-5.597657-45.898438-11.898438-62.101562-6.5-17.199219-16.5-32.597657-29.601562-45.398438-12.800781-13-28.300781-23.101562-45.300781-29.5-16.296876-6.300781-34.898438-10.699219-62.097657-11.898438-27.402343-1.300781-36.101562-1.601562-105.601562-1.601562s-78.199219.300781-105.5 1.5c-27.199219 1.199219-45.898438 5.601562-62.097657 11.898438-17.203124 6.5-32.601562 16.5-45.402343 29.601562-13 12.800781-23.097657 28.300781-29.5 45.300781-6.300781 16.300781-10.699219 34.898438-11.898438 62.097657-1.300781 27.402343-1.601562 36.101562-1.601562 105.601562s.300781 78.199219 1.5 105.5c1.199219 27.199219 5.601562 45.898438 11.902343 62.101562 6.5 17.199219 16.597657 32.597657 29.597657 45.398438 12.800781 13 28.300781 23.101562 45.300781 29.5 16.300781 6.300781 34.898438 10.699219 62.101562 11.898438 27.296876 1.203124 36 1.5 105.5 1.5s78.199219-.296876 105.5-1.5c27.199219-1.199219 45.898438-5.597657 62.097657-11.898438 34.402343-13.300781 61.601562-40.5 74.902343-74.898438 6.296876-16.300781 10.699219-34.902343 11.898438-62.101562 1.199219-27.300781 1.5-36 1.5-105.5s-.101562-78.199219-1.300781-105.5zm-46.097657 209c-1.101562 25-5.300781 38.5-8.800781 47.5-8.601562 22.300781-26.300781 40-48.601562 48.601562-9 3.5-22.597657 7.699219-47.5 8.796876-27 1.203124-35.097657 1.5-103.398438 1.5s-76.5-.296876-103.402343-1.5c-25-1.097657-38.5-5.296876-47.5-8.796876-11.097657-4.101562-21.199219-10.601562-29.398438-19.101562-8.5-8.300781-15-18.300781-19.101562-29.398438-3.5-9-7.699219-22.601562-8.796876-47.5-1.203124-27-1.5-35.101562-1.5-103.402343s.296876-76.5 1.5-103.398438c1.097657-25 5.296876-38.5 8.796876-47.5 4.101562-11.101562 10.601562-21.199219 19.203124-29.402343 8.296876-8.5 18.296876-15 29.398438-19.097657 9-3.5 22.601562-7.699219 47.5-8.800781 27-1.199219 35.101562-1.5 103.398438-1.5 68.402343 0 76.5.300781 103.402343 1.5 25 1.101562 38.5 5.300781 47.5 8.800781 11.097657 4.097657 21.199219 10.597657 29.398438 19.097657 8.5 8.300781 15 18.300781 19.101562 29.402343 3.5 9 7.699219 22.597657 8.800781 47.5 1.199219 27 1.5 35.097657 1.5 103.398438s-.300781 76.300781-1.5 103.300781zm0 0"/><path d="m256.449219 124.5c-72.597657 0-131.5 58.898438-131.5 131.5s58.902343 131.5 131.5 131.5c72.601562 0 131.5-58.898438 131.5-131.5s-58.898438-131.5-131.5-131.5zm0 216.800781c-47.097657 0-85.300781-38.199219-85.300781-85.300781s38.203124-85.300781 85.300781-85.300781c47.101562 0 85.300781 38.199219 85.300781 85.300781s-38.199219 85.300781-85.300781 85.300781zm0 0"/><path d="m423.851562 119.300781c0 16.953125-13.746093 30.699219-30.703124 30.699219-16.953126 0-30.699219-13.746094-30.699219-30.699219 0-16.957031 13.746093-30.699219 30.699219-30.699219 16.957031 0 30.703124 13.742188 30.703124 30.699219zm0 0"/></svg></a>
                  <a href="https://twitter.com/explore" target="_blank"><svg version="1.1" style="float: right; margin-left: 10px;" width="24px" height="24px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016
                    c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992
                    c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056
                    c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152
                    c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792
                    c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44
                    C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568
                    C480.224,136.96,497.728,118.496,512,97.248z"/></svg></a>
                </td>
              </tr>';
              $userTypeQuery = "SELECT Τύπος FROM user WHERE ID = " . $_SESSION["ID"];
              $userTypeRes = mysqli_query($conn, $userTypeQuery);
              $userType = mysqli_fetch_assoc($userTypeRes);
              if($userType["Τύπος"] == "Administrator" || $_SESSION["ID"] == $post["UserID"])
              {
                echo '
                <tr>
                  <td class="edit-buttons" colspan="2">
                    <div class="delete-post" onClick="openDeletePostDialog(' . $post["ID"] . ')">
                      &times;
                    </div>
                    <div class="fas" onClick="openEditPostDialog(' . $post["ID"] . ')">
                      &#xf304;
                    </div>
                  </td>
                </tr> ';
              }
            echo '</table>
          </div>';
          }
        }
        else
        {
          echo '<div class="post">Δεν υπάρχουν ακόμα απαντήσεις.</div>';
        }
        
        function test_input($data) 
        {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }
        ?>


        <div class="post">
          <h2 style="margin-top: 0px; border-bottom: #d0d0d0 1px solid; padding-bottom: 10px;">Γρήγορη Απάντηση</h2>
          <b>Κείμενο Απάντησης</b>
          <form action="
          <?php
          if(isset($_POST['submitReply']))
          {
            $text = $_POST["text"];
            $date = date("Y-m-d");
      
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
            {
              $userID = $_SESSION["ID"];
            }
            else
            {
              $userID = 2;
            }
            $insertQuery = "INSERT INTO post (ID, TopicID, UserID, Κείμενο, Ημερομηνία, ΑρχικόΚείμενο) 
            VALUES (NULL, '" . $GLOBALS['topicID'] . "', '" . $userID . "', '" . $text . "', '" . $date . "', '')";
      
            if(mysqli_query($GLOBALS['conn'], $insertQuery))
            {
              ob_clean();
              echo '<br>Η Απάντηση Αποθηκύτηκε';
              $redirect = "Location: TopicName.php?topicID=" . $GLOBALS['topicID'];
              header($redirect);
              exit();
            }
            else
            {
              echo '<br>Error';
            }
          }
          
          ?>" method="POST">
            <input type="hidden" name="topicID" value="<?php
             echo htmlspecialchars($_GET['topicID']);?>">
            <textarea class="textarea" required name="text" id="textarea" style="margin-top: 5px; width: 100%; height: 100px; resize: vertical;"></textarea>
            <button class="newreply" type="submit" name="submitReply">
              Ανάρτηση Απάντησης
            </button>

          </form>
        </div>

        <div class="delete-post-dialog" id="delete-post-dialog">
          <div class="delete-post-dialog-content">
            <span  class="close-dialog" onClick="closeDeleteDialog()">&times;</span>
            <br>
            <div style="text-align: center;">Είστε σίγουροι ότι θέλετε να διαγράψετε αυτήν την ανάρτηση;</div>
            <form method="POST" action="
            <?php
            if(isset($_POST["delete-post-button"]))
            {
              $deletePostQuery = "DELETE FROM post WHERE ID = " . $_POST["delete-input-postID"];
              $deletePostRes = mysqli_query($conn, $deletePostQuery);
              if($deletePostRes)
              {
                ob_clean();
                echo "Η ανάρτηση διαγράφηκε";
                $redirect = "Location: TopicName.php?topicID=" . $GLOBALS['topicID'];
                header($redirect);
                exit();
              }
              else
              {
                echo "Κάτι πήγε στραβά";
              }
            }
            ?>">
              <input type="hidden" name="delete-input-postID" id="delete-input-postID"></input>
              <button class="delete-post-button" id="delete-post-button" name="delete-post-button" type="submit">
                Διαγραφή Ανάρτησης
              </button>
            </form>
          </div>
        </div>


        <div class="edit-topic-dialog" id="edit-topic-dialog">
          <div class="edit-topic-dialog-content">
            <span  class="close-dialog" onClick="closeEditTopicDialog()">&times;</span>
            <br>
            <div style="text-align: center; font-size: 20px; margin-bottom: 10px;">Επεξεργασία Θέματος</div>
            <form method="POST" action="
            <?php
            if(isset($_POST["edit-topic-button"]))
            {
              $updateTopicQuery = "UPDATE topic SET Κείμενο = '" . $_POST["edit-topic-text"] . "' WHERE ID = " . $_POST["edit-input-topicID"];
              $updateTopicRes = mysqli_query($conn, $updateTopicQuery);
              if($updateTopicRes)
              {
                ob_clean();
                echo "Οι αλλαγές αποθηκεύτηκαν";
                $redirect = "Location: TopicName.php?topicID=" . $GLOBALS['topicID'];
                header($redirect);
                exit();
              }
              else
              {
                echo "Κάτι πήγε στραβά";
              }
            }
            ?>">
              <input type="hidden" name="edit-input-topicID" id="edit-input-topicID"></input>
              <textarea type="text" class="edit-topic-text" name="edit-topic-text" id="edit-topic-text" style="width: 100%; height: 200px; resize: vertical;"></textarea>
              <button class="edit-topic-button" id="edit-topic-button" name="edit-topic-button" type="submit">
                Αποθήκευση Αλλαγών
              </button>
            </form>
          </div>
        </div>


        <div class="edit-post-dialog" id="edit-post-dialog">
          <div class="edit-post-dialog-content">
            <span  class="close-dialog" onClick="closeEditPostDialog()">&times;</span>
            <br>
            <div style="text-align: center; font-size: 20px; margin-bottom: 10px;">Επεξεργασία Ανάρτησης</div>
            <form method="POST" action="
            <?php
            if(isset($_POST["edit-post-button"]))
            {
              $updatePostQuery = "UPDATE post SET Κείμενο = '" . $_POST["edit-post-text"] . "' WHERE ID = " . $_POST["edit-input-postID"];
              $updatePostRes = mysqli_query($conn, $updatePostQuery);
              if($updatePostRes)
              {
                ob_clean();
                echo "Οι αλλαγές αποθηκεύτηκαν";
                $redirect = "Location: TopicName.php?topicID=" . $GLOBALS['topicID'];
                header($redirect);
                exit();
              }
              else
              {
                echo "Κάτι πήγε στραβά";
              }
            }
            ?>">
              <input type="hidden" name="edit-input-postID" id="edit-input-postID"></input>
              <textarea type="text" class="edit-post-text" name="edit-post-text" id="edit-post-text" style="width: 100%; height: 200px; resize: vertical;"></textarea>
              <button class="edit-post-button" id="edit-post-button" name="edit-post-button" type="submit">
                Αποθήκευση Αλλαγών
              </button>
            </form>
          </div>
        </div>




        <div class="centerpagination">
          <div class="pagination">
            <a href="<?php echo '?topicID=' . $topicID . '&pageNo=1'?>">&laquo; Πρώτη Σελίδα</a>
            <a href="<?php echo '?topicID=' . $topicID; echo ($pageNo <= 1) ? '#' : "&pageNo=".($pageNo - 1); ?>" class="<?php if($pageNo <= 1){ echo 'disabled'; } ?>">&lsaquo;</a>
            <?php
              for($i = 1; $i <= $totalPages; $i++)
              {
                echo '<a href="' . '?topicID=' . $topicID . '&pageNo=' . $i .'"';
                echo ' class=';
                echo ($pageNo == $i)?"active":"";
                echo '>' . $i . '</a>';
              }
            ?>
            <a href="<?php echo '?topicID=' . $topicID; echo ($pageNo >= $totalPages) ? '&pageNo='. $totalPages : "&pageNo=".($pageNo + 1); ?>" class="<?php if($pageNo >= $totalPages){ echo 'disabled'; } ?>">&rsaquo;</a>
            <a href="<?php echo '?topicID=' . $topicID . '&pageNo=' . $totalPages;?>">Τελευταία Σελίδα &raquo;</a>
          </div>  
        </div>
      </div>

      <div id="reply-modal" class="reply-modal">
        <div class="reply-modal-content">
          <span class="close" onClick="closeModal()">&times;</span>
          <br>
          <form action="
          <?php
          if(isset($_POST['submitModalReply']))
          {
            $text = $_POST["reply-modal-text"];
            $initialText = $_POST["inputQuote"];
            $date = date("Y-m-d");
      
            $insertQuery = "INSERT INTO post (ID, TopicID, UserID, Κείμενο, Ημερομηνία, ΑρχικόΚείμενο) 
            VALUES (NULL, '" . $GLOBALS['topicID'] . "', '" . $_SESSION['ID'] . "', '" . $text . "', '" . $date . "', '" . $initialText . "')";
      
            if(mysqli_query($GLOBALS['conn'], $insertQuery))
            {
              ob_clean();
              echo '<br>Η Απάντηση Αποθηκύτηκε';
              $redirect = "Location: TopicName.php?topicID=" . $GLOBALS['topicID'];
              header($redirect);
              exit();
            }
            else
            {
              echo '<br>Error';
            }
          }
          
          ?>" method="POST">
            <p id="modalQuote"></p>
            <input type="hidden" name="inputQuote" id="inputQuote"></input>
            <textarea class="reply-modal-text" required name="reply-modal-text" id="reply-modal-text" style="width: 100%; height: 100px; resize: vertical;"></textarea>
            <button class="newreply" type="submit" name="submitModalReply" id="submitModalReply">
              Ανάρτηση Απάντησης
            </button>
          </form>
        </div>
      </div>
      
      <div class="rightcolumn">
        <div class="rightcard">
          <h3 style="padding-bottom: 10px; border-bottom: #4f9e6e 3px solid;">Ο Λογαριασμός Μου</h3>
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
            <h3 style="padding-bottom: 10px; border-bottom: #4f9e6e 3px solid;">Δημοφιλής Θέματα</h3>';
            
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
            echo '
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
              <h3 style="padding-bottom: 10px; border-bottom: #4f9e6e 3px solid;">Οι Συζητήσεις Μου</h3>';
              
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
    
    <script src="js/TopicName.js"></script> 
  </body>

</html>