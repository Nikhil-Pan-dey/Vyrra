<?php
    require 'connection.php';
    session_start();
      if (isset($_SESSION['mail'])) {
      $mail = $_SESSION['mail'];
      $result = $con->query("SELECT * FROM `user-info` WHERE email = '$mail'");
      $result1 = $con->query("SELECT friendMail FROM friends WHERE mail = '$mail'");
      if ($result && $result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $pic = $row['profilePic'];
          $name = $row['Name'];
      } else {
          $pic = "default.avif"; // Change "default.jpg" to the path of your default image
      }
      } else {
          header("Location: login.php");
          exit();
          $pic = "default.avif"; // Change "default.jpg" to the path of your default image
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
        $caption = $_POST["caption"];
        $fileName = $_FILES["file"]["name"];
        $fileSize = $_FILES["file"]["size"];
        $tempName = $_FILES["file"]["tmp_name"];
    
        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        $imageExtension = pathinfo($fileName, PATHINFO_EXTENSION); // Get the file extension
    
        if (!in_array(strtolower($imageExtension), $validImageExtensions)) {
            echo "<script>alert('Invalid Image Extension');</script>";
        } elseif ($fileSize > 1000000) {
            echo "<script>alert('Image Size is too large');</script>";
        } else {
            $currentDateTime = date('Y-m-d H:i:s');
            $uploadDir = 'img/'; // Directory to store uploaded images
            $destination = $uploadDir . $fileName;
    
            if (move_uploaded_file($tempName, $destination)) {
                // Image uploaded successfully, now insert into database
                $query = "INSERT INTO posts   
                          VALUES ('', '$mail', '$fileName', '$currentDateTime', '$caption')";
                mysqli_query($con, $query);
                echo "<script>alert('Successfully Added');</script>";
            } else {
                echo "<script>alert('Error uploading file');</script>";
            }
        }
    }
    
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./favicon.png" type="image/png" sizes="16x16" />
    <title>VYRRA</title>
    <!-- Styles  -->
    <link rel="stylesheet" href="./css/default.css" />
    <link rel="stylesheet" href="./css/fontawesome.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/responsive.css" />
    <link rel="stylesheet" href="css/notification.css">
    <!-- Styles End  -->
    <!-- <base href="images/"> -->
  </head>
  <body>
    <!-- notification  -->
    <div class="sidebar" id="sidebar">
      <h1>notification-bar</h1>
      <!-- Notifications will be dynamically added here -->
      <button class="clear-btn" onclick="clearNotifications()">Clear All Notifications</button>
  </div>
  
  <script src="js/notification.js"></script>
    <!-- Header Section -->
    <header class="header" id="header">
      <div class="row">
        <aside class="col left">
          <a href="./" class="logo">
            <img src="images/vyrra-removebg-preview.png" alt="Logo" class="img" />
          </a>
        </aside>
        <aside class="col center">
          <nav class="nav">
            <a href="./#" class="link">
              <i class="icon fas fa-home"></i>
            </a>
            <a href="#" class="link" onclick="notify()">
              <i class="icon fas fa-bell"></i>
              <span class="counter">10</span>
            </a>
            <a href="chat.html" class="link">
              <i class="icon fas fa-envelope"></i>
              <span class="counter">70</span>
            </a>
            <a href="./#" class="link">
              <i class="icon fas fa-video"></i>
              <span class="counter">50</span>
            </a>
          </nav>
        </aside>
        <aside class="col right">
          <form class="searchForm">
            <label for="searchBox">
              <i class="fas fa-search"></i>
            </label>
            <input type="search" placeholder="Search here..." id="searchBox" />
          </form>
          <div class="profile">
            <!-- <img src="./images/Nikhil.png" alt="Nikhil" class="img" /> -->
            <img src="images/<?php echo $pic; ?>" alt="Nikhil" class="img" />
            <i
              class="fas fa-ellipsis-h icon"
              title="Profile Settings"
              id="settingsMenuIcon"
            ></i>
          </div>
        </aside>
        <!-- /.col.right -->

        <nav class="navSetting">
          <a href="profile.php" class="block">
            <img src="images/<?php echo $pic; ?>" class="icon"/>
            <div class="right">
              <aside>
                <h4 class="title"><?php echo $name?></h4>
              
                <span class="help">
                  see your profile
                </span>
              </aside>
            </div>
          </a>

          

          <div class="options">
            <a href="./#" class="option">
              <div class="left">
                <i class="fas fa-cog icon"></i>
                <h4 class="title">Settings & privacy</h4>
              </div>
              <div class="right">
                <i class="fas fa-chevron-right icon"></i>
              </div>
            </a>
            <!-- /.option  -->
            <a href="./#" class="option">
              <div class="left">
                <i class="fas fa-question icon"></i>
                <h4 class="title">help & support</h4>
              </div>
              <div class="right">
                <i class="fas fa-chevron-right icon"></i>
              </div>
            </a>
            <!-- /.option  -->

            <a href="./#" class="option">
              <div class="left">
                <i class="fas fa-moon icon"></i>
                <h4 class="title">dark mode</h4>
              </div>
              <div class="right">
                <aside class="themeBtn">
                  <span class="circle dark"></span>
                </aside>
              </div>
            </a>
            <!-- /.option  -->

            <a href="logout.php" class="option">
              <div class="left">
                <i class="fas fa-sign-out-alt icon"></i>
                <h4 class="title">logout</h4>
              </div>
            </a>
            <!-- /.option  -->
          </div>
          <!-- /.options -->
          
        </nav>
        <!-- /.navSetting -->
      </div>
    </header>
    <!-- Header Section End -->
    <!-- IconNav Section -->

    <section class="iconNav" id="iconNav">
      <nav class="navContainer left">
        <a href="./#" class="link"><i class="icon fas fa-user"></i> </a>
        <a href="./#" class="link"><i class="icon fas fa-home"></i> </a>
        <a href="./#" class="link"><i class="fab fa-deezer"></i> </a>
        <a href="./#" class="link"><i class="icon fas fa-user-friends"></i> </a>
        <a href="./#" class="link"><i class="icon fas fa-pager"></i> </a>
        <a href="./#" class="link"><i class="icon fas fa-gamepad"></i> </a>
        <a href="./#" class="link"><i class="icon fas fa-video"></i> </a>
        <a href="./#" class="link"><i class="icon fas fa-heart"></i> </a>
        <a href="./#" class="link"><i class="icon fas fa-calendar-alt"></i> </a>
        <a href="./#" class="link"
          ><i class="icon fab fa-facebook-messenger"></i
        ></a>
      </nav>
    </section>
    <!-- IconNav Section End -->

    <!-- Left Sidebar Section -->
    <section class="leftSidebar" id="leftSidebar">
      <div class="row">
        <a href="profile.html" class="profile">
          <img src="images/<?php echo $pic; ?>" alt="member-1" class="img" />
          <span class="name"><?php echo $name?></span>
        </a>

        <nav class="navLinks">

          <a href="friends.php" class="link">
            <i class="fas fa-user-friends icon"></i>
            <span class="name">friends</span>
          </a>

          <a href="groups.html" class="link">
            <i class="fas fa-layer-group icon"></i>
            <span class="name">groups</span>
          </a>
          <a href="explore.html" class="link">
            <i class="fas fa-pager icon"></i>
            <span class="name">explore</span>
          </a>

          <a href="./#videos" class="link">
            <i class="fas fa-video icon"></i>
            <span class="name">videos</span>
          </a>

        </nav>
      </div>

      <!-- /.row -->
    </section>
    <!-- /.leftSidebar -->

    <!-- Left Sidebar Section End -->

    <!-- Right Sidebar Section -->
    <section class="rightSidebar" id="rightSidebar">
      <div class="row">
        <h3 class="title">
          Events
          <a href="./#" class="link" title="See all"
            ><i class="fas fa-eye icon"></i
          ></a>
        </h3>
        <div class="boxContainer">
          <article class="box">
            <div class="date">
              <h4 class="day">05</h4>
              <h5 class="month">April</h5>
            </div>
            <div class="content">
              <h3 class="title">Spring Spree'24</h3>
              <p class="location">
                <i class="fas fa-map-marker-alt icon"></i>
                NITW Stadium
              </p>
              <a href="./#read-more" class="readMore">read more</a>
            </div>
          </article>
          <!-- /.box  -->
          <article class="box">
            <div class="date">
              <h4 class="day">07</h4>
              <h5 class="month">April</h5>
            </div>
            <div class="content">
              <h3 class="title">NITW IDOL</h3>
              <p class="location">
                <i class="fas fa-map-marker-alt icon"></i>
                Bose Hall Complex
              </p>
              <a href="./#read-more" class="readMore">read more</a>
            </div>
          </article>
          <!-- /.box  -->
          <article class="box">
            <div class="date">
              <h4 class="day">06</h4>
              <h5 class="month">April</h5>
            </div>
            <div class="content">
              <h3 class="title">Fashion Show</h3>
              <p class="location">
                <i class="fas fa-map-marker-alt icon"></i>
                Old Auditorium, NITW
              </p>
              <a href="./#read-more" class="readMore">read more</a>
            </div>
          </article>
          <!-- /.box  -->
        </div>
        <!-- /.boxContainer -->
      </div>
      <!-- /.row -->
      <div class="row">
        <h3 class="title">
          Advertisement
          <i class="fas fa-minus-circle icon" title="Hide"></i>
        </h3>
        <img src="./images/spring-spree.png" alt="advertisement" class="img" />
      </div>
      <!-- /.row -->
      
    </section>
    <!-- Right Sidebar Section End -->

    <!-- Main Content Section -->
    <section class="main" id="main">
      <div class="container">
        <div class="stories">
          <article class="story">
            <a href="./#stories" class="linkStory"
              ><img src="images/<?php echo $pic; ?>" alt="status-1" class="img"
            /></a>
            <a href="./#create-story" class="createStoryBtn">
              <i class="fas fa-plus"></i>
            </a>
            <a class="name">Add story</a>
          </article>

          <article class="story">
            <img src="./images/aman.png" alt="status-2" class="avatar" />
            <a href="./#stories" class="linkStory"
              ><img src="./images/aman.png" alt="status-1" class="img"
            /></a>
            <a href="./#profile" class="name">Aman Singh</a>
          </article>

          <article class="story">
            <img src="./images/shubham_das.jpg" alt="status-3" class="avatar" />
            <a href="./#stories" class="linkStory"
              ><img src="./images/shubham_das.jpg" alt="status-1" class="img"
            /></a>
            <a href="./#profile" class="name">Shubham Das</a>
          </article>

          <article class="story">
            <img src="./images/subhamoy.jpg" alt="status-4" class="avatar" />
            <a href="./#stories" class="linkStory"
              ><img src="./images/subhamoy.jpg" alt="status-1" class="img"
            /></a>
            <a href="./#profile" class="name">Subhamoy</a>
          </article>

          
          
        </div>
        <!-- /.stories -->
        <div class="post">
          <div class="content">
            <img
              src="images/<?php echo $pic; ?>"
              alt="Nikhil"
              class="avatar"
            />

            
            <form action="" method="post" enctype="multipart/form-data">
            <input type="text" class="textBox" name="caption" placeholder="what's on your mind?"/>
          </div>
          <div class="features">
            <div class="feature">
              <i class="fas fa-photo-video icon" title="Photo/Video"></i>
                <div class="file-input-wrapper">
                <label for="upload-file" class="custom-file-upload" id="uploadLabel">Upload File</label>
                <input id="upload-file" type="file" name="file" accept=".jpg, .jpeg, .png" required>
                <!-- <p id="fileName"></p> -->
                <button type="submit">Upload</button>
              </form>
