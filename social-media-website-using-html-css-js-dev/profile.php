<?php
  require 'connection.php';
  session_start();
      if (isset($_SESSION['mail'])) {
            $mail = $_SESSION['mail'];
            $result = $con->query("SELECT * FROM `profiles` WHERE email = '$mail'");
            $result2 = $con->query("SELECT posts FROM `profile_posts` WHERE email = '$mail'");

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pic = $row['pics'];
                $name = $row['name'];
                $bio = $row['bio'];
                $caption = $row['caption'];
            } else {
                $pic = "default.avif"; 
            }
      } else {
        $pic = "default.avif";
      }

?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./favicon.png" type="image/png" sizes="16x16" />
    <title>VYRRA</title>
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/> -->
    <!-- CSS -->
    <link rel="stylesheet" href="css/profile.css">
    <!-- <link rel="stylesheet" href="./css/fontawesome.min.css" />
    <link rel="stylesheet" href="./css/default.css" /> -->

    <base href="images/">
  </head>
  <body>
    <div class="header__wrapper">
      <header></header>
      <div class="cols__container">
        <div class="left__col">
          <div class="img__container">
            <!-- //profile pic -->
            <img src="<?php echo $pic ?>" id="profileImage" alt="Nikhil Pandey" />
            <div class="edit-icon" onmouseover="showDropdown()" onmouseout="hideDropdown()">
              <i class="fas fa-edit"></i>
              <div class="dropdown-content" id="dropdownContent">
                  <a href="#" id="removePhoto">Remove Photo</a>
                  <a href="#">Edit Profile Picture</a>
              </div>
            </div>
            <span></span>
          </div>
          <h2><?php echo $name ?></h2>
          <!-- <p>Student</p>
          <p>MCA'26 NIT Warangal</p> -->
          <p>
          <?php echo $caption ?>
          </p>
          <ul class="about">
            <li><span>400</span>Followers</li>
            <li><span>322</span>Following</li>
            <li><span>1580</span>Attraction</li>
          </ul>

          <div class="content">
            <p>
              <?php 
                echo $bio
             ?>
          </p>

            <!-- <ul>
              <li><i class="fab fa-twitter"></i></li>
              <i class="fab fa-pinterest"></i>
              <i class="fab fa-facebook"></i>
              <i class="fab fa-dribbble"></i>
            </ul> -->
          </div>
        </div>
        <div class="right__col">
          <nav>
            <ul>
              <li><a href="">photos</a></li>
              <li><a href="">groups</a></li>
              <li><a href="">about</a></li>
            </ul>
          </nav>

          <div class="photos">
            <?php
              
              while($row1 = $result2->fetch_assoc()){
                // $posts = strtolower($row1['posts']);
                // echo $row1['posts'];
            ?>
                <img src="<?php echo $row1['posts'] ?>" alt="Photo" />
            <?php
              }
            ?>
            
          </div>
        </div>
      </div>
    </div>
    <script>
    function showDropdown() {
    document.getElementById("dropdownContent").style.display = "block";
    }
    function hideDropdown() {
    document.getElementById("dropdownContent").style.display = "none";
   }

   document.addEventListener("DOMContentLoaded", function() {
    // Add event listener for "Remove Photo" link
    document.getElementById("removePhoto").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default link behavior
        removePhoto(); // Call removePhoto function
    });
});

function removePhoto() {
    const profileImage = document.getElementById("profileImage");
    profileImage.src = "default.png"; // Set src attribute to empty string to remove the photo
}
</script>
  </body>
</html>