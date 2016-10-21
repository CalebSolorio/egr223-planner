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
    $name = $_POST['name'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Update the semester's info.
    $sql = "UPDATE semesters SET name='".addslashes($name)."', start='".$start."', end='".$end."' WHERE semID=".$semID;
    $result = mysqli_query($db, $sql);
    
    if (!$result) {
        echo 0; // Failure. 
    } else {
        echo 1; // Success. 
    }
?>