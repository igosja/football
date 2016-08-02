<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_user_id))
{
    $num_get = $authorization_user_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$sql = "SELECT `inbox_id`,
               `inbox_inboxtheme_id`,
               `inbox_date`,
               `inbox_read`,
               `inbox_title`,
               `user_id`,
               `user_login`
        FROM `inbox`
        LEFT JOIN `user`
        ON `user_id`=`inbox_sender_id`
        WHERE `inbox_user_id`='$num_get'
        AND `inbox_support`='0'
        AND `inbox_inboxtheme_id`!='5'
        ORDER BY `inbox_date` DESC, `inbox_id` DESC";
$inbox_sql = $mysqli->query($sql);

$inbox_array_1 = $inbox_sql->fetch_all(1);

$sql = "SELECT MAX(`inbox_id`) AS `inbox_id`,
               `inbox_inboxtheme_id`,
               MAX(`inbox_date`) AS `inbox_date`,
               MIN(`inbox_read`) AS `inbox_read`,
               `inbox_title`,
               `user_id`,
               `user_login`
        FROM `inbox`
        LEFT JOIN `user`
        ON `user_id`=`inbox_sender_id`
        WHERE `inbox_user_id`='$num_get'
        AND `inbox_support`='0'
        AND `inbox_inboxtheme_id`='5'
        GROUP BY `inbox_sender_id`
        ORDER BY `inbox_date` DESC, `inbox_id` DESC";
$inbox_sql = $mysqli->query($sql);

$inbox_array_2 = $inbox_sql->fetch_all(1);

$inbox_array = array_merge($inbox_array_1, $inbox_array_2);

usort($inbox_array, 'f_igosja_inbox_sort');

$num                = $authorization_user_id;
$header_title       = $authorization_login;
$seo_title          = $header_title . '. Входящие сообщения. ' . $seo_title;
$seo_description    = $header_title . '. Входящие сообщения. ' . $seo_description;
$seo_keywords       = $header_title . ', входящие сообщения, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');