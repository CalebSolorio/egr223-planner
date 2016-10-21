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
    
    if ($semID == -1) { // Get all semesters for a specified user.
      $id = $_SESSION['id'];
      $query = "SELECT semID, name, start, end FROM semesters WHERE id=".$id;
      $result = mysqli_query($db, $query); 
      $i = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $data[$i] = $row;
        $i++;
      }
    } else { // Get info on the specified semester.
      $query = "SELECT semID, name, start, end FROM semesters WHERE semID=".$semID;
      $data = mysqli_fetch_assoc(mysqli_query($db, $query)); 
    }
    
    echo json_encode($data);
?>