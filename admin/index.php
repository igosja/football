<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT COUNT(`team_id`) AS `count`
        FROM `team`
        WHERE `team_id`!='0'
        AND `team_user_id`='0'";
$freeteam_sql = $mysqli->query($sql);

$freeteam_array = $freeteam_sql->fetch_all(MYSQLI_ASSOC);
$count_freeteam = $freeteam_array[0]['count'];

$sql = "SELECT COUNT(`user_id`) AS `count`,
               DATE_FORMAT(FROM_UNIXTIME(`user_registration_date`), '%d') AS `day`,
               DATE_FORMAT(FROM_UNIXTIME(`user_registration_date`), '%m') AS `month`
        FROM `user`
        WHERE `user_registration_date`>UNIX_TIMESTAMP()-30*24*60*60
        GROUP BY DATE_FORMAT(FROM_UNIXTIME(`user_registration_date`), '%d')
        ORDER BY `user_registration_date` ASC";
$registration_sql = $mysqli->query($sql);

$registration_array = $registration_sql->fetch_all(MYSQLI_ASSOC);

$registration_date = array();
$registration_user = array();

foreach ($registration_array as $item)
{
    $date = "'" . $item['day'] . '.' . $item['month'] . "'";
    $user = $item['count'];

    $registration_date[] = $date;
    $registration_user[] = $user;
}

$registration_date = implode(', ', $registration_date);
$registration_user = implode(', ', $registration_user);

$sql = "SELECT `history_date`,
               `historytext_name`,
               `country_name`,
               `name_name`,
               `surname_name`,
               `team_name`,
               `user_login`
        FROM `history`
        LEFT JOIN `historytext`
        ON `history_historytext_id`=`historytext_id`
        LEFT JOIN `player`
        ON `history_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `country`
        ON `history_country_id`=`country_id`
        LEFT JOIN `team`
        ON `history_team_id`=`team_id`
        LEFT JOIN `user`
        ON `user_id`=`history_user_id`
        ORDER BY `history_id` DESC
        LIMIT 100";
$history_sql = $mysqli->query($sql);

$history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');