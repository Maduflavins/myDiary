<?php
    $link = mysqli_connect("localhost", "root", "DatabasePassword", "diary");

    if(mysqli_connect_error()){
        die("DATABASE CONNECTION ERROR");
    }
?>
