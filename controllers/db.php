<?php
    $db = mysqli_connect("localhost", "root", "", "urlshortener");
    if (!$db)
    {
        echo "Database connection error".mysqli_connect_error();
    }
?>