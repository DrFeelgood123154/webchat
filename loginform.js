var errorWindow = document.getElementById("errorWindow");
var errorMsg = document.getElementById("errorMsg");
var loginErrorContainer = document.getElementById("loginErrorContainer");
var closeErrorButton = document.getElementById("closeError");

var loginInput = document.getElementById("loginInput");
var passwordInput = document.getElementById("passwordInput");
var accNameInput = document.getElementById("accNameInput");
var accPasswordInput = document.getElementById("accPasswordInput");
var accConfirmPasswordInput = document.getElementById("accConfirmPasswordInput");
var accEmailInput = document.getElementById("accEmailInput");
var submitLoginButton = document.getElementById("submitLoginButton");
var submitRegisterButton = document.getElementById("submitRegisterButton");
var cancelButton = document.getElementById("cancelButton");

function Register(_onSuccess = null){
    var errors = "";
    var accName = accNameInput.value;
    var _password = accPasswordInput.value;
    var confirmPassword = accConfirmPasswordInput.value;
    var _email = accEmailInput.value;
    if(accName.length > 20) errors += "Account name can't be longer than 20 characters.</br>";
    if(accName.length < 2) errors += "Account name can't be shorter than 2 characters.</br>";
    if(_password.length < 5) errors += "Password can't be shorter than 5 characters.</br>";
    if(_password.length > 30) errors += "Password can't be longer than 30 characters. You're not registering a bank account.</br>";
    if(_password !== confirmPassword) errors += "Password does not match (confirm password is different from password)</br>";

    if(errors != ""){
        errorMsg.innerHTML = errors;
        errorWindow.style.display = "block";
        return;
    }
    errorMsg.innerHTML = "Waiting for server's response...";
    errorWindow.style.display = "block";
    $.ajax({
        timeout: 30000,
        url: '/loginRequest.php',
        data: {action: 'Register', accname: accName, password: _password, email: _email},
        type: 'post',
        dataType: 'json',
        success: function(response){
            if(response == ""){
                errorMsg.innerHTML = "Failed to get response from the server";
                errorWindow.style.display = "block";
            }else if(response[0] == 0){
                errorMsg.innerHTML = response[1];
                errorWindow.style.display = "block";
            }else{
                ///some stuff after register is completed
                errorMsg.innerHTML = response[1];
                errorWindow.style.display = "block";
                loginErrorContainer.innerHTML = "You have successfully registered and can now log in to your account: "+accName;
                if(_onSuccess != null) _onSuccess();
            }
        },
        error: function(xml, status, msg){
            if(status === "timeout") errorMsg.innerHTML = "Request timed out";
            else errorMsg.innerHTML = "Register request failed: "+msg;
            console.log(xml);
            errorWindow.style.display = "block";
        }
    });
}

function Login(){
    var errors = "";
    var login = loginInput.value;
    var password = passwordInput.value;
    var stayLoggedIn = $('#login_stayLoggedIn').is(':checked');

    if(login.length < 2) errors += "Login can't be shorter than 2 characters.</br>";
    if(password.length < 5) errors += "Password can't be shorter than 5 characters.</br>";

    if(errors != ""){
        loginErrorContainer.innerHTML = errors;
        return;
    }
    loginErrorContainer.innerHTML = "Logging in...";
    errorWindow.style.display = "block";
    $.ajax({
        timeout: 30000,
        url: '/loginRequest.php',
        data: {action: 'Login', login: login, password: password, stayLoggedIn: stayLoggedIn},
        type: 'post',
        dataType: 'json',
        success: function(response){
            if(response == "") loginErrorContainer.innerHTML = "Failed to get response from the server";
            else if(response[0] == 0) loginErrorContainer.innerHTML = response[1];
            else{
                ///logged in
                loginErrorContainer.innerHTML = "";
                if(typeof OnLoginSuccess == "function") OnLoginSuccess(response[2]);
                if(stayLoggedIn) SetCookie("n4kx", response[3]);
                else SetCookie("n4kx", '');

                ReloadMessages();
            }
        },
        error: function(xhr, status, msg){
            if(status === "timeout") loginErrorContainer.innerHTML = "Request timed out";
            else loginErrorContainer.innerHTML = "Login request failed: "+status;
            console.log(msg);
            errorWindow.style.display = "block";
        }
    });
    errorWindow.style.display = "none";
}

function AutoLogin(){
    var authKey = GetCookie("n4kx");
    $.ajax({
        timeout: 30000,
        url: '/loginRequest.php',
        data: {action: 'AutoLogin', key: authKey},
        type: 'post',
        dataType: 'json',
        success: function(response){
            if(response[0] != 0){
                SetCookie("n4kx", '');
                console.log(response[0]);
            }else{
                ///logged in
                console.log("Autologin: "+response[1])
                loginErrorContainer.innerHTML = "";
                if(typeof OnLoginSuccess == "function") OnLoginSuccess(response[2]);
                SetCookie("n4kx", response[3]);

                ReloadMessages();
            }
        },
        error: function(xhr, status, msg){
            console.log("Autologin request failed: "+msg);
            console.log(xhr);
        }
    });
}

$('#loginInput').keydown(function (e){
    if(e.keyCode == 13) {
        e.preventDefault();
        Login();
    }
});
$('#passwordInput').keydown(function (e){
    if(e.keyCode == 13) {
        e.preventDefault();
        Login();
    }
});

$('#accNameInput').keydown(function (e){
    if(e.keyCode == 13) {
        e.preventDefault();
        Register();
    }
});
$('#accPasswordInput').keydown(function (e){
    if(e.keyCode == 13) {
        e.preventDefault();
        Register();
    }
});
$('#accConfirmPasswordInput').keydown(function (e){
    if(e.keyCode == 13) {
        e.preventDefault();
        Register();
    }
});
$('#accEmailInput').keydown(function (e){
    if(e.keyCode == 13) {
        e.preventDefault();
        Register();
    }
});

$('#submitLoginButton').on("click", function(){
    Login();
});
$('#submitRegisterButton').on("click", function(){
    if(typeof OnRegisterSuccess == "function") Register(OnRegisterSuccess)
    else Register();
});

$(document).ready(function(){
    if(!silentEnter && userName == "" && GetCookie("n4kx") != ""){
        console.log("Autologin");
        AutoLogin();
    }
});
