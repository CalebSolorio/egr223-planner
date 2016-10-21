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
    $eventID = $_POST['eventID'];
    $milestones = json_decode($_POST['data']);

    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Remove previous milestones from the database.
    $sql = "DELETE * FROM milestones WHERE eventID=".$eventID;
    $result = mysqli_query($db, $sql);
    
    // Insert the new milestone into the database.
    for ($i = 0; $i < count($milestones->name); $i++) {
        $sql = "INSERT INTO milestones VALUES (".$eventID.", null, '".addslashes($milestones->name[$i])."', ".$milestones->hours[$i].", '".$milestones->complete[$i]."', null)";
        $result = mysqli_query($db, $sql);
    }
    
    if (!$result) {
        echo 0; // Failure. 
    } else {
        echo 1; // Success. 
    }
?>