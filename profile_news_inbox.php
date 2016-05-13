<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    $num_get = $authorization_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$sql = "SELECT `inbox_id`,
               `inbox_date`,
               `inbox_read`,
               `inbox_title`,
               `user_id`,
               `user_login`
        FROM `inbox`
        LEF JOIN `user`
        ON `user_id`=`inbox_sender_id`
        WHERE `inbox_user_id`='$num_get'
        AND `inbox_support`='0'
        ORDER BY `inbox_date` DESC, `inbox_id` DESC";
$inbox_sql = $mysqli->query($sql);

$inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

$num                = $authorization_id;
$header_title       = $authorization_login;
$seo_title          = $header_title . '. Входящие сообщения. ' . $seo_title;
$seo_description    = $header_title . '. Входящие сообщения. ' . $seo_description;
$seo_keywords       = $header_title . ', входящие сообщения, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');