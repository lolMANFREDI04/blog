<?php 
    $servername = "localhost";
    $usernam = "root";
    $passwor = "";
    $db_name = "blog";  
    $conn = new mysqli($servername, $usernam, $passwor, $db_name, 3306);
    if($conn->connect_error){
        die("Connection failed".$conn->connect_error);
    }
    echo " ";
    
    ?>