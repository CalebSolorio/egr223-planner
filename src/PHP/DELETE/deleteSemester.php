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
    $semID = $_POST['semID'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Get "None" Semester.
    $sql = "SELECT id FROM semesters WHERE id=" + $_SESSION["id"]  + " LIMIT 1";
    $result = mysqli_query($db, $sql);
    $semID0 = mysqli_fetch_assoc($result)['id'];
    
    // Set all courses under the semester to be moved to the "None" semester.
    $sql = "UPDATE courses SET semID=".$semID0." WHERE semID=".$semID;
    
    // Delete the semester.
    $sql = "DELETE FROM semesters where semID=".$semID;
    $result = mysqli_query($db, $sql);
    
    if (!$result) {
        echo 1; // Success. 
    } else {
        echo 0; // Failure. 
    }
?>