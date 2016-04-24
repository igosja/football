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

    $sql = "SELECT `game_shedule_id`
            FROM `shedule`
            LEFT JOIN `game`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`<='$today'
            AND `game_tournament_id`='$num_get'
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` DESC
            LIMIT 1";
    $shedule_sql = $mysqli->query($sql);

    $count_shedule = $shedule_sql->num_rows;

    if (0 == $count_shedule)
    {
        $sql = "SELECT `game_shedule_id`
                FROM `shedule`
                LEFT JOIN `game`
                ON `game_shedule_id`=`shedule_id`
                WHERE `shedule_date`>'$today'
                AND `game_tournament_id`='$num_get'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` ASC
                LIMIT 1";
        $shedule_sql = $mysqli->query($sql);
    }

    $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

    if (isset($shedule_array[0]['game_shedule_id']))
    {
        $shedule_id = $shedule_array[0]['game_shedule_id'];
    }
    else
    {
        $shedule_id = 0;
    }
}

$sql = "SELECT `game_id`,
               `game_guest_score`,
               `game_guest_country_id`,
               `game_home_score`,
               `game_home_country_id`,
               `game_played`,
               `game_shedule_id`,
               `guest_country`.`country_name` AS `guest_country_name`,
               `home_country`.`country_name` AS `home_country_name`
        FROM `game`
        LEFT JOIN `country` AS `home_country`
        ON `home_country`.`country_id`=`game_home_country_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_country`.`country_id`=`game_guest_country_id`
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
        GROUP BY `shedule_id`
        ORDER BY `shedule_date` ASC";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');