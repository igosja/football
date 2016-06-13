<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `news_id`,
               `news_title`,
               `news_date`
        FROM `news`
        ORDER BY `news_id` DESC";
$news_sql = $mysqli->query($sql);

$news_array = $news_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');