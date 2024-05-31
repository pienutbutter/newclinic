function validateLogin() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var errorMessage = document.getElementById("errorMessage");

    if (username === "" || password === "") {
        errorMessage.innerHTML = "Please fill in all fields.";
        return false;
    }
    return true;
}

function validateRegistration() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var phone = document.getElementById("phone").value;
    var address = document.getElementById("address").value;
    var errorMessage = document.getElementById("errorMessage");

    if (name === "" || email === "" || password === "" || phone === "" || address === "") {
        errorMessage.innerHTML = "Please fill in all fields.";
        return false;
    }
    return true;
}
