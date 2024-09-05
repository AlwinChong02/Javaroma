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
    const re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validatePassword(password) {
    if (password.length > 8 &&
        password.match(/[a-z]/) &&
        password.match(/[A-Z]/) &&
        password.match(/[0-9]/) &&
        password.match(/[!@#$%^&*()_\[\]{}?]/))   // special characters like ! @ # $ % ^ & * ( ) _ [ ] { } ?
            return true;
    return false;

}