var month;
var year;
var username;
var lastTIme;
var lastEvent;
var lastCourse;

// Initialize elements and get data.
function initialize() {
    $('.notification-all').hide();
    $('select').material_select();
    $('.tooltipped').tooltip({delay: 50});
    $('select').material_select();
    
    getUsername();
    getColor();
    
    setCalendar(-1,-1);
    
    $(".create-tabs").hide();
    $(".event-edit").hide();
    $(".course-edit").hide();
    $(".semester-edit").hide();
    
}

// Get the username and set username elements.
function getUsername() {
    $.post("PHP/user/getUserData.php", 
    { 
        type : 0
    }).always(function(result) {
        username = result;
        $("#logo").text("Welcome, " + username + "!");
        $("#sidebar-header").text(username + "'s Plan");
        $("#footer-header").text("Welcome to Plan, " + username + ".");
    });
}

// Get the user's favorite color and set colored elements.
function getColor() {
    $.post("PHP/user/getUserData.php", 
    { 
        type : 1
    }).always(function(result) {
        $(".user-color").css("background-color", result);
        $(".user-color-text").css("color", result);
    });
}

// Set the variables for the setCalendar fucntion.
function changeMonth(n) {
    var m = month;
    var y = year;
    
    if (n == 1) {
        m++;
        if (m + 1 > 11) {
           m = 0;
           y++;
        }
    } else if(n==0) {
        m--;
        if (m - 1 < 0) {
            m = 11;
            y--;
        }
    }
    setCalendar(m, y);
}

