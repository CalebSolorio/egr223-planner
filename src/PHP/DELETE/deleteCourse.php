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
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Get "None" Semester so we can...
    $sql = "SELECT id FROM semesters WHERE id=" + $_SESSION["id"]  + " LIMIT 1";
    $result = mysqli_query($db, $sql);
    $semID0 = mysqli_fetch_assoc($result)['id'];
    
    // Get "None" Course.
    $sql = "SELECT courseID FROM courses WHERE semID=" + $semID0  + " LIMIT 1";
    $result = mysqli_query($db, $sql);
    $courseID0 = mysqli_fetch_assoc($result)['id'];
    
    // Set all events under the semester to be moved to the "None" course.
    $sql = "UPDATE courses SET courseID=".$courseID0." WHERE courseID=".$courseID;
    
    // Remove the course from the database.
    $sql = "DELETE FROM courses where courseID=".$courseID;
    $result = mysqli_query($db, $sql);
    
    if (!$result) {
        echo 0; // Failure. 
    } else {
        echo 1; // Success. 
    }
?>