<?php
    session_start();

    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "plan";
    $dbport = 3306; 
    
    // Get posted data.
    $data = json_decode($_POST['json']);
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Check connection
    if ($db->connect_error) {
        echo 2;
    }
    
    // Gets the info from the users table and compares the user info to the posted data.
    $query = "SELECT * FROM users";
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['email'] == $data->email && $row['password'] == $data->password) {
            $_SESSION["id"] = $row["id"];
            $pass = true;
            echo 1;
        }
    }
    if (!$pass) {
        echo 0;
    }
?>