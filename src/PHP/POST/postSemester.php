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
    $name = $_POST['name'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Insert the semester into the database.
    $sql = "INSERT INTO semesters VALUES (".$id.", null, '".addslashes($name)."', '".$start."', '".$end."', null)";
    $result = mysqli_query($db, $sql);
    
    if (!$result) { // Failure
        echo 0; 
    } else { // Success
        echo mysqli_insert_id($db); 
    }
?>