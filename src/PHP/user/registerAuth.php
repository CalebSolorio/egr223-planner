<?php
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "plan";
    $dbport = 3306;
    $pass = true;
    
    // Get posted data.
    $data = json_decode($_POST['json']);
    
    // Create connection
    $db = new mysqli($servername, $username, $password, $database,
    $dbport);
    
    // Check connection
    if ($db->connect_error) {
        echo 3;
    }
    
    // Check to see if the email provided is already in use.
    $query = "SELECT * FROM users";
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['email'] == $data->email) {
            $pass = false;
            echo 0;
        }
    }
    
    // If the email is not in use, insert the data into the table.
    if ($pass) {
        $sql = "INSERT INTO users VALUES (null, '".addslashes($data->username)."', '".addslashes($data->email)."', 
            '".addslashes($data->password)."', '".$data->color."', null)";
        $result = mysqli_query($db, $sql);
        if (!$result) {
            echo 2; // Failure.
        } else {
            // Give the user a null semester.
            $sql = "SELECT * FROM users";
            $result = mysqli_query($db, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['email'] == $data->email && $row['password'] == $data->password) {
                    $id = $row["id"];
                    $sql = "INSERT INTO semesters VALUES (".$id.", null, 'None', '1000-01-01 00:00:00.000000', '9999-12-31 23:59:59.999999', null)";
                    $result = mysqli_query($db, $sql);
                    $sql = "INSERT INTO courses VALUES (".$id.", ".mysqli_insert_id($db).", null, 'None', 'None', 'This is a class that you can\'t delete but can use if your course doesn\'t have a known end date. We call it the Schrodinger\'s course!', ' ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '#212121', null)";
                    $result = mysqli_query($db, $sql);
                    
                    echo 1; // Success. 
                }
            }
        }
    }
?>