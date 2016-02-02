<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$sql = "SELECT `inbox_id`,
               `inbox_date`,
               `inbox_read`,
               `inbox_title`
        FROM `inbox`
        WHERE `inbox_user_id`='$get_num'
        ORDER BY `inbox_date` DESC";
$inbox_sql = $mysqli->query($sql);

$inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = $authorization_login;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');