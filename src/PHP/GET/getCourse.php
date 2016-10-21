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
    
    $id = $_SESSION["id"];
    
    // Get posted data.
    $courseID = $_POST['courseID'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    if ($courseID == -1) { // Get all courses for the specified user.
      $id = $_SESSION['id'];
      $query = "SELECT semID, courseID, name, code, description, days, start, end, color FROM courses WHERE id=".$id;
      $result = mysqli_query($db, $query); 
      $i = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $data[$i] = $row;
        $i++;
      }
    } else if ($courseID == -2) { // Get the "None" course and semester for the specified user. 
       $query = "SELECT semID, courseID FROM courses WHERE id=".$id." LIMIT 1";
       $data = mysqli_fetch_assoc(mysqli_query($db, $query));
    } else { // Get info on the sepciied course
      $query = "SELECT semID, courseID, name, code, description, days, start, end, color FROM courses WHERE courseID=".$courseID;
      $data = mysqli_fetch_assoc(mysqli_query($db, $query));
      if (isset($_POST['d']) && $_POST['d'] != '')
        $data['d'] = $_POST['d'];
      if (isset($_POST['k']) && $_POST['k'] != '')
        $data['k'] = $_POST['k'];
    }
    
    echo json_encode($data);
?>