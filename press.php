<?php

include (__DIR__ . '/include/include.php');

if (!isset($_GET['num']))
{
    redirect('press_list.php');
}

$num_get = (int) $_GET['num'];

$sql = "SELECT `press_date`,
               `press_name`,
               `press_text`,
               `user_id`,
               `user_login`
        FROM `press`
        LEFT JOIN `user`
        ON `press_user_id`=`user_id`
        WHERE `press_id`='$num_get'
        LIMIT 1";
$press_sql = $mysqli->query($sql);

$count_press = $press_sql->num_rows;

if (0 == $count_press)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$press_array = $press_sql->fetch_all(1);

$header_title       = 'Пресса';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');