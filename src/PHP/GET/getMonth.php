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
    $month = $_POST['month'];
    $year = $_POST['year'];
    $id = $_SESSION['id'];
    
    if (strlen($month) < 2)
        $length = "0".$length;
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Get all events in the specified month.
    $query = "SELECT * FROM events WHERE id=".$id."AND (WHERE start BETWEEN '".$year."-".$month."-1 00:00:00' AND '".$year."-".$month."-31 23:59:59')";
    $result = mysqli_fetch_assoc(mysqli_query($db, $query));
    
    echo "Eyyy".$result;
?>