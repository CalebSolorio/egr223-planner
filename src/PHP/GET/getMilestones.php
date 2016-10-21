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
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Get milestones for the event
    $query = "SELECT eventID, milestoneID, name, hours, complete FROM milestones WHERE eventID=".$eventID;
    $result = mysqli_query($db, $query); 
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $data[$i] = $row;
      $i++;
    }
    
    echo json_encode($data);
?>