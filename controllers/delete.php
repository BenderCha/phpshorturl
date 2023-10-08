<?php
    include "db.php";
    if (isset($_GET['id'])) 
    {
        $get_id = mysqli_real_escape_string($db, $_GET['id']);
        $sql = mysqli_query($db, "DELETE FROM url WHERE shorten_url = '$get_id'");
        if ($sql) 
        {
            header("Location: ../");
        } else {
            header("Location: ../");
        }
    } elseif(isset($_GET['delete']))
    {
        $delete_all = mysqli_query($db, "DELETE FROM url");
        if ($delete_all) 
        {
            header("Location: ../");
        } else {
            header("Location: ../");
        }
    } else {
        header("Location: ../");
    }

?>