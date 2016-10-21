<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.js"></script>
    <script type="text/javascript" src="login.js"></script>

    <meta charset="utf8">
    <title>EGR 223</title>
</head>

<body>
    <div class="navbar">
      <nav class="transparent z-depth-0">
        <div class="nav-wrapper">
            <div class="row">
                <h4 class="col s2 grey-text text-darken-2">Plan</h4>
            </div>
        </div>
      </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 push-m3">
                <div class="row">
                    <div id="login-card" class="card col s12 center-align">
                        <form name="form" method="post">
                            <div class="card-content">
                                <div class="card-title">
                                    <h5 class="center-align">Let's Get Planning!</h1>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                      <ul class="tabs">
                                        <li class="tab col s3"><a id="login-tab" class="active user-color-text" onclick="tabSwitch(0)">Log In</a></li>
                                        <li class="tab col s3"><a id="register-tab" class="user-color-text" onclick="tabSwitch(1)">Register</a></li>
                                      </ul>
                                    </div>
                                </div>
                                <div id="login-form">
                                    <input placeholder="Email" name="email" id="login-email" type="email" class="validate">
                                    <input placeholder="Password" name="password" id="login-password" type="password" class="validate">
                                    <div id="login-error" class="row">
                                        <div class="col s8 push-s2">
                                            <div class="card red">
                                                <p class="white-text center-align">Uh oh! An error occured!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="register-form">
                                    <input placeholder="Username (This can be changed at any time!)" name="username" id="register-username" type="text" class="validate">
                                    <input placeholder="Email" name="email" id="register-email" type="email" class="validate">
                                    <input placeholder="Password" name="password" id="register-password" type="password" class="validate">
                                    <div class="row m-bottom">
                                        <h5 class="col s4">Favorite Color:</h5>
                                        <a id="picked-color" class="color-picked hoverable waves-effect waves-light card" style="float:left"></a>
                                    </div>
                                    <div class="row">
                                        <div class="color-picker center-align">
                                            <div class="row">
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#e53935" onclick="changeColor('#e53935')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#d81b60" onclick="changeColor('#d81b60')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#8e24aa" onclick="changeColor('#8e24aa')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#5e35b1" onclick="changeColor('#5e35b1')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#039be5" onclick="changeColor('#039be5')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#00acc1" onclick="changeColor('#00acc1')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#00897b" onclick="changeColor('#00897b')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#43a047" onclick="changeColor('#43a047')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#fdd835" onclick="changeColor('#fdd835')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#ffb300" onclick="changeColor('#ffb300')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#fb8c00" onclick="changeColor('#fb8c00')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#f4511e" onclick="changeColor('#f4511e')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#6d4c41" onclick="changeColor('#6d4c41')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#546e7a" onclick="changeColor('#546e7a')"></a>
                                            </div>
                                            <div class="row">
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#d32f2f" onclick="changeColor('#d32f2f')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#c2185b" onclick="changeColor('#c2185b')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#7b1fa2" onclick="changeColor('#7b1fa2')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#512da8" onclick="changeColor('#512da8')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#0288d1" onclick="changeColor('#0288d1')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#0097a7" onclick="changeColor('#0097a7')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#00796b" onclick="changeColor('#00796b')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#388e3c" onclick="changeColor('#388e3c')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#fbc02d" onclick="changeColor('#fbc02d')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#ffa000" onclick="changeColor('#ffa000')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#f57c00" onclick="changeColor('#f57c00')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#e64a19" onclick="changeColor('#e64a19')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#5d4037" onclick="changeColor('#5d4037')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#455a64" onclick="changeColor('#455a64')"></a>
                                            </div>
                                            <div class="row">
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#c62828" onclick="changeColor('#c62828')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#ad1457" onclick="changeColor('#ad1457')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#6a1b9a" onclick="changeColor('#6a1b9a')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#4527a0" onclick="changeColor('#4527a0')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#0277bd" onclick="changeColor('#0277bd')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#00838f" onclick="changeColor('#00838f')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#00695c" onclick="changeColor('#00695c')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#2e7d32" onclick="changeColor('#2e7d32')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#f9a825" onclick="changeColor('#f9a825')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#ff8f00" onclick="changeColor('#ff8f00')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#ef6c00" onclick="changeColor('#ef6c00')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#d84315" onclick="changeColor('#d84315')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#4e342e" onclick="changeColor('#4e342e')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#37474f" onclick="changeColor('#37474f')"></a>
                                            </div>
                                            <div class="row">
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#b71c1c" onclick="changeColor('#b71c1c')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#880e4f" onclick="changeColor('#880e4f')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#6a1b9a" onclick="changeColor('#6a1b9a')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#311b92" onclick="changeColor('#311b92')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#01579b" onclick="changeColor('#01579b')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#006064" onclick="changeColor('#006064')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#004d40" onclick="changeColor('#004d40')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#1b5e20" onclick="changeColor('#1b5e20')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#f57f17" onclick="changeColor('#f57f17')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#ff6f00" onclick="changeColor('#ff6f00')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#e65100" onclick="changeColor('#e65100')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#bf360c" onclick="changeColor('#bf360c')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#3e2723" onclick="changeColor('#3e2723')"></a>
                                                <a class="color-box hoverable waves-effect waves-light card" style="background-color:#263238" onclick="changeColor('#263238')"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="register-error" class="row">
                                        <div class="col s8 push-s2">
                                            <div class="card red">
                                                <p class="white-text center-align">Uh oh! An error occured!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            <div class="card-action">
                                <a id="login-action" type="submit" class="waves-effect waves-light btn col s4 push-s4 user-color" onclick="login('','')">Login</a>
                                <a id="register-action" type="submit" class="waves-effect waves-light btn col s4 push-s4 user-color" onclick="register()">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</body>