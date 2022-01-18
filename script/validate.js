let username = document.getElementById('username');
let password = document.getElementById('password');
let confirmPassword = document.getElementById('password2');
let email = document.getElementById('email');
let submit = document.getElementById('submit');
let registerForm = document.getElementById('register');
// errors
let usernameError = document.getElementsByClassName('username-error');
let passwordError = document.getElementsByClassName('password-error');
let confirmPasswordError = document.getElementsByClassName('password2-error');
let emailError = document.getElementsByClassName('email-error');

//handle onkeyup event for username input validation
username.onkeyup = function () {
    if (username.value.length < 6) {
        usernameError[0].innerHTML = 'Username must be at least 6 characters long';
        usernameError[0].style.color = 'red';
    } else {
        usernameError[0].innerHTML = '';
    }
}

email.onkeyup = function () {
    // regular expression for email validation
    let emailReg = /^([a-zA-Z0-9_\-.]+)@([a-zA-Z0-9_\-.]+)\.([a-zA-Z]{2,5})$/;
    // check if email is valid with regular expression
    if (emailReg.test(email.value) === false) {
        emailError[0].innerHTML = 'Invalid Email Address';
        emailError[0].style.color = 'red';
    } else {
        emailError[0].innerHTML = '';
    }
}

password.onkeyup = function () {
    if (password.value.length < 6) {
        passwordError[0].innerHTML = 'Password must be at least 6 characters long';
        passwordError[0].style.color = 'red';
    } else {
        passwordError[0].innerHTML = '';
    }
}

confirmPassword.onkeyup = function () {
    if (confirmPassword.value !== password.value) {
        confirmPasswordError[0].innerHTML = 'Passwords do not match';
        confirmPasswordError[0].style.color = 'red';
    } else {
        confirmPasswordError[0].innerHTML = '';
    }
}

// handle onsubmit event
registerForm.onsubmit = function (e) {
    if (username.value.length < 6) {
        usernameError[0].innerHTML = 'Username must be at least 6 characters long';
        usernameError[0].style.color = 'red';
        e.preventDefault();

    }  if (email.value.length < 6) {
        emailError[0].innerHTML = 'Invalid Email Address';
        emailError[0].style.color = 'red';
        e.preventDefault();

    }  if (password.value.length < 6) {
        passwordError[0].innerHTML = 'Password must be at least 6 characters long';
        passwordError[0].style.color = 'red';
        e.preventDefault();

    }  if (confirmPassword.value !== password.value) {
        confirmPasswordError[0].innerHTML = 'Passwords do not match';
        confirmPasswordError[0].style.color = 'red';
        e.preventDefault();
    } else {
        registerForm.submit();
    }
}



