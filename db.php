<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database_name = "e_books";

    // Create connection
    $connection = mysqli_connect($servername, $username, $password,$database_name);
    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }else{
//        echo "<h1>Connected</h1>";
    }
?>