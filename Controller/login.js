function userPasswordValidation() {
    var username = document.forms["loginInfo"]["username"].value;
    var password = document.forms["loginInfo"]["password"].value;
    //todo @vito chen update this after jerry created users table.
    if (username === "admin" && password === "123") {
        return true;
    }
    else {
        alert("Login in infomation incorrect.");
        return false;
    }
          
}