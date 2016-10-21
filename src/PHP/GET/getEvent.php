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
    $time = $_POST['time'];
    $d = $_POST['d'];
    $i = $_POST['i'];
    $j = $_POST['j'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    if(isset($_POST['search']) && $_POST['search'] != '') { // Get events matching the user's search.
      $search = $_POST['search'];
      $query = "SELECT courseID, eventID, name, type, description, start, end FROM events WHERE name LIKE '%".addslashes($search)."%'"; 
      $result = mysqli_query($db, $query); 
      $i = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $data[$i] = $row;
        $i++;
      }
    } else if ($eventID == -1) { // Get all events for the specified user on a specific day..
      $id = $_SESSION['id'];
      $query = "SELECT courseID, eventID, name, type, description, start, end FROM events WHERE id=".$id." AND start LIKE '".$time."%'";
      $result = mysqli_query($db, $query); 
      $i = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        if (isset($_POST['d']) && $_POST['d'] != '') {
          $row['d'] = $d;
          $row['i'] = $i;
          $row['j'] = $j;
        }
        if (isset($_POST['time']) && $_POST['time'] != '') {
          $row['time'] = $time;
        }
        $data[$i] = $row;
        $i++;
      }
    } else { // Get all events for a specified user.
      $query = "SELECT courseID, eventID, name, type, description, start, end FROM events WHERE eventID=".$eventID;
      $data = mysqli_fetch_assoc(mysqli_query($db, $query)); 
    }
    
    echo json_encode($data);
?>