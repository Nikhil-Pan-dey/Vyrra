
<?php
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];

    // Example validation check (replace with your actual logic)
    $emailExists = validateEmail($email);
    $usernameExists = validateUsername($username);

    if ($emailExists && $usernameExists) {
        echo 'valid'; // Both email and username are valid
    } else if (!$emailExists) {
        echo 'emailInvalid'; // Email already exists
    } else if (!$usernameExists) {
        echo 'usernameInvalid'; // Username already exists
    }
}

function validateEmail($email) {
    global $con;
    $result = $con->query("SELECT * FROM users WHERE email = '$email'");
    return $result->num_rows > 0;
}

function validateUsername($username) {
    global $con;
    $result = $con->query("SELECT * FROM users WHERE username = '$username'");
    return $result->num_rows > 0;
}
?>
