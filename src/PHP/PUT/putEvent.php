<?php
    session_start();
    
    // Checks to see if the user is logged in. If not, redirect to the login page.
    if (!(isset($_SESSION['id']) && $_SESSION['id'] != '')) {
      header ("Location: login.php");
    }

    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "plan";
    $dbport = 3306; 
    
    // Get posted data.
    $courseID = $_POST['courseID'];
    $eventID = $_POST['eventID'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Update the event.
    $sql = "UPDATE events SET courseID=".$courseID.", name='".addslashes($name)."', type=".$type.", description='".addslashes($description)."', start='".$start."', end='".$end."' WHERE eventID=".$eventID;
    $result = mysqli_query($db, $sql);
    
    if (!$result) {
        echo 0; // Failure. 
    } else {
        echo 1; // Success. 
    }
?>