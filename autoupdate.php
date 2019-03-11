<?php 
    session_start();
    if (array_key_exists("content", $_POST)) {
        include("dbconnect.php");

        $content = mysqli_real_escape_string($link, $_POST['content']);
        $id = mysqli_real_escape_string($link, $_SESSION['id']);

        $query = "UPDATE `users` SET `diary` = '$content' WHERE id = '$id' LIMIT 1";

        mysqli_query($link, $query);
    }


?>