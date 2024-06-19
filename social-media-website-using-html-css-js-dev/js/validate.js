function validate(){
    let email = document.getElementById('email');
    let password = document.getElementById('password');
    let heading = document.getElementById('h3');
    let username = document.getElementById('username');
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
    
    $.ajax({
        type: 'POST',
        url: 'validate_mail.php', 
        data: { email: email , username: username }, 
        success: function(response) {
            if (response === 'valid') {
                document.getElementById('signupForm').submit();

            } else if(response === 'emailInvalid'){
                email.style.border = '2px solid red';
                h3.innerText = 'Email already exist';
                heading.style.visibility= 'visible';
            } else if(response === 'usernameInvalid'){
                username.style.border = '2px solid red';
                h3.innerText = 'Username already exist';
                heading.style.visibility= 'visible';
            }

        },
        error: function() {
            console.error('Error validating email');
        }
    });


    return false;
}