<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.js"></script>
    <script type="text/javascript" src="app.js"></script>

    <meta charset="utf8">
    <title>Plan</title>
</head>

<body class="grey lighten-3">

     <?php
        session_start();
        
        // Checks to see if the user is logged in. If not, redirect to the login page.
        if (!(isset($_SESSION['id']) && $_SESSION['id'] != '')) {
          header ("Location: login.php");
        }
      ?>
      
    <div class="notification-all card grey lighten-4 z-depth-2">
        <div class="container sidebar-container">
            <div class="sidebar-header-row row">
                <div class="col s12">
                    <nav>
                        <div class="nav-wrapper user-color row">
                            <a href="#" class="back-btn col s1 tooltipped" data-position="right" data-delay="50" data-tooltip="Back"><i class="large material-icons">chevron_left</i></a>
                            <a id="sidebar-header" class="brand-logo col s9 center-align truncate" >Plan</a>
                            <a href="#" class="exit-btn col s1 push-s9 tooltipped" data-position="right" data-delay="50" data-tooltip="Exit" onclick="showSideMenu(0)"><i class="large material-icons">clear</i></a>
                        </div>
                    </nav>
                </div>
            </div>
            
            <a id="edit-btn" class="btn-floating btn-large waves-effect waves-light user-color tooltipped" data-position="left" data-delay="50" data-tooltip="Edit">
                <i class="material-icons">create</i>
            </a>
            
            <div class="sidebar-content scroll-view">
                <div class="create-tabs row z-depth-1">
                    <div class="col s12">
                        <ul class="tabs white">
                            <li class="tab col s4"><a class="active user-color-text" onclick="createSwitch(0)">Event</a></li>
                            <li class="tab col s4"><a class="user-color-text" onclick="createSwitch(1)">Course</a></li>
                            <li class="tab col s4"><a class="user-color-text" onclick="createSwitch(2)">Semester</a></li>
                            <div class="indicator user-color" style="z-index:1"></div>
                        </ul>
                    </div>
                </div>
                <div class="sidebar-content-view"></div>
                <div class="event-edit">
                    <div class="row">
                        <div class="input-field col s10 offset-s1">
                            <input id="ee-name" type="text" class="validate" data-error="wrong" data-success="right" placeholder="Event Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s5 offset-s1">
                            <select id="ee-type">
                                <option value="0">Homework</option>
                                <option value="1">Project</option>
                                <option value="2">Quiz</option>
                                <option value="3">Test</option>
                                <option value="4">Extra Credit</option>
                                <option value="5">Meeting</option>
                                <option value="6">Event</option>
                            </select>
                            <label>Event Type</label>
                        </div>
                        <div class="input-field col s5">
                            <select id="ee-course"></select>
                            <label>Class Select</label>
                        </div>
                        <div class="input-field col s4 offset-s1">
                            <select id="ee-month">
                                <option value="0">January</option>
                                <option value="1">February</option>
                                <option value="2">March</option>
                                <option value="3">April</option>
                                <option value="4">May</option>
                                <option value="5">June</option>
                                <option value="6">July</option>
                                <option value="7">August</option>
                                <option value="8">September</option>
                                <option value="9">October</option>
                                <option value="10">November</option>
                                <option value="11">December</option>
                            </select>
                            <label>Month</label>
                        </div>
                        <div class="input-field col s2">
                            <input id="ee-day" type="number" min="1" max="31" class="validate" data-error="Invalid" data-success="Valid" placeholder="Day">
                        </div>
                        <div class="input-field col s4">
                            <input id="ee-year" type="number" min="0000" max="9999" class="validate" data-error="Invalid" data-success="Valid" placeholder="Year">
                        </div>
                        <h6 class="col s3 offset-s1">Start:</h6>
                        <div class="input-field col s2">
                            <select id="ee-s-hour">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <label>Hour</label>
                        </div>
                        <h4 class="col s1">:</h4>
                        <div class="input-field col s2">
                            <input id="ee-s-minute" type="number" min="0" max="59" class="validate" data-error="Invalid" data-success="Valid" placeholder="Min">
                        </div>
                        <div class="input-field col s2">
                            <select id="ee-s-time">
                                <option value="0">AM</option>
                                <option value="1">PM</option>
                            </select>
                            <label>AM/PM</label>
                        </div>
                        <h6 class="col s2 offset-s1">End<br/>(optional):</h6>
                        <div class="input-field col s2 offset-s1">
                            <select id="ee-e-hour">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">None</option>
                            </select>
                            <label>Hour</label>
                        </div>
                        <h4 class="col s1">:</h4>
                        <div class="input-field col s2">
                              <input id="ee-e-minute" type="number" min="0" max="59" class="validate" data-error="Invalid" data-success="Valid" placeholder="Min">
                        </div>
                        <div class="input-field col s2">
                            <select id="ee-e-time">
                                <option value="0">AM</option>
                                <option value="1">PM</option>
                            </select>
                            <label>AM/PM</label>
                        </div>
                
                        <div class="card col s10 offset-s1">
                            <textarea id="ee-description" class="materialize-textarea" placeholder="Description (optional)"></textarea>
                        </div>
                
                        <div class="card col s10 offset-s1">
                            <h5>Milestones</h5>
                            <ul id="ee-milestones" class="collection with-header"></ul>
                        </div>
                        <div class="col s10 offset-s1 center-align">
                            <div class="row">
                                <a class="submit waves-effect white grey-text text-darken-2 btn"><i class="material-icons left green-text">done</i>Submit</a>
                                <a class="cancel waves-effect white grey-text text-darken-2 btn"><i class="material-icons left red-text">clear</i>Cancel</a>
                            </div>
                            <div class="row">
                                <a class="delete waves-effect white grey-text text-darken-2 btn"><i class="material-icons left">delete_forever</i>Delete</a>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </div>
                <div class="course-edit"> 
                    <div class="row">
                        <div class="input-field col s10 offset-s1">
                            <input id="ce-name" type="text" class="validate m-bottom" data-error="Invalid" data-success="Valid" placeholder="Course Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s5 offset-s1">
                            <input id="ce-code" type="text" class="validate" length="8" data-error="Invalid" data-success="Valid" placeholder="Course Code">
                        </div>
                        <div class="input-field col s5">
                            <select id="ce-semester"></select>
                            <label>Semester</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s5 offset-s1">
                            <select id="ce-days" multiple>
                                <option value="" disabled selected>Choose your option</option>
                                <option value="0">Sunday</option>
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                            </select>
                            <label>Meeting Days</label>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="col s3 offset-s1">Start:</h6>
                        <div class="input-field col s2">
                            <select id="ce-s-hour">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <label>Hour</label>
                        </div>
                        <h4 class="col s1">:</h4>
                        <div class="input-field col s2">
                            <input id="ce-s-minute" type="number" min="0" max="59" class="validate" data-error="Invalid" data-success="Valid" placeholder="Min">
                        </div>
                        <div class="input-field col s2">
                            <select id="ce-s-time">
                                <option value="0">AM</option>
                                <option value="1">PM</option>
                            </select>
                            <label>AM/PM</label>
                        </div>
                        <h6 class="col s2 offset-s1">End<br/>(optional):</h6>
                        <div class="input-field col s2 offset-s1">
                            <select id="ce-e-hour">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <label>Hour</label>
                        </div>
                        <h4 class="col s1">:</h4>
                        <div class="input-field col s2">
                              <input id="ce-e-minute" type="number" min="0" max="59" class="validate" data-error="Invalid" data-success="Valid" placeholder="Min">
                        </div>
                        <div class="input-field col s2">
                            <select id="ce-e-time">
                                <option value="0">AM</option>
                                <option value="1">PM</option>
                            </select>
                            <label>AM/PM</label>
                        </div>
                        <div class="card col s10 offset-s1">
                            <textarea id="ce-description" class="materialize-textarea" placeholder="Description (optional)" ></textarea>
                        </div>
                        
                        <div class="card col s10 offset-s1">
                            <div class="row m-bottom">
                                <h5 class="col s3">Color:</h5>
                                <a class="color-picked hoverable waves-effect waves-light card"></a>
                            </div>
                            <div class="row m-bottom">
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
                        </div>
                       <div class="col s10 offset-s1 center-align">
                            <div class="row">
                                <a class="submit waves-effect white grey-text text-darken-2 btn"><i class="material-icons left green-text">done</i>Submit</a>
                                <a class="cancel waves-effect white grey-text text-darken-2 btn"><i class="material-icons left red-text">clear</i>Cancel</a>
                            </div>
                            <div class="row">
                                <a class="delete waves-effect white grey-text text-darken-2 btn"><i class="material-icons left">delete_forever</i>Delete</a>
                            </div>
                        </div>
                    </div><br/><br/><br/><br/><br/><br/><br/><br/> 
                </div>
                <div class="semester-edit">
                    <div class="row">
                        <div class="input-field col s10 offset-s1">
                            <input id="se-name" type="number" min="1" max="31" class="validate" data-error="Invalid" data-success="Valid" placeholder="Semester Name">
                        </div>
                        <h5 class="col s10 offset-s1">Start Date:</h5>
                        <div class="input-field col s4 offset-s1">
                            <select id="se-s-month">
                                <option value="0">January</option>
                                <option value="1">February</option>
                                <option value="2">March</option>
                                <option value="3">April</option>
                                <option value="4">May</option>
                                <option value="5">June</option>
                                <option value="6">July</option>
                                <option value="7">August</option>
                                <option value="8">September</option>
                                <option value="9">October</option>
                                <option value="10">November</option>
                                <option value="11">December</option>
                            </select>
                            <label>Month</label>
                        </div>
                        <div class="input-field col s2">
                            <input id="se-s-day" type="number" min="1" max="31" class="validate" data-error="Invalid" data-success="Valid" placeholder="Day">
                        </div>
                        <div class="input-field col s4">
                            <input id="se-s-year" type="number" min="1000" max="9999" class="validate" data-error="Invalid" data-success="Valid" placeholder="Year">
                        </div>
                        <h5 class="col s10 offset-s1">End Date:</h5>
                        <div class="input-field col s4 offset-s1">
                            <select id="se-e-month">
                                <option value="0">January</option>
                                <option value="1">February</option>
                                <option value="2">March</option>
                                <option value="3">April</option>
                                <option value="4">May</option>
                                <option value="5">June</option>
                                <option value="6">July</option>
                                <option value="7">August</option>
                                <option value="8">September</option>
                                <option value="9">October</option>
                                <option value="10">November</option>
                                <option value="11">December</option>
                            </select>
                            <label>Month</label>
                        </div>
                        <div class="input-field col s2">
                            <input id="se-e-day" type="number" min="1" max="31" class="validate" data-error="Invalid" data-success="Valid" placeholder="Day">
                        </div>
                        <div class="input-field col s4">
                            <input id="se-e-year" type="number" min="1000" max="9999" class="validate" data-error="Invalid" data-success="Valid" placeholder="Year">
                        </div>
                        <div class="row"></div>
                        <div class="col s10 offset-s1 center-align">
                            <div class="row">
                                <a class="submit waves-effect white grey-text text-darken-2 btn"><i class="material-icons left green-text">done</i>Submit</a>
                                <a class="cancel waves-effect white grey-text text-darken-2 btn"><i class="material-icons left red-text">clear</i>Cancel</a>
                            </div>
                            <div class="row">
                                <a class="delete waves-effect white grey-text text-darken-2 btn"><i class="material-icons left">delete_forever</i>Delete</a>
                            </div>
                        </div>
                    </div>
                    <br/><br/><br/><br/><br/><br/><br/><br/> 
                </div>
            </div>
            
        </div>
    </div>
            
    <div class="navbar">
      <nav class="transparent z-depth-0">
        <div class="nav-wrapper">
            <div class="row">
                <div class="col s12">
                    <h4 id="logo" class="grey-text text-darken-2">Plan</h4>
                </div>
            </div>
        </div>
      </nav>
    </div>

    <div class="container">
        
        <a href="#" id="settings-btn" class="grey-text text-darken-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Settings" onclick="settings()" ><i class="material-icons">settings</i></a>
        
        <nav id="search-bar">
            <div class="nav-wrapper">
              <form>
                <div class="input-field row">
                  <input id="search" class="search" type="search" placeholder="Let's start planning!" required>
                  <label for="search"><i class="material-icons dark-gt" style="color:#444">search</i></label>
                  <i class="material-icons" onclick="showSideMenu(0)" >close</i>
                </div>
              </form>
            </div>
         </nav>
        
        <a id="add-btn" class="btn-floating btn-large waves-effect waves-light user-color tooltipped" data-position="left" data-delay="50" data-tooltip="Create" onclick="create()">
            <i class="material-icons">add</i>
        </a>
    </div>

    <div class="container">
        <div class="calendar-all">
            <div class="tabbss"></div>
            <div class="calendar-head row">
                <div class="card white-text user-color waves-effect waves-light col s12">
                    <div class="card-title">
                        <div class="row">
                            <a href="#" onclick="changeMonth(0)" class="col s2 white-text center-align"><i class="large material-icons">chevron_left</i></a>
                            <h2 id="month-header" class="col s8 center-align">Month</h2>
                            <a href="#" onclick="changeMonth(1)" class="col s2 white-text center-align"><i class="large material-icons">chevron_right</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="calendar-body"></div>
        </div>
    </div>
    <footer class="page-footer transparent">
        <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 id="footer-header" class="grey-text text-darken-2">Welome to Plan.</h5>
                <p class="grey-text text-darken-2">By using this tool, we hope that you can heighten productivity and maximize your time. 
                Thank you for using our product and please do enjoy.</p><br/>
              </div>
              <div class="col l4 offset-l2 s12">
                <a href="PHP/user/logout.php" class="grey-text text-darken-2 right-align"><h5>Log out</h5></a>
                <br/>
              </div>
            </div>
          </div>
          <div class="footer-copyright grey z-depth-1">
            <div class="container">
                <a class="grey-text text-lighten-4 right" href="https://www.linkedin.com/in/calebsolorio" target='_blank'>© 2016 Caleb Solorio</a>
            </div>
        </div>
    </footer>
</body>

</html>