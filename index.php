<?php
    include "controllers/db.php";
    $new_url = "";
    if (isset($_GET))
    {
        foreach($_GET as $key=>$val)
        {
            $u = mysqli_real_escape_string($db, $key);
            $new_url = str_replace('/', '', $u); 
        }
        $sql = mysqli_query($db, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
        if (mysqli_num_rows($sql) > 0)
        {
            $clicks_query = mysqli_query($db, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'");
            if ($clicks_query) 
            {
                $full_url = mysqli_fetch_assoc($sql);
                header("Location:".$full_url['full_url']);
            }
            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css"/>
    <link rel="stylesheet" href="fonts/stylesheet.css">
    <link rel="stylesheet" href="css/style.css">
    <title>URL Shortener in PHP | CodingBender</title>
</head>
<body>
    <div class="wrapper">
        <form>
            <input type="text" name="full-url" placeholder="Enter or paste a long URL" required>
            <i class="url-icon uil uil-link"></i>
        <button>Shortener</button>
        </form>
        <?php
            $count_query = mysqli_query($db, "SELECT * FROM url ORDER BY id DESC");
            if (mysqli_num_rows($count_query) > 0) :
        ?>
            <div class="count">
                <?php
                    $total_count = mysqli_query($db, "SELECT COUNT(*) FROM url");
                    $total_count_run = mysqli_fetch_assoc($total_count);

                    $clicks_total_count = mysqli_query($db, "SELECT clicks FROM url");
                    $total = 0;
                    while($a = mysqli_fetch_assoc($clicks_total_count))
                    {
                        $total = $a['clicks'] + $total;
                    }
                ?>
                <span>Total links: <span><?= end($total_count_run);?></span> & Total Clicks: <span><?= $total;?></span></span>
                <a href="controllers/delete.php?delete=all" onclick="AllDelete()">Clear All</a>
            </div>
            <div class="urls-area">
            <div class="title">
                <li>Shorten URL</li>
                <li>Original URL</li>
                <li>Clicks</li>
                <li>Action</li>
            </div>
            
        
        <?php while ($row = mysqli_fetch_assoc($count_query)) :?>
            <div class="data">
                <li>
                    <a href="http://urlshort/<?php echo $row['shorten_url']?>" target="_blank">
                        <?php 
                            if ('urlshort/'.strlen($row['shorten_url']) < 50)
                            {
                                echo 'urlshort/'.substr($row['shorten_url'], 0, 50).'...';
                            } else {
                                echo 'urlshort/'.$row['shorten_url'];
                            }
                        ?>
                    </a>
                </li>
                <li>
                <?php 
                    if (strlen($row['full_url']) > 65)
                    {
                        echo substr($row['full_url'], 0, 65).'...';
                    } else {
                        echo $row['full_url'];
                    }
                ?>
                </li>
                <li><?= $row['clicks'];?></li>
                <li><a href="controllers/delete.php?id=<?php echo $row['shorten_url'];?>" onclick="AllDelete()">Delete</a></li>
            </div>
        <?php endwhile; ?>
        </div>
        <?php endif; ?>


    </div>
    <div class="blur-effect"></div>
    <div class="popup-box">
        <div class="info-box">Your short link is ready. You can also edit short link now but con't edit once you soved it. </div>
        <form action="#">
            <label>Edit your shorten url</label>
            <input type="text" spellcheck="false">
            <i class="copy-icon uil uil-copy-alt"></i>
            <button>Save</button>
        </form>
    </div>
    <script src="js/javascript.js"></script>
</body>
</html>