</div>

            </div>
            <div class="feature">
              <i class="fas fa-grin icon" title="Feeling/Activity"></i>
              <span class="name hidden">feeling/activity</span>
            </div>
            <!-- /.feature -->
          </div>
          <!-- /.features -->
        </div>



        <!-- /.post -->
        <?php 
          // i am her ----------------------------------------------
          while($row2 = $result1->fetch_assoc()){
              $result2 = $con->query("SELECT * FROM posts WHERE mail = '$row2[friendMail]' ORDER BY time DESC");
              while($row3 = $result2->fetch_assoc()){
                ?>
                  <div class="postPublished">
                  <header class="top">
                  <div class="user">
                  <img src="images/<?php

                  $result5 = $con->query("Select * from `user-info` where email = '$row2[friendMail]'");
                  $row5 = $result5->fetch_assoc(); 
                  echo $row5['profilePic'];
                  ?>" alt="Nikhil" class="avatar" />
                  <div class="info">
                    <a href="./#profile" class="name">
                      <?php  
                        // $result4 = $con->query("SELECT Name from `user-info` where email = '$row2[friendMail]'");
                        echo $row5['Name'];
                      ?>
                     </a>
                    <p class="time"><?php echo $row3['time'] ?></p>
                  </div>
                </div>
                <div class="actions">
                  <i class="fas fa-ellipsis-v icon"></i>
                </div>
              </header>
              <div class="content">
                <p class="text">
                  <?php echo $row3['caption'] ?>
                </p>
                <img src="img/<?php echo $row3['postUrl'] ?>" alt="news" class="img" />
                </div>
                <div class="bottom">
                  <div class="after">
                    <article class="likes">
                      <i class="fas fa-thumbs-up icon"></i>
                      <i class="fas fa-angry icon"></i>
                      <i class="fas fa-sad-cry icon"></i>
                      Shubham Das & 1.0K others
                    </article>
                    <div class="others">
                      <article class="box">105 comments</article>
                      <article class="box">59 share</article>
                    </div>
                  </div>
                  <!-- /.after -->
                  <div class="before">
                    <div class="box">
                      <i class="fas fa-thumbs-up icon"></i>
                      like
                    </div>
                    <!-- /.box -->
                    <div class="box">
                      <i class="fas fa-comment-alt icon"></i>
                      comment
                    </div>
                    <!-- /.box -->
                    <div class="box">
                      <i class="fas fa-share-square icon"></i>
                      share
                    </div>
                    <div class="box">
                      <img src="images/<?php echo $pic; ?>" alt="Nikhil" class="avatar" />
                      <i class="fas fa-caret-down icon"></i>
                    </div>
                    </div>
                    </div>
                    </div>
              <?php   
              }
            }
            ?>
          <!-- /.bottom -->
        <div class="loadMore">
          <i class="fas fa-spinner icon" title="Loading More..."></i>
        </div>
      </div>
      <!-- /.container -->
    </section>
    <!-- Main Content Section End -->

    <!-- Scripts -->
    <script src="./js/main.js"></script>
    <!-- Scripts End -->



    <script>
        // Get file input element and label
        const fileInput = document.getElementById('upload-file');
        const uploadLabel = document.getElementById('uploadLabel');
        // const fileNameDisplay = document.getElementById('fileName');
        fileInput.addEventListener('change', function() {
            // Check if a file is selected
            if (this.files && this.files[0]) {
                // Display the selected file name
                // const fileName = this.files[0].name;
                // fileNameDisplay.textContent = 'Selected file: ' + fileName;
                // console.log('File to upload:', this.files[0]);
            }
        });
        uploadLabel.addEventListener('click', function() {
            fileInput.click(); // Trigger the file input click event
        });
    </script>
  </body>
</html>
