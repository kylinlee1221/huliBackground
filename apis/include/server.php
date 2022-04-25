<?php
    $servername = "localhost:33065";
    $username = "root";
    $password = "";
    $db = "hulisql";

    // Create connection
    global $conn;
    $conn = new mysqli($servername, $username, $password,$db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully";
?> 