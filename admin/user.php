<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `team_finance`,
               `team_id`,
               `team_name`,
               `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_email`,
               `user_firstname`,
               `user_last_visit`,
               `user_lastname`,
               `user_login`,
               `user_money`,
               `user_national`,
               `user_registration_date`,
               `user_social_fb`,
               `user_social_gl`,
               `user_social_vk`,
               `user_team`,
               `user_trophy`
        FROM `user`
        LEFT JOIN `team`
        ON `team_user_id`=`user_id`
        WHERE `user_id`='$num_get'
        LIMIT 1";
$user_sql = $mysqli->query($sql);

$count_user = $user_sql->num_rows;

if (0 == $count_user)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `ip_date`,
               `ip_ip`
        FROM `ip`
        WHERE `ip_user_id`='$num_get'
        ORDER BY `ip_date` DESC";
$ip_sql = $mysqli->query($sql);

$ip_array = $ip_sql->fetch_all(MYSQLI_ASSOC);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');