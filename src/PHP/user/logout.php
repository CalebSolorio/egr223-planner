<?php
    // Destroy the session and redirect the user back to the login screen.
    session_start();
    session_destroy();
    header ("Location: ../../login.php");
?>