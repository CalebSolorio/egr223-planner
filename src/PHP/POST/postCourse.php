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
    $semID = $_POST['semID'];
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
    
    // Insert the course into the database.
    $sql = "INSERT INTO courses VALUES (".$id.", ".$semID.", null, '".addslashes($name)."', '".addslashes($code)."', '".addslashes($description)."', '".$days."', '".$start."', '".$end."', '".$color."', null)";
    $result = mysqli_query($db, $sql);
    
    if (!$result) {
        echo 0; // Failure. 
    } else {
        echo mysqli_insert_id($db); // Success. 
    }
?>