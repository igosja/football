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

if (isset($_GET['shedule']))
{
    $shedule_id = (int) $_GET['shedule'];
}
else
{
    $today = date('Y-m-d');

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            LEFT JOIN `game`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`<='$today'
            AND `game_tournament_id`='$num_get'
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` DESC
            LIMIT 1";
    $stage_sql = $mysqli->query($sql);

    $count_stage = $stage_sql->num_rows;

    if (0 == $count_stage)
    {
        $sql = "SELECT `shedule_id`
                FROM `shedule`
                LEFT JOIN `game`
                ON `game_shedule_id`=`shedule_id`
                WHERE `shedule_date`>'$today'
                AND `game_tournament_id`='$num_get'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` ASC
                LIMIT 1";
        $stage_sql = $mysqli->query($sql);
    }

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    $shedule_id = $stage_array[0]['shedule_id'];
}

$sql = "SELECT `game_id`,
               `game_guest_score`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_team_id`,
               `game_played`,
               `game_shedule_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_name` AS `home_team_name`
        FROM `game`
        LEFT JOIN `team` AS `home_team`
        ON `home_team`.`team_id`=`game_home_team_id`
        LEFT JOIN `team` AS `guest_team`
        ON `guest_team`.`team_id`=`game_guest_team_id`
        WHERE `game_tournament_id`='$num_get'
        AND `game_shedule_id`='$shedule_id'
        ORDER BY `game_id` ASC";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `shedule_date`,
               `shedule_id`,
               `stage_name`
        FROM `game`
        LEFT JOIN `stage`
        ON `game_stage_id`=`stage_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$num_get'
        AND `shedule_season_id`='$igosja_season_id'
        GROUP BY `shedule_id`
        ORDER BY `shedule_date` ASC";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. Результаты матчей. ' . $seo_title;
$seo_description    = $tournament_name . '. Результаты матчей. ' . $seo_description;
$seo_keywords       = $tournament_name . ', результаты матчей, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');