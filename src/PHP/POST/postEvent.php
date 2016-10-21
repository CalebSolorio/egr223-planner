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
    $name = $_POST['name'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Insert the event into the database.
    $sql = "INSERT INTO events VALUES (".$id.", ".$courseID.", null, '".addslashes($name)."', ".$type.", '".addslashes($description)."', '".$start."', '".$end."', null)";
    $result = mysqli_query($db, $sql);
    
    if (!$result) {
        echo 0; // Failure. 
    } else {
        echo mysqli_insert_id($db); // Success. 
    }
?>