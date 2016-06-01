<?php

include (__DIR__ . '/../include/include.php');

$limit  = 100;
$page   = 0;

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}

$offset = $page * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `history_date`,
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
        LIMIT $offset, $limit";
$history_sql = $mysqli->query($sql);

$history_array = $history_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_history`";
$count_history = $mysqli->query($sql);
$count_history = $count_history->fetch_all(1);
$count_history = $count_history[0]['count_history'];

$count_pagination   = ceil($count_history/$limit);
$start_pagination   = $page - 4;
$end_pagination     = $page + 5;

if (0 > $start_pagination)
{
    $start_pagination = 0;
}
elseif ($count_pagination < $start_pagination)
{
    $start_pagination = $count_pagination - 4;
}

if ($count_pagination < $end_pagination)
{
    $end_pagination = $count_pagination;
}

include (__DIR__ . '/../view/admin_main.php');