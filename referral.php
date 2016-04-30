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

$sql = "SELECT `team_id`,
               `team_name`,
               `user_last_visit`,
               `user_login`,
               `user_registration_date`
        FROM `user`
        LEFT JOIN `team`
        ON `team_user_id`=`user_id`
        WHERE `user_referrer`='$num_get'";
$referral_sql = $mysqli->query($sql);

$referral_array = $referral_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = $authorization_login;

include (__DIR__ . '/view/main.php');