<?php
    require 'connection.php';
    session_start();
      if (isset($_SESSION['mail'])) {
            $mail = $_SESSION['mail'];
            $result = $con->query("SELECT * FROM `user-info` WHERE email = '$mail'");
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pic = $row['profilePic'];
                $name = $row['Name'];
            } else {
                $pic = "default.avif"; 
            }
            $result2 = $con->query("SELECT * FROM `friends` WHERE mail = '$mail'");

      } else {
        $pic = "default.avif";
      }



?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Social Media Profile</title>
<link rel="stylesheet" href="css/friends.css">
<base href="images/">
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <div class="profile-picture">
                <img src="<?php echo $pic; ?>" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <div class="username"><?php echo $name; ?></div>
                <div class="bio"></div>
            </div>
        </div>
        <div class="friends-section">
            <h2>My Friends</h2>
            <div class="friends-list">
                <?php
                    if($result2->num_rows > 0){
                        while($row = $result2->fetch_assoc()){
                            $fmail = $row['friendMail'];
                            $result3 = $con->query("SELECT * FROM `user-info` WHERE email = '$fmail'");
                            if ($result3->num_rows > 0) {
                            // $result3->fetch_assoc()['Name']; 
                            $row1 = $result3->fetch_assoc();
                            $fpic = $row1['profilePic'] ?? '';
                            $fName = $row1['Name'] ;
                ?>
                            <div class="friend" style="border:2px solid red" onclick="showFriend()">
                                <img src="<?php echo $fpic ?>" alt="Friend 1">
                                <div><?php echo $fName ?></div>
                                <div class="mutual-friends">Mutual Friends: 10</div>
                            </div> 
                <?php   
                            }  
                        }
                    }else{
                        echo "No data to fetch";
                    }
                ?>
                
            </div>
        </div>

        <div class="blank-container">
            <div class="blank-space">
                <div class="profile-picture1">
                    <img src="../images/aashu.png" alt="">
                </div>
                <div class="profile-info1">
                    <h2>Username</h2>
                    <p>Followers: 1000</p>
                    <p>Following:328</p>
                    <p>Interactions:590</p>
                </div>
                </div>  
                <div class="bio-section">
                    <p>Bio: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut lacinia leo. Duis ultricies tortor non ullamcorper posuere.</p>
                </div>
                <div class="section-headings">
                    <h3>Posts</h3>
                    <h3>Groups</h3>
                    <h3>Friends</h3>
                </div>
                <div class="smaller-divs">
                    <div class="smaller-div"></div>
                    <div class="smaller-div"></div>
                    <div class="smaller-div"></div>
                    <div class="smaller-div"></div>
                    <div class="smaller-div"></div>
                    <div class="smaller-div"></div>
                    
                </div>

        </div>
        <!-- <div class="blank-container">
            
        </div> -->

        
        <div class="suggestions-section">
            <h2>Suggestions</h2>
            <div class="suggestions-list">
                <!-- Add suggestions here -->
                <div class="suggestion">
                    <img src="shu.png" alt="Friend 4">
                    <div>Shubham Das</div>
                    <div class="mutual-friends">Mutual Friends: 3</div>
                    <div class="suggestion-buttons">
                        <button class="add-friend">Add Friend</button>
                        <button class="message">Message</button>
                    </div>
                </div>
                <div class="suggestion">
                    <img src="bra.png" alt="Friend 5">
                    <div>Brajesh Kumar</div>
                    <div class="mutual-friends">Mutual Friends: 5</div>
                    <div class="suggestion-buttons">
                        <button class="add-friend">Add Friend</button>
                        <button class="message">Message</button>
                    </div>
                </div>
                <div class="suggestion">
                    <img src="raj.png" alt="Friend 6">
                    <div>Rajdeep Singh Rathore</div>
                    <div class="mutual-friends">Mutual Friends: 2</div>
                    <div class="suggestion-buttons">
                        <button class="add-friend">Add Friend</button>
                        <button class="message">Message</button>
                    </div>
                </div>
                <div class="suggestion">
                    <img src="shu.png" alt="Friend 4">
                    <div>Shubham Das</div>
                    <div class="mutual-friends">Mutual Friends: 3</div>
                    <div class="suggestion-buttons">
                        <button class="add-friend">Add Friend</button>
                        <button class="message">Message</button>
                    </div>
                </div>
                <div class="suggestion">
                    <img src="bra.png" alt="Friend 5">
                    <div>Brajesh Kumar</div>
                    <div class="mutual-friends">Mutual Friends: 5</div>
                    <div class="suggestion-buttons">
                        <button class="add-friend">Add Friend</button>
                        <button class="message">Message</button>
                    </div>
                </div>
                <div class="suggestion">
                    <img src="raj.png" alt="Friend 6">
                    <div>Rajdeep Singh Rathore</div>
                    <div class="mutual-friends">Mutual Friends: 2</div>
                    <div class="suggestion-buttons">
                        <button class="add-friend">Add Friend</button>
                        <button class="message">Message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showFriend(){
            // e.preventDefault();
            console.log("hello");
            let friend = document.getElementsByClassName("blank-container");
            console.log(friend);
            // friend.style.visibility = "visible";
            // friend.style.backgroundColor = "red";
        }
    </script>
</body>
</html>
