<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `press_id`,
               `press_date`,
               `press_name`,
               `press_text`,
               `user_id`,
               `user_login`
        FROM `press`
        LEFT JOIN `user`
        ON `user_id`=`press_user_id`
        ORDER BY `press_id` DESC";
$press_sql = $mysqli->query($sql);

$press_array = $press_sql->fetch_all(1);

$header_title       = 'Пресса';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');