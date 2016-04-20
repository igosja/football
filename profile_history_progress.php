<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$sql = "SELECT `standing_place`,
               `standing_season_id`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `standing`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_user_id`='$authorization_id'
        ORDER BY `standing_season_id` DESC";
$progress_sql = $mysqli->query($sql);

$progress_array = $progress_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = $authorization_login;

include (__DIR__ . '/view/main.php');