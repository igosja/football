<?php

include (__DIR__ . '/include/include.php');

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
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `standing_season_id`,
               `team_id`,
               `team_name`
        FROM `standing`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_tournament_id`='$get_num'
        AND `standing_season_id`<'$igosja_season_id'
        AND `standing_place`='1'
        ORDER BY `standing_season_id` DESC";
$first_sql = $mysqli->query($sql);

$count_first = $first_sql->num_rows;
$first_array = $first_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`
        FROM `standing`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_tournament_id`='$get_num'
        AND `standing_season_id`<'$igosja_season_id'
        AND `standing_place`='2'
        ORDER BY `standing_season_id` DESC";
$second_sql = $mysqli->query($sql);

$second_array = $second_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`
        FROM `standing`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_tournament_id`='$get_num'
        AND `standing_season_id`<'$igosja_season_id'
        AND `standing_place`='3'
        ORDER BY `standing_season_id` DESC";
$third_sql = $mysqli->query($sql);

$third_array = $third_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');