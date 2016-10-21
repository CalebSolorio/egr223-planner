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
    $data = $_POST['type'];
    $id = $_SESSION["id"];
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Get all info on the specified user.
    $query = "SELECT * FROM users WHERE id=".$id;
    $result = mysqli_fetch_assoc(mysqli_query($db, $query));
    
    if ($data == 0)
        echo $result["username"];
    else if ($data == 1)
        echo $result["color"];
?>