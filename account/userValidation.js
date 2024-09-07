var email = document.getElementById("email");
var password = document.getElementById("password");

function validateForm() {
  if (!validateEmail(email.value)) {
    alert("Invalid email address.");
    email.focus();
    return false;
  }
  if (!validatePassword(password.value)) {
    alert(
      "Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter and one number."
    );
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
  // Password must be >=8 and have least one upper, lowercase and one number
  return (
    password.length >= 8 &&
    /[a-z]/.test(password) &&
    /[A-Z]/.test(password) &&
    /[0-9]/.test(password)
  );
}
