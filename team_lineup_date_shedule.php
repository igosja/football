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

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(1);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `game_home_team_id`,
               `game_id`,
               `game_played`,
               IF (`game_home_team_id`='$num_get', `game_guest_score`, `game_home_score`) AS `guest_score`,
               IF (`game_home_team_id`='$num_get', `game_home_score`, `game_guest_score`) AS `home_score`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$num_get', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        WHERE (`game_home_team_id`='$num_get'
        OR `game_guest_team_id`='$num_get')
        AND `shedule_season_id`='$igosja_season_id'
        ORDER BY `shedule_date` ASC";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Расписание матчей. ' . $seo_title;
$seo_description    = $header_title . '. Расписание матчей. ' . $seo_description;
$seo_keywords       = $header_title . ', расписание матчей, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');