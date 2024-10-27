<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>蘇聖元 自我介紹網站</title>
    <link rel="stylesheet" href="index.css"> 
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>蘇聖元 自我介紹網站</h1>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include('menu.php'); ?>
                <div class="jumbotron">
                    <p>
                        <?php include("get-index-meta-data.php"); ?>
                        <hr />
                        <?php include('get-cpu-load.php'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <img src="IMG_6477.gif"  class="profile-pic">
        <div class="description">
            <h2>個人簡介</h2>
            <p>
                我是資工三甲28號蘇聖元，平時喜歡玩遊戲和看動漫化或輕小說，最近玩很瘋的遊戲是Dark And Darker。
            </p>
            <p>
                Email: 11111128@gm.nttu.edu.tw
            </p>
        </div>
    </div>

    <div class="container">
        <div class="description">
            <h2>這是未來要抽的腳色</h2>
            <img src="kisakilobby.jpg"  class="profile-pickisaki">
        </div>
        <img src="senseipr.png"  class="profile-picn">
        <img src="kisakiface.png"  class="profile-picn">
    </div>

    <div class="container">
        <div class="description">
            <h2>推薦> 浮雲(feat. isui)-nao</h2>
            <video width="560" height="315" controls>
                <source src="cloud.mp4" type="video/mp4">
            </video>
        </div>
    </div>

    <div class="container">
        <div class="description">
            <h2>這我</h2>
            <img src="po.jpg" class="profile-pic">
            <h2>這我</h2>
            <img src="usakifuck.png" class="profile-pic">
        </div>
        <img src="kokonagood.gif"  class="profile-picKOKO">
    </div>

    <div class="container">
        <div class="description">
            <h2>這我</h2>
            <img src="me.jpg" class="profile-picself">
        </div>
        <audio controls>
            <source src="selfintro.m4a" type="audio/mpeg">
        </audio>
    </div>

    <footer>
        蘇聖元 自我介紹網站
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
