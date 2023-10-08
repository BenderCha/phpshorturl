<?php
    include "db.php";
    $org_url = mysqli_real_escape_string($db, $_POST['shorten_url']);
    $full_url = str_replace(' ', '', $org_url);
    $hidden_url = mysqli_real_escape_string($db, $_POST['hidden_url']);

    if (!empty($full_url))
    {
        $domain = "urlshort";
        if (preg_match("/{$domain}/i", $full_url) && preg_match("/\//i", $full_url)) {
            $explodeURL = explode('/', $full_url);
            $short_url = end($explodeURL);
            if ($short_url != "")
            {
              $sql = mysqli_query($db, "SELECT shorten_url FROM url WHERE shorten_url = '{$short_url}' && shorten_url != '{$hidden_url}'");
              if (mysqli_num_rows($sql) == 0) 
              {
                $sql2 = mysqli_query($db, "UPDATE url SET shorten_url = '{$short_url}' WHERE shorten_url = '{$hidden_url}'");
                if ($sql2)
                {
                    echo "Success";
                } else {
                    echo "Something went wrong!";
                }
              } else {
                echo "Error - This url already exist!";
              } 
            } else {
                echo "Invalid - You can't edit domain name!";  
            }
        } else {
            echo "Invalid - You can't edit domain name!";  
        }
    } else {
        echo "Error - You have to enter short URL!";
    }

?>