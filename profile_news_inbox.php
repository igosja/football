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
               `user_login`
        FROM `inbox`
        LEF JOIN `user`
        ON `user_id`=`inbox_sender_id`
        WHERE `inbox_user_id`='$num_get'
        AND `inbox_support`='0'
        ORDER BY `inbox_date` DESC";
$inbox_sql = $mysqli->query($sql);

$inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = $authorization_login;

include (__DIR__ . '/view/main.php');