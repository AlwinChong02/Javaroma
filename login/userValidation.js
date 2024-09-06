var email = document.getElementById("email");
var password = document.getElementById("password");



function validateForm() {
    if (!validateEmail(email.value)) {
        alert("Invalid email address.");
        email.focus();
        return false;
    }
    if (!validatePassword(password.value)) {
        alert("Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one number and one special character.");
        password.focus();
        return false;
    }
    return true;
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validatePassword(password) {
    return password.length >= 8;
}


