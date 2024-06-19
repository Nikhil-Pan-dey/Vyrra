<?php
    require 'connection.php';
    session_start(); // Start the session

    if (isset($_SESSION['mail'])) {
        header("Location: home.php");
        exit();
    }

    function usernameExists($con, $username){
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    function emailExists($con, $email){
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    function insert($con){
        global $loginError;
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (usernameExists($con, $username)) {
            // echo "<script> alert('Username already exists!') </script>";
            $loginError = "Username already exists!";
            return;
        }
        if (emailExists($con, $email)) {  
            // echo "<script> alert('email already exists!') </script>";
            $loginError = "email already exists!";
            return;
        }
        $stmt = $con->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        return $email;
        // header("Location: home.html");
        // exit();
    }   

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['login'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (emailExists($con, $email)) {  
                $result2 = $con->query("Select password from users where email = '$email'");
                $row = $result2->fetch_assoc();
                $dbPassword = $row['password'];
                if($password == $dbPassword){
                    $authenticatedMail = $email;
                    $_SESSION['mail'] = $authenticatedMail; // Store username in session
                    header("Location: home.php"); // Redirect to home page
                    exit();
                    // header("Location: home.html");
                    // exit();
                }else{
                    // echo "<script>";
                    // echo " let heading = document.getElementById('h3'); ";
                    // echo " heading.style.visibility= 'visible'; ";
                    // echo " </script>";
                    $loginError = "Email or password is incorrect.";
                }    
            }else{
                // echo "<script>";
                // echo " let heading = document.getElementById('h3'); ";
                // echo " heading.style.visibility= 'visible'; ";
                // echo " </script>";   
                $loginError = "Email or password is incorrect.";
            }
        }elseif(isset($_POST['signup'])){
            $authenticatedMail = insert($con);
            $_SESSION['mail'] = $authenticatedMail; // Store username in session
            header("Location: home.php"); // Redirect to home page
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Vyrra</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="images/vyrra-removebg-preview copy.png">
    </head>        

    <body>

        <div id="main-container">
            <div id="image-container">
                <div id="phone-frame1">
                    <div id="for-back-phone">
                    </div>
                </div>
                <div id="phone-frame2">
                    <div id="for-images">
                    </div>
                </div>
            </div>
        </div>

        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="signup">
                <form action="" method="post" onsubmit="return validate()" id="signupForm">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <h3 id="heading"></h3>
                    <?php if (isset($loginError)) { ?>
                    <h3 id="h3" style="visibility: <?php echo isset($loginError) ?  'visible': 'hidden'; ?>;"  ><?php echo isset($loginError) ? $loginError : ''; ?></h3>
                    <?php } ?>
                    <input type="text" name="username" id="username" placeholder="User name" required>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <input type="Password" name="password" id="password" placeholder="Password" required>
                    <a href="home.html" class="nikhilLink">
                        <button type="submit" name="signup">Sign Up</button>
                    </a>
                </form>
            </div>
            
            <div class="login">
                <form action="" method="post" id="loginForm">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="Password" name="password" placeholder="Password" required>
                    <a href="home.html" class="nikhilLink">
                        <button type="submit" name="login">Log IN</button>
                    </a>
                </form>
            </div>
            
        </div>   
        <!-- <script src="/social-media-website-using-html-css-js-dev/js/validate.js"></script>     -->
        <script>
            let email = document.getElementById('email');
            let password = document.getElementById('password');
            let heading = document.getElementById('heading');
            let username = document.getElementById('username');
            function validate(){
                email.style.border = 'none';
                password.style.border = 'none';
                username.style.border = 'none';
                heading.innerText = "";
                heading.style.visibility = 'hidden';
                const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
                if (!gmailRegex.test(email.value)) {
                    email.style.border = '2px solid red';
                    heading.innerText = 'mail is invalid';
                    heading.style.visibility= 'visible';
                    return false;
                }
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/;
                
                if (!passwordRegex.test(password.value)) {
                    password.style.border = '2px solid red';
                    heading.innerText = 'password is invalid';
                    heading.style.visibility= 'visible';
                    return false;
                }
                return true;
            }

            
        </script>
    </body>
    </html>