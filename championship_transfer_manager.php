<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `history_date`,
               `team_id`,
               `team_name`,
               `user_login`
        FROM `history`
        LEFT JOIN `user`
        ON `user_id`=`history_user_id`
        LEFT JOIN `team`
        ON `team_id`=`history_team_id`
        LEFT JOIN `standing`
        ON `standing_team_id`=`team_id`
        WHERE `history_historytext_id`='1'
        AND `history_season_id`='$igosja_season_id'
        AND `standing_season_id`='$igosja_season_id'
        AND `standing_tournament_id`='$num_get'";
$manager_new_sql = $mysqli->query($sql);

$manager_new_array = $manager_new_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `history_date`,
               `team_id`,
               `team_name`,
               `user_login`
        FROM `history`
        LEFT JOIN `user`
        ON `user_id`=`history_user_id`
        LEFT JOIN `team`
        ON `team_id`=`history_team_id`
        WHERE `history_historytext_id`='2'
        AND `history_season_id`='$igosja_season_id'";
$manager_old_sql = $mysqli->query($sql);

$manager_old_array = $manager_old_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. Переходы менеджеров. ' . $seo_title;
$seo_description    = $tournament_name . '. Переходы менеджеров. ' . $seo_description;
$seo_keywords       = $tournament_name . ', переходы менеджеров, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');