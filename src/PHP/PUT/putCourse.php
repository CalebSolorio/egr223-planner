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
    $courseID = $_POST['courseID'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $description = $_POST['description'];
    $days = $_POST['days'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $color =$_POST['color'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Update the course details.
    $sql = "UPDATE courses SET semID=".$semID.", name='".addslashes($name)."', code='".addslashes($code)."', description='".addslashes($description)."', days='".$days."', start='".$start."', end='".$end."', color='".$color."' WHERE courseID=".$courseID;
    $result = mysqli_query($db, $sql);
    
    if ($result == false) {
        echo 0; // Failure. 
    } else {
        echo 1; // Success. 
    }
?>