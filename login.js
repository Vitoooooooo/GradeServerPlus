function userPasswordValidation() {
    var username = document.forms["loginInfo"]["username"].value;
    var password = document.forms["loginInfo"]["password"].value;
          
    if (username === "admin" && password === "admin") {
        return true;
    }
    else {
        alert("Login in infomation incorrect.");
        return false;
    }
          
}