// Change the days for the calendar and set the events to the associated day.
function setCalendar(mm, yy) {
    if (mm == -1) {
         var date = new Date();
         month = date.getMonth();
         year = date.getFullYear();
    } else {
        month = mm;
        year = yy;
    }
    var days = new Date(year, month+1, 0).getDate();
    var startDay = new Date(year, month, 1).getDay();
    var weeks = Math.ceil((days-(7-startDay)) / 7) + 1;
    
    var start = false;
    var d = 1;
    
    var months = new Array();
    months = ["January", "February","March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $("#month-header").text(months[month] + " " + year);
    
    $(".calendar-body").empty();
    
    for(var i = 0; i < weeks; i++) {
        $("<div id='cw" + i + "' class='row'>").appendTo($(".calendar-body"))
        for (var j = 0; j < 7; j++) {
            $('<div id="cw' + i + 'd' + j + '" class="calendar-day card hoverable waves-effect col s1">').appendTo($("#cw" + i));
            
            if(!start && j == startDay) {
                start = true;
            }
            if (start && d <= days) {
                $("<div id='day-num-" + d + "-header' class='row'>").appendTo($('#cw' + i + 'd' + j));
                $('<div class="col s2"><h5 id="day-num-' + d + '">').text(d).appendTo($("#day-num-" + d + "-header"));
                var time = datetimeEncode(month, d, year, 12, 0, 0, "0").substr(0,10);
                $.post("PHP/GET/getEvent.php",
                {
                    eventID : -1,
                    time : time,
                    d : d,
                    i : i,
                    j : j
                }).always(function(result) {
                    var data = JSON.parse(result);
                    if (data) {
                        $("<div id='day-num-" + data[0].d + "-events' class='row'>").insertAfter($("#day-num-" + data[0].d + "-header"));
                        $("#day-num-" + data[0].d + "-events").parent().attr("onclick", "showEvents('" + data[0].time + "')");
                        for (var k = 0; k < data.length && k < 4; k++) {
                            // add later : onclick="eventView(' + data[k].eventID + ')"
                            $('<div class="card ce-card event-' + data[k].d + '-' + k + ' col s10 offset-s1 hoverable white-text row" ><p id="event-' + data[k].d + '-' + k + '-title" class="center-align m-bottom m-top truncate">' + data[k].name + '</p>').appendTo($('#day-num-' + data[k].d + '-events'));
                            $.post("PHP/GET/getCourse.php",
                            {
                               courseID : data[k].courseID,
                               d: data[k].d,
                               k: k
                            }).always(function(course) {
                               var courseData = JSON.parse(course); 
                               $('.event-' + courseData.d + '-' + courseData.k).css("background-color", courseData.color);
                            });
                        }   
                    }
                });
                d++;
            }
        }
    }
}

// Show the events for the associated day.
function showEvents(time) {
    lastTIme = time;
    
    var months = ["January", "February","March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var month = datetimeDecode(time, 1);
    var day = datetimeDecode(time, 2);
    var year = datetimeDecode(time, 0);
    var date = months[month] + " " + day + ", " + year;
    $("#sidebar-header").text(date);
    $(".search").attr("placeholder", "Events on " + date);
    
    $("#edit-btn").hide();
    $(".back-btn").attr("onclick", "showSideMenu(0)")
    
    $.post("PHP/GET/getEvent.php",
    {
        eventID : -1,
        time : time
    }).always(function(results) {
        var data = JSON.parse(results);
        $(".sidebar-content-view").empty();
        for (var k = 0; k < data.length; k++) {
            $('<div class="card ce-card event-' + data[k].d + '-' + k + ' col s10 offset-s1 white-text row"><p id="event-' + data[k].d + '-' + k + '-title" class="center-align m-bottom m-top truncate">' + data[k].name + '</p>').appendTo($('#day-num-' + data[k].d + '-events'));
            $.post("PHP/GET/getCourse.php",
            {
               courseID : data[k].courseID,
               k: k
            }).always(function(course) {
                var courseData = JSON.parse(course);
                var hour = datetimeDecode(data[courseData.k].start, 3);
                var minute = datetimeDecode(data[courseData.k].start, 4);
                if (hour < 12) {
                    if (hour = 0)
                        hour = 12;
                    var ampm = "a";
                } else {
                    if (hour > 12) {
                        if (hour > 1)
                            hour -= 12;
                    }
                    var ampm = "p";
                }
                var time = hour + ":" + minute + ampm;
                if (datetimeDecode(data[courseData.k].end, 4).toString().length > 1) {
                    hour = datetimeDecode(data[courseData.k].end, 3);
                    minute = datetimeDecode(data[courseData.k].end, 4);
                    if (hour < 12) {
                        if (hour = 0)
                            hour = 12;
                        ampm = "a";
                    } else {
                        if (hour > 12) {
                            if (hour > 1)
                                hour -= 12;
                        }
                        ampm = "p";
                    }
                    time += " - " + hour + ":" + minute + ampm;
                }
                
                percentConvert(data[courseData.k].eventID, function(percent) {
                    $('<div class="preview-view"><div class="previews row"><div class="preview-card card hoverable col s10 offset-s1" onclick="eventView(' + data[courseData.k].eventID + ')"><div class="row" style="margin-top:10px">'
                    + '<strong><h5 class="col s7 truncate">' + data[courseData.k].name + '</h5></strong><h6 class="col s5 right-align">' + time + '</h6></div><div class="row">'
                    + '<div class="col s6"><div class="white-text card hoverable truncate" style="background-color:' + courseData.color + '" onclick="courseView(' + courseData.courseID + ')"><h6 class="center-align">' + courseData.code
                    + '</h6></div></div><h6 class="col s6 right-align">' + percent + '% Complete</h6>').appendTo($('.sidebar-content-view'));
                });
            });
        }
        showSideMenu(1);
    });
}

// Starts the createSwitch method and sets elements.
function create() {
    showSideMenu(1);
    $(".create-tabs").show();
    $("#edit-btn").hide();
    createSwitch(0);
}

// Sets the edit method and sets the search placeholder.
function createSwitch(num, id) {
    edit(num, -1);
     switch(num) {
        case 0: $(".search").attr("placeholder", "Add Event"); break;
        case 1: $(".search").attr("placeholder", "Add Course"); break;
        case 2: $(".search").attr("placeholder", "Add Semester"); break;
    }
}

// Sets the elements for editing certain data types.
function edit(num, id) {
    $(".sidebar-content-view").empty();
    $("#edit-btn").hide();
    
    switch(num) {
        case 0:
            $(".event-edit").show();
            $(".course-edit").hide();
            $(".semester-edit").hide();
            $('#ee-course').empty();
            $("#ee-milestones").empty();
            
            if (id == -1) {
                addMilestone(-1);
                $("#sidebar-header").text("Add Event");
                $(".back-btn").attr("onclick", "showSideMenu(0)")
                $(".search").attr("placeholder", "Add Event");
                $.post("PHP/GET/getCourse.php",
                {
                    courseID : -1
                }).always(function(array) {
                    var courses = JSON.parse(array);
                    for (var i = 0; i < courses.length; i++) 
                        $('<option value="' + courses[i].courseID + '">' + courses[i].name + '</option>').appendTo($("#ee-course"))
                    $('#ee-course').material_select();
                });
                $(".submit").attr("onclick", "eventSubmit(-1)");
                $(".cancel").attr("onclick", "showSideMenu(0)");
                $(".delete").attr("onclick", "showSideMenu(0)");
            } else {
                $(".back-btn").attr("onclick", "eventView(" + id + ")");
                $(".submit").attr("onclick", "eventSubmit(" + id + ")");
                $.post("PHP/GET/getEvent.php",
                {
                    eventID : id
                }).always(function(result) {
                    var data = JSON.parse(result);
                    $("#sidebar-header").text("Edit " + data.name);
                    
                    $(".search").attr("placeholder", "Edit " + data.name);
                    $.post("PHP/GET/getCourse.php",
                    {
                        courseID : -1
                    }).always(function(array) {
                        var courses = JSON.parse(array);
                        for (var i = 0; i < courses.length; i++) {
                            $('<option value="' + courses[i].courseID + '">' + courses[i].name + '</option>').appendTo($("#ee-course"));
                            
                            if (data.courseID == courses[i].courseID) {
                                $('#ee-course option[value="' + courses[i].courseID + '"]').attr("selected", "selected");
                            }
                        }
                        $('#ee-course').material_select();
                    });
                    $("#ee-name").val(data.name);
                    $("#ee-type").val(data.type);
                    $("#ee-type").material_select();
                    $('#ee-month option[value="' + datetimeDecode(data.start, 1) + '"]').attr("selected", "selected");
                    $('#ee-month').material_select();
                    $("#ee-day").val(datetimeDecode(data.start, 2));
                    $("#ee-year").val(datetimeDecode(data.start, 0));
                    
                    if (datetimeDecode(data.start, 3) == 0) {
                        $("#ee-s-hour").attr("value", "1");
                        $('#ee-s-time option[value="0"]').attr("selected", "selected");
                        $('#ee-s-time').material_select();
                    } else if (datetimeDecode(data.start, 3) > 12) {
                        $("#ee-s-hour").attr("value", datetimeDecode(data.start, 3) - 12);
                        $('#ee-s-time option[value="1"]').attr("selected", "selected");
                        $('#ee-s-time').material_select();
                    } else {
                        $("#ee-s-hour").attr("value", datetimeDecode(data.start, 3)); 
                        $('#ee-s-time option[value="0"]').attr("selected", "selected");
                        $('#ee-s-time').material_select();
                    }
                     $('#ee-s-minute').val(datetimeDecode(data.start, 4));
                     
                     if (datetimeDecode(data.end, 3) == 0) {
                        $("#ee-e-hour").attr("value", "1");
                        $('#ee-e-time option[value="0"]').attr("selected", "selected");
                        $('#ee-e-time').material_select();
                    } else if (datetimeDecode(data.end, 3) > 12) {
                        $("#ee-e-hour").attr("value", datetimeDecode(data.start, 3) - 12);
                        $('#ee-e-time option[value="1"]').attr("selected", "selected");
                        $('#ee-e-time').material_select();
                    } else {
                        $("#ee-e-hour").attr("value", datetimeDecode(data.start, 3)); 
                        $('#ee-e-time option[value="0"]').attr("selected", "selected");
                        $('#ee-e-time').material_select();
                    }
                    $('#ee-e-minute').val(datetimeDecode(data.end, 4));
                    $('#ee-description').text(data.description);
                });
                $.post("PHP/GET/getMilestones.php",
                {
                    eventID : id
                }).always(function(result) {
                    var data = JSON.parse(result);
                    for (var i = 0; i < data.length; i++)
                        addMilestone(data[i]);
                });
                $(".submit").attr("onclick", "eventSubmit(" + id + ")");
                $(".cancel").attr("onclick", "eventView(" + id + ")");
                $(".delete").attr("onclick", "eventDelete(" + id + ")");
             }
            break;
        case 1:
            $(".event-edit").hide();
            $(".course-edit").show();
            $(".semester-edit").hide();
            if (id == -1) {
                $("#sidebar-header").text("Add Course");
                $(".back-btn").attr("onclick", "showSideMenu(0)")
                $(".search").attr("placeholder", "Add Course");
                $.post("PHP/GET/getSemester.php",
                {
                    semID : -1
                }).always(function(results) {
                    var semesters = JSON.parse(results);
                    for (var i = 0; i < semesters.length; i++) {
                        $('<option value="' + semesters[i].semID + '">').text(semesters[i].name).appendTo($("#ce-semester"));
                    }
                    $('#ce-semester').material_select();
                });

                $(".submit").attr("onclick", "courseSubmit(-1)");
                $(".cancel").attr("onclick", "showSideMenu(0)");
                $(".delete").attr("onclick", "showSideMenu(0)");
            } else {
                $(".back-btn").attr("onclick", "courseView(" + id + ")");
                $.post("PHP/GET/getCourse.php",
                {
                    courseID : id
                }).always(function(result) {
                    var data = JSON.parse(result);
                    
                    $("#sidebar-header").text("Edit " + data.name);
                    $(".search").attr("placeholder", "Edit " + data.name);
                    $("#ce-name").attr("value", data.name);
                    $("#ce-name").addClass("active");
                    $("#ce-code").attr("value", data.code);
                    $("#ce-code").addClass("active");
                    for (var i = 0; i < data.days.length; i++) {
                        switch (data.days[i]) {
                            case "0": 
                               $('#ce-days option[value="0"]').attr("selected", "selected");
                               break;
                            case "1": 
                               $('#ce-days option[value="1"]').attr("selected", "selected");
                               break;
                            case "2": 
                               $('#ce-days option[value="2"]').attr("selected", "selected");
                               break;
                            case "3": 
                               $('#ce-days option[value="3"]').attr("selected", "selected");
                               break;
                            case "4": 
                               $('#ce-days option[value="4"]').attr("selected", "selected");
                               break;
                            case "5": 
                               $('#ce-days option[value="5"]').attr("selected", "selected");
                               break;
                            case "6": 
                               $('#ce-days option[value="6"]').attr("selected", "selected");
                               break;
                        }
                    }
                    $('#ce-days').material_select();
                    $('#ce-semester').empty();
                    $.post("PHP/GET/getSemester.php",
                    {
                        semID : -1
                    }).always(function(array) {
                        var semesters = JSON.parse(array);
                        for (var i = 0; i < semesters.length; i++) {
                            $('<option value="' + semesters[i].semID + '">' + semesters[i].name + '</option>').appendTo($("#ce-semester"))
                            
                            if (data.semID == semesters[i].semID) {
                                $('#ce-days option[value="' + semesters[i].semID + '"]').attr("selected", "selected");
                            }
                            $('#ce-semester').material_select();
                        }
                        $('#ce-semester').material_select();
                    });
                    
                    if (datetimeDecode(data.start, 3) == 0) {
                        $("#ce-s-hour").attr("value", "1");
                        $('#ce-s-time option[value="0"]').attr("selected", "selected");
                        $('#ce-s-time').material_select();
                    } else if (datetimeDecode(data.start, 3) > 12) {
                        $("#ce-s-hour").attr("value", datetimeDecode(data.start, 3) - 12);
                        $('#ce-s-time option[value="1"]').attr("selected", "selected");
                        $('#ce-s-time').material_select();
                    } else {
                        $("#ce-s-hour").attr("value", datetimeDecode(data.start, 3)); 
                        $('#ce-s-time option[value="0"]').attr("selected", "selected");
                        $('#ce-s-time').material_select();
                    }
                    
                    $("#ce-s-minute").attr("value", datetimeDecode(data.start, 4));
                    $("#ce-s-minute").addClass("active");
                    
                    if (datetimeDecode(data.end, 3) == 0) {
                        $("#ce-e-hour").attr("value", "1");
                        $('#ce-e-time option[value="0"]').attr("selected", "selected");
                    } else if (datetimeDecode(data.end, 3) > 12) {
                        $("#ce-e-hour").attr("value", datetimeDecode(data.end, 3) - 12);
                        $('#ce-e-time option[value="1"]').attr("selected", "selected");
                    } else {
                        $("#ce-e-hour").attr("value", datetimeDecode(data.start, 3)); 
                        $('#ce-e-time option[value="0"]').attr("selected", "selected");
                    }
                    
                    $("#ce-e-minute").attr("value", datetimeDecode(data.end, 4));
                    $("#ce-name").addClass("active");
                    
                    $("#ce-description").text(data.description);
                    $(".color-picked").css("background-color", data.color);
                });
                $(".submit").attr("onclick", "courseSubmit(" + id + ")");
                $(".cancel").attr("onclick", "courseView(" + id + ")");
                $(".delete").attr("onclick", "courseDelete(" + id + ")");
            }
            break;
        case 2:
            $(".event-edit").hide();
            $(".course-edit").hide();
            $(".semester-edit").show();
            if (id == -1) {
                $("#sidebar-header").text("Add Semester");
                $(".back-btn").attr("onclick", "showSideMenu(0)")
                $(".search").attr("placeholder", "Add Semester");
                $(".submit").attr("onclick", "semesterSubmit(-1)");
                $(".cancel").attr("onclick", "showSideMenu(0)");
                $(".delete").attr("onclick", "showSideMenu(0)");
            } else {
                $(".back-btn").attr("onclick", "semesterView(" + id + ")");
                $.post("PHP/GET/getSemester.php",
                {
                    semID : id
                }).always(function(result) {
                    var data = JSON.parse(result);
                    $("#sidebar-header").text("Edit " + data.name);
                    $(".search").attr("placeholder", "Edit " + data.name);
                    
                    $("#se-name").attr("value", data.name);
                    $("#se-s-month").val(datetimeDecode(data.start, 1));
                    $("#se-s-day").attr("value", datetimeDecode(data.start, 2));
                    $("#se-s-year").attr("value", datetimeDecode(data.start, 0));
                    $("#se-e-month").val(datetimeDecode(data.end, 1));
                    $("#se-e-day").attr("value", datetimeDecode(data.end, 2));
                    $("#se-e-year").attr("value", datetimeDecode(data.end, 0));
                });
                $(".submit").attr("onclick", "semesterSubmit(" + id + ")");
                $(".cancel").attr("onclick", "semesterView(" + id + ")");
                $(".delete").attr("onclick", "semesterDelete(" + id + ")");
            }
            break;
    }
}

// Shows or hides the side menu.
function showSideMenu(num) {
    if (num == 0) {
        $('.notification-all').hide(200);
        $(".create-tabs").hide();
        $(".event-edit").hide();
        $(".course-edit").hide();
        $(".semester-edit").hide();
        $(".search").val("");
        $(".search").attr("placeholder", "Let's Get Planning!");
    } else {
        $('.notification-all').show(200);
    }
}

// Shows info for an event.
function eventView(eventID) {
    lastEvent = eventID;
    $(".back-btn").attr("onclick", "showEvents('" + lastTIme + "')");
    
    $(".create-tabs").hide();
    $(".event-edit").hide();
    $(".course-edit").hide();
    $(".semester-edit").hide();
    $(".sidebar-content-view").empty();
    
    $.post("PHP/GET/getEvent.php",
    {
        eventID : eventID
    }).always(function(results) {
       var data = JSON.parse(results);
       console.log(data);
       $(".sidebar-content-view").load("view/event-view.html", function() {
           $("#sidebar-header").text(data.name);
           $(".search").attr("placeholder", data.name);
           $("#ev-name").text(data.name);
           $.post("PHP/GET/getCourse.php",
           {
               courseID : data.courseID
           }).always(function(course) {
               var courseData = JSON.parse(course); 
               $("#ev-course").css("background-color", courseData.color);
               $("#ev-course").attr("onclick", "courseView(" + courseData.courseID + ")");
               $("#ev-course-name").text(courseData.code);
           });
           switch (parseInt(data.type)) {
               case 0:
                    $("#ev-type").text("Homework");
                    break;
                case 1:
                    $("#ev-type").text("Project");
                    break;
                case 2:
                    $("#ev-type").text("Quiz");
                    break;
                case 3:
                    $("#ev-type").text("Test");
                    break;
                case 4:
                    $("#ev-type").text("Extra Credit");
                    break;
                case 5:
                    $("#ev-type").text("Meeting");
                    break;
                case 6:
                    $("#ev-type").text("Event");
                    break;
            }
            
            var months = ["January", "February","March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var month = datetimeDecode(data.start, 1);
            var year = datetimeDecode(data.start, 0);
            var day = datetimeDecode(data.start, 2);
            var hour = datetimeDecode(data.start, 3);
            var minute = datetimeDecode(data.start, 4);
            if (hour < 12) {
                if (hour = 0)
                    hour = 12;
                var ampm = "a";
            } else {
                if (hour > 12) {
                    if (hour > 1)
                        hour -= 12;
                }
                var ampm = "p";
            }
            var time = months[month] + " " + day + ", " + year + " (" + hour + ":" + minute + ampm;
            if (datetimeDecode(data.end, 0) > 0) {
                console.log(data.end);
                hour = datetimeDecode(data.end, 3);
                minute = datetimeDecode(data.end, 4);
                if (hour < 12) {
                    if (hour = 0)
                        hour = 12;
                    ampm = "a";
                } else {
                    if (hour > 12) {
                        if (hour > 1)
                            hour -= 12;
                    }
                    ampm = "p";
                }
                time += " - " + hour + ":" + minute + ampm + ")";
            } else {
                time += ")";
            }
            $("#ev-time").text(time);
            
            if(data.description) {
                $("#ev-description-card").show();
                $("#ev-description").text(data.description);
            } else {
                $("#ev-description-card").hide();
            }
            
            $.post("PHP/GET/getMilestones.php", 
            {
                eventID : eventID
            }).always(function(milestones) {
                var milestoneData = JSON.parse(milestones);
                for(var i = 0; i < milestoneData.length; i++) {
                    $('<li id="ev-m-' + i + '" class="ev-milestone collection-item"><div class="collection-row row"><div class="col s9">'
                        + '<h6><strong class="m-title">' + milestoneData[i].name +'</strong></h6><h6 class="m-hours">' 
                        + milestoneData[i].hours +' hours</h6></div>').appendTo($("#ev-milestones"));
                    if (milestoneData[i].complete == 1) {
                        $('<div class="col s3"><a href="#!" class="m-complete secondary-content">'
                        + '<i class="material-icons green-text">done</i></a></div></div></li>').appendTo($("#ev-m-" + i + " .collection-row"));
                    } else {
                        $('<div class="col s3"><a href="#!" class="m-complete secondary-content">'
                        + '<i class="material-icons red-text">clear</i></a></div></div></li>').appendTo($("#ev-m-" + i + " .collection-row"));
                    }
                }
            });
       });
    });
    $("#edit-btn").show();
    $("#edit-btn").attr("onclick", "edit(0, " + eventID + ")");
}

// Shows info for a course.
function courseView(courseID) {
    lastCourse = courseID;
    $(".back-btn").attr("onclick", "eventView(" + lastEvent + ")");
    
    $(".create-tabs").hide();
    $(".event-edit").hide();
    $(".course-edit").hide();
    $(".semester-edit").hide();
    $(".sidebar-content-view").empty();
     
    $.post("PHP/GET/getCourse.php",
    {
        courseID : courseID
    }).always(function(results) {
        var data = JSON.parse(results);
        
        $(".sidebar-content-view").load("view/course-view.html", function() {
            $("#sidebar-header").text(data.name);
            $(".search").attr("placeholder", data.name);
            $("#cv-name").text(data.name);
            $.post("PHP/GET/getSemester.php",
            {
                semID : data.semID
            }).always(function(semester) {
                $("#cv-semester").text(JSON.parse(semester).name);
                $("#cv-semester").attr("onclick", "semesterView(" + data.semID + ")");
            });
            $(".cv-course-card").css("background-color", data.color);
            $(".cv-course").text(data.code);
            
            var days = "";
            for (var i = 0; i < data.days.length; i++) {
                switch (data.days[i]) {
                    case "0":
                        days += "S";
                        break;
                    case "1":
                        days += "M";
                        break;
                    case "2":
                        days += "T";
                        break;
                    case "3":
                        days += "W";
                        break;
                    case "4":
                        days += "R";
                        break;
                    case "5":
                        days += "F";
                        break;
                    case "6":
                        days += "S";
                        break;
                }
            }
            var hour = datetimeDecode(data.start, 3);
            var minute = datetimeDecode(data.start, 4);
            if (hour < 12) {
                if (hour = 0)
                    hour = 12;
                days += " " + hour + ":" + minute + "a - ";
            } else {
                if (hour > 12) {
                    if (hour > 1)
                        hour -= 12;
                }
                days += " " + hour + ":" + minute + "p - ";
            }
            hour = datetimeDecode(data.end, 3);
            minute = datetimeDecode(data.end, 4);
            if (hour < 12) {
                if (hour = 0)
                    hour = 12;
                days += " " + hour + ":" + minute + "a";
            } else {
                if (hour > 12) {
                    if (hour > 1)
                        hour -= 12;
                }
                days += " " + hour + ":" + minute + "p";
            }
            
            $(".cv-days").text(days);
            
            if(data.description) {
                $("#cv-description-card").show();
                $("#cv-description").text(data.description);
            } else {
                $("#cv-description-card").hide();
            }
        });
    });
    $.post("PHP/GET/getCourse.php", 
    {
        courseID: -2        
    }).always(function(response) {
        var data = JSON.parse(response);
        if (data.courseID != courseID) {
            $("#edit-btn").show();
            $("#edit-btn").attr("onclick", "edit(1, " + courseID + ")");
        } else {
            $("#edit-btn").hide();
        }
    });
}

// Shows info for a semester.
function semesterView(semID) {
    $(".back-btn").attr("onclick", "courseView(" + lastCourse + ")");
    
    $(".create-tabs").hide();
    $(".event-edit").hide();
    $(".course-edit").hide();
    $(".semester-edit").hide();
    $(".sidebar-content-view").empty();
    
    $.post("PHP/GET/getSemester.php",
    {
        semID : semID
    }).always(function(result) {
        var data = JSON.parse(result);
        
        $("#sidebar-header").text(data.name);
        $(".search").attr("placeholder", data.name);
        
        $(".sidebar-content-view").load("view/semester-view.html", function () {
            var months = ["January", "February","March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            
            var sy = datetimeDecode(data.start, 0);
            var sm = months[datetimeDecode(data.start, 1)];
            var sd = datetimeDecode(data.start, 2);
            
            var ey = datetimeDecode(data.end, 0);
            var em = months[datetimeDecode(data.end, 1)];
            var ed = datetimeDecode(data.end, 2);
            
            $("#sv-name").text(data.name);
            $("#sv-dates").text(sm + " " + sd + ", " + sy + " - " + em + " " + ed + ", " + ey);
        });
    });
    $.post("PHP/GET/getCourse.php", 
    {
        courseID: -2        
    }).always(function(response) {
        var data = JSON.parse(response);
        console.log(data);
        if (data.semID != semID) {
            $("#edit-btn").show();
            $("#edit-btn").attr("onclick", "edit(1, " + semID + ")");
        } else {
            $("#edit-btn").hide();
        }
    });
}

// Send a course to either its post or put php method.
function eventSubmit(eventID) {
    var pass = true;
    if ($("#ee-name").val().length > 0 && $("#ee-type").val().length > 0 && $("#ee-course").val().length > 0 
        && $("#ee-month").val().length > 0 && $("#ee-day").val() > 0 && $("#ee-day").val() <= 31 
        && $("#ee-year").val() > 1000 && $("#ee-year").val() <= 9999
        && $("#ee-s-minute").val() >= 0 && $("#ee-s-minute").val() < 60 
        && $("#ee-s-time").val().length > 0 && $(".ee-milestone").length > 0) {
            if ($("#ee-e-minute").val()) {
                if (!($("#ee-e-minute").val() >= 0 && $("#ee-e-minute").val() < 60)) {
                    pass = false;
                    console.log("Fail 1");
                }
            }
            $(".ee-milestone").each(function() {
                if (!($(this).find(".m-title").val().length > 0 || $(this).find(".m-hrs").val().length > 0)) {
                    pass= false;
                }
            });
    } else {
        pass = false;
    }
    if (pass) {
        if (eventID == -1) {
            if($("#ee-e-hour").val() == 13) {
                var year = "0000";
                var hour = 12;
            } else {
                var year = $("#ee-year").val();
                var hour = $("#ee-e-hour").val();
            }
            $.post("PHP/POST/postEvent.php", 
            { 
                courseID : $("#ee-course").val(),
                eventID : eventID,
                name : $("#ee-name").val(),
                type : $("#ee-type").val(),
                description : $("#ee-description").val(),
                start : datetimeEncode($("#ee-month").val(), $("#ee-day").val(), $("#ee-year").val(), $("#ee-s-hour").val(), $("#ee-s-minute").val(), "00", $("#ee-s-time").val()),
                end : datetimeEncode($("#ee-month").val(), $("#ee-day").val(), year, hour, $("#ee-e-minute").val(), "00", $("#ee-e-time").val())
            }).always(function(result) {
                if (result == 0) {
                    Materialize.toast('Oh no! An error occured. Try removing all apostrophes, if you have any.', 3000);
                } else {
                    Materialize.toast('Event Added!', 3000);
                    $("#ee-course").empty();
                    $("#ee-name").attr("value", "");
                    $("#ee-type").val("0");
                    $("#ee-description").attr("value", "");
                    $("#ee-month").val("0");
                    $("#ee-day").attr("value", "");
                    $("#ee-year").attr("value", "");
                    $("#ee-start-hour").val("0");
                    $("#ee-start-minute").attr("value", "");
                    $("#ee-start-time").val("0");
                    $("#ee-end-hour").val("0");
                    $("#ee-end-minute").attr("value", "");
                    $("#ee-end-time").val("0"); 
                    
                    var milestones = {
                        name : new Array(),
                        hours : new Array(),
                        complete : new Array()
                    };
                    
                    $(".ee-milestone .m-title").each(function() {
                        milestones.name.push($(this).val());
                    });
                    $(".ee-milestone .m-hrs").each(function() {
                        milestones.hours.push($(this).val());
                    });
                    $(".ee-milestone input:checkbox").each(function() {
                        if ($(this).is(":checked") == true) {
                            milestones.complete.push(1);
                        } else {
                            milestones.complete.push(0);    
                        }
                    });
                    
                    $.post("PHP/POST/postMilestones.php", 
                    {
                        eventID : result,
                        data : JSON.stringify(milestones)
                    }).always(function (response) {
                        eventView(result);
                        initialize();
                    });
                }
            });
        } else {
            if($("#ee-e-hour").val() == 13) {
                var year = "0000";
                var hour = 12;
            } else {
                var year = $("#ee-year").val();
                var hour = $("#ee-e-hour").val();
            }
            $.post("PHP/PUT/putEvent.php", 
            { 
                courseID : $("#ee-course").val(),
                eventID : eventID,
                name : $("#ee-name").val(),
                type : $("#ee-type").val(),
                description : $("#ee-description").val(),
                start : datetimeEncode($("#ee-month").val(), $("#ee-day").val(), $("#ee-year").val(), $("#ee-s-hour").val(), $("#ee-s-minute").val(), "00", $("#ee-s-time").val()),
                end : datetimeEncode($("#ee-month").val(), $("#ee-day").val(), year, hour, $("#ee-e-minute").val(), "00", $("#ee-e-time").val())
            }).always(function(result) {
                if (result == 0) {
                    Materialize.toast('Oh no! An error occured. Try removing all apostrophes, if you have any.', 3000);
                } else {
                    Materialize.toast('Event Modified!', 3000);
                    $("#ee-course").empty();
                    $("#ee-name").attr("value", "");
                    $("#ee-type").val("0");
                    $("#ee-description").attr("value", "");
                    $("#ee-month").val("0");
                    $("#ee-day").attr("value", "");
                    $("#ee-year").attr("value", "");
                    $("#ee-start-hour").val("0");
                    $("#ee-start-minute").attr("value", "");
                    $("#ee-start-time").val("0");
                    $("#ee-end-hour").val("0");
                    $("#ee-end-minute").attr("value", "");
                    $("#ee-end-time").val("0"); 
                    
                   var milestones = {
                        name : new Array(),
                        hours : new Array(),
                        complete : new Array()
                    };
                    
                    $(".ee-milestone .m-title").each(function() {
                        milestones.name.push($(this).val());
                    });
                    $(".ee-milestone .m-hrs").each(function() {
                        milestones.hours.push($(this).val());
                    });
                    $(".ee-milestone input:checkbox").each(function() {
                        if ($(this).is(":checked") == true) {
                            milestones.complete.push(1);
                        } else {
                            milestones.complete.push(0);    
                        }
                    });
                    
                    $.post("PHP/POST/postMilestones.php", 
                    {
                        eventID : result,
                        data : JSON.stringify(milestones)
                    }).always(function (response) {
                        initialize();
                        eventView(eventID);
                    });
                }
            });
        }
    } else {
            Materialize.toast('Whoops! Remember to fill in every field correctly!', 3000);
    }
}

// Send an event to either its post or put php method.
function courseSubmit(courseID) {
    if ($("#ce-name").val().length > 0 && $("#ce-code").val().length > 0 && $("#ce-semester").val() != "" && $("#ce-days").val() != "" 
        && $("#ce-s-hour").val() != "" && $("#ce-s-minute").val() >= 0  && $("#ce-s-minute").val() < 60 && $("#ce-s-time").val() != ""
        && $("#ce-e-hour").val() != "" && $("#ce-e-minute").val() >= 0  && $("#ce-e-minute").val() < 60 && $("#ce-e-time").val() != "") {
            var pass = true;
    } else {
        var pass = false;
    }
    
    if (pass) {
        var days = "";
        for (var i = 0; i < $("#ce-days").val().length; i++)
                days += $("#ce-days").val()[i].toString();
        if (courseID == -1) {
            $.post("PHP/POST/postCourse.php", 
            { 
                semID : $("#ce-semester").val(),
                name : $("#ce-name").val(),
                code : $("#ce-code").val(),
                description : $("#ce-description").val(),
                days : days,
                start : datetimeEncode("00", "00", "0000", $("#ce-s-hour").val(), $("#ce-s-minute").val(), "00", $("#ce-s-time").val()),
                end : datetimeEncode("00", "00", "0000", $("#ce-e-hour").val(), $("#ce-e-minute").val(), "00", $("#ce-e-time").val()),
                color : hexc($(".color-picked").css("background-color"))
            }).always(function(result) {
                if (result == 0) {
                   Materialize.toast('Oh no! An error occured. Try removing all apostrophes, if you have any.', 3000);
                } else {
                    Materialize.toast('Course Added!', 3000);
                    courseView(result);
                    $("#ee-course").empty();
                    $("#ee-name").attr("value", "");
                    $("#ee-type").val("0");
                    $("#ee-description").attr("value", "");
                    $("#ee-month").val("0");
                    $("#ee-day").attr("value", "");
                    $("#ee-year").attr("value", "");
                    $("#ee-start-hour").val("0");
                    $("#ee-start-minute").attr("value", "");
                    $("#ee-start-time").val("0");
                    $("#ee-end-hour").val("0");
                    $("#ee-end-minute").attr("value", "");
                    $("#ee-end-time").val("0"); 
                }
            });
        } else {
            $.post("PHP/PUT/putCourse.php", 
            { 
                semID : $("#ce-semester").val(),
                courseID: courseID,
                name : $("#ce-name").val(),
                code : $("#ce-code").val(),
                description : $("#ce-description").val(),
                days : days,
                start : datetimeEncode("00", "00", "0000", $("#ce-s-hour").val(), $("#ce-s-minute").val(), "00", $("#ce-s-time").val()),
                end : datetimeEncode("00", "00", "0000", $("#ce-e-hour").val(), $("#ce-e-minute").val(), "00", $("#ce-e-time").val()),
                color : hexc($(".color-picked").css("background-color"))
            }).always(function(result) {
                console.log(result);
                if (result == 0) {
                    Materialize.toast('Oh no! An error occured. Try removing all apostrophes, if you have any.', 3000);
                } else {
                    Materialize.toast('Course Added!', 3000);
                    courseView(courseID);
                    $("#ce-name").attr("value", "");
                    $("#ce-code").attr("value", "");
                    $("#ce-semester").val("");
                    $("#ce-days").val("");
                    $("#ce-s-hour").val("");
                    $("#ce-s-minute").attr("value", "");
                    $("#ce-s-time").val("");
                    $("#ce-e-hour").val("");
                    $("#ce-e-minute").attr("value", "");
                    $("#ce-e-time").val("");
                    $("#ce-description").attr("value", "");
                }
            });
        }
    } else {
        Materialize.toast('Whoops! Remember to fill in every required field!', 3000);
    }
}

// Send a semester to either its post or put php method.
function semesterSubmit(semID) {
    if ($("#se-name").val().length > 0 && $("#se-s-month").val().length > 0 && $("#se-s-day").val().length > 0 && $("#se-s-day").val() <= 31 
        && $("#se-s-day").val() > 0 && $("#se-s-year").val() <= 9999 && $("#se-s-year").val() >= 1000  && $("#se-e-month").val().length > 0 
        && $("#se-e-day").val() <= 31 && $("#se-e-day").val() > 0 && $("#se-e-year").val() >= 1000 && $("#se-e-year").val() <= 9999) {
            var pass = true;
    } else {
        var pass = false;
    }
    
    if (pass) {
        var name = $("#se-name").val();
        var start = datetimeEncode($("#se-s-month").val(), $("#se-s-day").val(), $("#se-s-year").val(), 12, 00, 0);
        var end = datetimeEncode($("#se-e-month").val(), $("#se-e-day").val(), $("#se-e-year").val(), 11, 59, 1);
        if (semID == -1) {
            $.post("PHP/POST/postSemester.php", 
            { 
                name : name,
                start : start,
                end : end
            }).always(function(result) {
                console.log(result);
                if (result == 0) {
                    Materialize.toast('Oh no! An error occured. Try removing all apostrophes, if you have any.', 3000);
                } else {
                    Materialize.toast('Semester Added!', 3000);
                    semesterView(result);
                    $("#se-name").attr("value", "");
                    $("#se-s-month").val("0");
                    $("#se-s-day").attr("value", "");
                    $("#se-s-year").attr("value", "");
                }
            });
        } else {
            $.post("PHP/PUT/putSemester.php", 
            {
                semID : semID,
                name : name,
                start : start,
                end : end
            }).always(function(result) {
                if (result == 0) {
                    Materialize.toast('Oh no! An error occured. Try removing all apostrophes, if you have any.', 3000);
                } else {
                    Materialize.toast('Semester Modified!', 3000);
                    semesterView(semID);
                    $("#se-name").attr("value", "");
                    $("#se-s-month").val("0");
                    $("#se-s-day").attr("value", "");
                    $("#se-s-year").attr("value", "");
                }
            });
        }
    } else {
        Materialize.toast('Whoops! Remember to fill in every required field!', 3000);
    }
}

// Signal the delete php method to delete an event.
function eventDelete(eventID) {
    $.post("PHP/DELETE/deleteEvent.php", 
    {
        eventID : eventID
    }).always(function(result) {
        if (result == 1) {
            Materialize.toast('Event Deleted', 3000);
            $.post("PHP/DELETE/deleteMilestones.php",
            {
               eventID : eventID 
            });
            initialize();
            showSideMenu(0);
        } else {
            Materialize.toast('Uh oh! An error occured :(', 3000);
        }
    });
}

// Signal the delete php method to delete an courses.
function courseDelete(courseID) {
    $.post("PHP/DELETE/deleteCourse.php", 
    {
        semID : courseID
    }).always(function(result) {
        if (result == 1) {
            Materialize.toast('Course Deleted', 3000);
            initialize();
            showSideMenu(0);
        } else {
            Materialize.toast('Uh oh! An error occured :(', 3000);
        }
    });
}

// Signal the delete php method to delete an semester.
function semesterDelete(semID) {
    $.post("PHP/DELETE/deleteSemester.php", 
    {
        semID : semID
    }).always(function(result) {
        if (result == 1) {
            Materialize.toast('Semester Deleted', 3000);
            initialize();
            showSideMenu(0);
        } else {
            Materialize.toast('Uh oh! An error occured :(', 3000);
        }
    });
}

// Set the elements for the user to edit their personal details.
function settings() {
    showSideMenu(0);
    showSideMenu(1);
    $("#sidebar-header").text(username + "'s settings");
    $(".sidebar-content-view").empty();
    $("#edit-btn").hide();
    $(".sidebar-content-view").load("edit/user-edit.html", function() {
        $("#username-edit").val(username);
        $.post("PHP/user/getUserData.php", 
        { 
            type : 1
        }).always(function(result) {
            $(".color-picked").css("background-color", result);
        });
    });
}

// Send user data over to the user put method to update the user's details.
function settingsPost() {
    console.log(hexc($(".color-picked").css("background-color")));
    showSideMenu(0);
    $.post("PHP/PUT/putUserData.php",
    {
        username : $("#username-edit").val(),
        color : hexc($(".color-picked").css("background-color"))
    }).always(function(response) {
        console.log(response);
        if(response == 0)
            Materialize.toast('Whoops! Something went wrong :(', 3000);
        else {
            Materialize.toast('User details changed!', 3000);
            initialize();    
        }
    });
}

// Add the elements for another milestone.
function addMilestone(data) {
    var i = 0;
    while ($("#m-" + i).length > 0)
        i++;
    $('<li id="m-' + i + '" class="ee-milestone collection-item"><div class="collection-row row">').appendTo($("#ee-milestones"));
    $('<div class="input-field col s12"><input id="m-title-' + i + '" type="text" class="m-title validate"><label for="m-title-' + i + '" data-error="wrong" data-success="right">Title</label>').appendTo($("#m-" + i + " .collection-row"));
    $('<div class="row"><div class="m-top input-field col s3"><input id="m-hrs-' + i + '" type="number" min="0" step=".25" class="m-hrs validate"></div>'
        + '<h6 class="col s3">hrs. required</h6> <input type="checkbox" id="m-complete-' + i + '" /><label for="m-complete-' + i + '">Completed</label>').appendTo($("#m-" + i + " .collection-row"));
    $('<div class="row"><a href="#" onclick="deleteMilestone(' + i + ')" class="col s6">Delete Milestone</a><a href="#" onclick="addMilestone(-1)" class="col s6 right-align">Add Milestone</a>').appendTo($("#m-" + i + " .collection-row"));
    
    if(data != -1) {
        $("#m-title-" + i).val(data.name);
        $("#m-hrs-" + i).val(data.hours);
        $("#m-complete-" + i).prop("checked", parseInt(data.complete));
    }
}

// Remove the elements for a milestone.
function deleteMilestone(num) {
    if ($(".ee-milestone").length > 1)
        $("#m-" +  num).remove();
    else
        Materialize.toast('Oops! You have to have at least one milestone!', 3000);    
}

// Change an element's background to a color that the user has specified.
function changeColor(color) {
    $(".color-picked").attr("style", "background-color:" + color);
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

// Outputs a percentage of completion for an event.
function percentConvert(eventID, callback) {
    var percent = 0;
    $.post("PHP/GET/getMilestones.php",
    {
        eventID: eventID
    }).always(function(results) {
        var data = JSON.parse(results);
        var completedHours = 0;
        var totalHours = 0;
        for(var i = 0; i < data.length; i++) {
            totalHours += parseFloat(data[i].hours);
            if (parseInt(data[i].complete) == 1)
                completedHours += parseFloat(data[i].hours);
        }
        percent = parseInt((completedHours/totalHours) * 100);
        callback(percent);
    });
}

// Converts data into a string that matches SQL DATETIME format.
function datetimeEncode(month, day, year, hour, minute, time) {
    // Proper format: YYYY-MM-DD HH:MM:SS
    if (month.toString().length < 2)
        month = "0" + month.toString();
    else
        month = month.toString();
    if (day.toString().length < 2)
        day = "0" + day.toString();
    else
        day = day.toString();
    if (minute.toString().length < 2) 
        minute = "0" + minute.toString();
    else
        minute = minute.toString();
        
    if (time == "0") {
        if (hour == 12 || hour == "12")
            hour = "00"
        else if (hour.toString().length < 2)
            hour = "0" + hour.toString();
        else
            hour = hour.toString();
        time = (hour + ":" + minute + ":00").toString();
    } else {
        if (hour == "12")
            time = ("12:" + minute + ":00").toString();
        else
            time = ((parseInt(hour) + 12) + ":" + minute + ":00").toString();
    }
    
    var datetime = year + "-" + month + "-" + day + " " + time;
    return datetime;
}

// Converts an SQL DATETIME variable into single variables.
function datetimeDecode(string, type) {
    switch (type) {
        case 0:
            return parseInt(string.substr(0,4));
            break;
        case 1:
            return parseInt(string.substr(5,2));
            break;
        case 2:
            return parseInt(string.substr(8,2));
            break;
        case 3:
            return parseInt(string.substr(11,2));
            break;
        case 4:
            return parseInt(string.substr(14,2));
            break;
        case 5:
            return parseInt(string.substr(17,2));
            break;
    }
    
}

// Manages searching functionality
function search(entry) {
    $("#sidebar-header").text(username + "'s Plan");
    $("#edit-btn").hide();
    
    if (entry == "") {
        showSideMenu(0);
    }
    else {
        $(".search").text(entry);
        $(".search").attr("placeholder", entry);
        showSideMenu(1);
        $.post("PHP/GET/getEvent.php",
        {
            search : entry
        }).always(function(results) {
            var data = JSON.parse(results);
            if (!data) {
                $('<div class="row"><h5 class="col s10 offset-s1 center-align grey-text text-darken-2">No results.</h5</div>').appendTo($('.sidebar-content-view'));
            } else {
                $(".sidebar-content-view").empty();
                for (var k = 0; k < data.length; k++) {
                    $('<div class="card ce-card event-' + data[k].d + '-' + k + ' col s10 offset-s1 white-text row"><p id="event-' + data[k].d + '-' + k + '-title" class="center-align m-bottom m-top truncate">' + data[k].name + '</p>').appendTo($('#day-num-' + data[k].d + '-events'));
                    $.post("PHP/GET/getCourse.php",
                    {
                       courseID : data[k].courseID,
                       k: k
                    }).always(function(course) {
                        var courseData = JSON.parse(course);
                        var hour = datetimeDecode(data[courseData.k].start, 3);
                        var minute = datetimeDecode(data[courseData.k].start, 4);
                        if (hour < 12) {
                            if (hour = 0)
                                hour = 12;
                            var ampm = "a";
                        } else {
                            if (hour > 12) {
                                if (hour > 1)
                                    hour -= 12;
                            }
                            var ampm = "p";
                        }
                        var time = hour + ":" + minute + ampm;
                        if (datetimeDecode(data[courseData.k].end, 4).toString().length > 1) {
                            hour = datetimeDecode(data[courseData.k].end, 3);
                            minute = datetimeDecode(data[courseData.k].end, 4);
                            if (hour < 12) {
                                if (hour = 0)
                                    hour = 12;
                                ampm = "a";
                            } else {
                                if (hour > 12) {
                                    if (hour > 1)
                                        hour -= 12;
                                }
                                ampm = "p";
                            }
                            time += " - " + hour + ":" + minute + ampm;
                        }
                        
                        percentConvert(data[courseData.k].eventID, function(percent) {
                            $('<div class="preview-view"><div class="previews row"><div class="preview-card card hoverable col s10 offset-s1" onclick="eventView(' + data[courseData.k].eventID + ')"><div class="row" style="margin-top:10px">'
                            + '<strong><h5 class="col s7 truncate">' + data[courseData.k].name + '</h5></strong><h6 class="col s5 right-align">' + time + '</h6></div><div class="row">'
                            + '<div class="col s6"><div class="white-text card hoverable truncate" style="background-color:' + courseData.color + '" onclick="courseView(' + courseData.courseID + ')"><h6 class="center-align">' + courseData.code
                            + '</h6></div></div><h6 class="col s6 right-align">' + percent + '% Complete</h6>').appendTo($('.sidebar-content-view'));
                        });
                    });
                }
            }
        });
    };
}

$(document).ready(function() {
    initialize();
    $(".button-collapse").sideNav();
    $('.search').keyup(function() {
        if (event.keyCode < 37 || event.keyCode > 40) {
            search($(this).val().toLowerCase());
        }
     });
});