// Disable Form Resubmition
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

// Show Password
function showPassword() {
    var checkbox = document.getElementById("show-password-cb");
    var passwordField = document.getElementById("password");
    
    if (checkbox.checked) {
    passwordField.type = "text";
    } else {
    passwordField.type = "password";
    }
}