<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');
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
        WHERE `history_historytext_id`='1'
        AND `history_season_id`='$igosja_season_id'";
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

$num            = $get_num;
$header_title   = $tournament_name;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');