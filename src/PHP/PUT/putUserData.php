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
    $name = $_POST['username'];
    $color = $_POST['color'];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Update the user's info accoordingly.
    $sql = "UPDATE users SET username='".addslashes($name)."', color='".$color."' WHERE id=".$id;
    $result = mysqli_query($db, $sql);
    
    if (!$result) {
        echo 0; // Failure. 
    } else {
        echo 1; // Success. 
    }
?>