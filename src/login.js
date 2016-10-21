function initialize() {
    $("body").css("background", "url(http://mycolorscreen.com/wp-content/uploads/wallpapers_2012/240957/2.jpg)");
    $("body").css("background-size", "cover");
    
    $(".user-color").css("background-color", $("#picked-color").css("background-color"));
    
    $("#login-error").hide();
    $("#register-error").hide();
    tabSwitch(0);
}

// Switches between the login and register tab.
function tabSwitch(num) {
    $(".tab").removeClass("active");
    if (num == 0) {
        $("#login-tab").addClass("active");
        $("#register-form").hide(200);
        $("#register-action").hide(100);
        $("#login-form").show();
        $("#login-action").show();
    } else {
        $("#register-tab").addClass("active");
        $("#login-form").hide();
        $("#login-action").hide();
        $("#register-form").show(200);
        $("#register-action").show(100);
    }
}

// Changes the color chosen.
function changeColor(color) {
    $("#picked-color").css("background-color", color);
    $(".user-color").css("background-color", color);
}

// Checks to see if the credentials are valid, then acts accoordingly.
function login(email, password) {
    var data = {};
    if (email != "" || password != "") {
        data.email = email;
        data.password = password;
    } else {
        data.email = $("#login-email").val();
        data.password = $("#login-password").val();
    }
    
    $.post("PHP/user/loginAuth.php", 
    { 
        json : JSON.stringify(data)
    }).always(function(result) {
        console.log(result);
        if (result == 1) {
            window.location.href = "index.php";
        } else if (result == 0) {
            $("#login-error p").text("Oops! Your email/password combo is incorrect!");
            $("#login-error").show();
        }
    });
}

// Registers a user and then logs them in.
function register() {
    var data = {};
    data.username = $("#register-username").val();
    data.color = hexc($("#picked-color").css("background-color"));
    data.email = $("#register-email").val();
    data.password = $("#register-password").val();
    
    if (data.username == "" || data.email == "" || data.password == "") {
        $("#register-error p").text("Whoops! Make sure to fill in every detail!");
        $("#register-error").show();
    } else {
        $.post("PHP/user/registerAuth.php", 
        { 
            json: JSON.stringify(data) 
        }).always(function(result) {
            console.log(result);
            if (result.substr(0,1) == '1') {
                login(data.email, data.password);
            } else if (result == 0) {
                $("#register-error p").text("Uh oh! This email is already in use!");
                $("#register-error").show();
                
            } else {
                $("#register-error p").text("An error occured. Sorry about that!");
                $("#register-error").show();
            }
        });
    }
}

// Converts rgb colors to hexadecimal form.
function hexc(colorval) {
    var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    delete(parts[0]);
    for (var i = 1; i <= 3; ++i) {
        parts[i] = parseInt(parts[i]).toString(16);
        if (parts[i].length == 1) parts[i] = '0' + parts[i];
    }
    var color = '#' + parts.join('');
    return color;
}

$(document).ready(function() {
    initialize();
});