<?php
require 'connection.php';

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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username or email already exists
    if (usernameExists($con, $username)) {
        echo "<script> showModal('Username already exists!') </script>";
        return;
    }

    if (emailExists($con, $email)) {
        echo "<script> showModal('Email already exists!') </script>";
        return;
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();

    // Redirect after successful signup
    header("Location: home.html");
    exit();
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['login'])){
        
    } elseif(isset($_POST['signup'])){
        insert($con);
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
                <div id="for-back-phone"></div>
            </div>
            <div id="phone-frame2">
                <div id="for-images"></div>
            </div>
        </div>
    </div>

    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form action="" method="post" onsubmit="return validate()" id="signupForm">
                <label for="chk" aria-hidden="true">Sign up</label>
                <h3 id="h3"></h3>
                <input type="text" name="username" id="username" placeholder="User name" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
        
        <div class="login">
            <form action="" method="post">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="pswd" placeholder="Password" required>
                <button type="submit" name="login">Log IN</button>
            </form>
        </div>
    </div>

    <script>
        let email = document.getElementById('email');
        let password = document.getElementById('password');
        let heading = document.getElementById('h3');
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
                heading.innerText = 'Email is invalid';
                heading.style.visibility = 'visible';
                return false;
            }
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/;
            
            if (!passwordRegex.test(password.value)) {
                password.style.border = '2px solid red';
                heading.innerText = 'Password is invalid';
                heading.style.visibility = 'visible';
                return false;
            }
            return true;
        }

        function showModal(message) {
            heading.innerText = message;
            heading.style.visibility= 'visible';
        }
    </script>
</body>
</html>
