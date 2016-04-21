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

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `game_home_country_id`,
               `game_id`,
               `game_played`,
               IF (`game_home_country_id`='$num_get', `game_guest_score`, `game_home_score`) AS `guest_score`,
               IF (`game_home_country_id`='$num_get', `game_home_score`, `game_guest_score`) AS `home_score`,
               `shedule_date`,
               `country_id`,
               `country_name`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `country`
        ON IF (`game_home_country_id`='$num_get', `game_guest_country_id`=`country_id`, `game_home_country_id`=`country_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        WHERE (`game_home_country_id`='$num_get'
        OR `game_guest_country_id`='$num_get')
        AND `shedule_season_id`='$igosja_season_id'
        ORDER BY `shedule_date` ASC";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $country_name;

include (__DIR__ . '/view/main.php');