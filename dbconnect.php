<?php

$link = mysqli_connect("localhost", "root", "", "diary");

        if(mysqli_connect_error()) {
            die ("Database Error, Couldn't connect to database!!");
        }
        
?>