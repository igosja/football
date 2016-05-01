<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    $num_get = $authorization_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$sql = "SELECT `game_home_team_id`,
               IF (`game_home_team_id`='$authorization_team_id', `game_home_score`, `game_guest_score`) AS `home_score`,
               `game_id`,
               `game_played`,
               IF (`game_home_team_id`='$authorization_team_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$authorization_team_id', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        WHERE (`game_home_team_id`='$authorization_team_id'
        OR `game_guest_team_id`='$authorization_team_id')
        AND `shedule_season_id`='$igosja_season_id'
        ORDER BY `shedule_date` ASC";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

if (isset($authorization_country_id))
{
    $sql = "SELECT `game_home_team_id`,
                   IF (`game_home_country_id`='$authorization_country_id', `game_home_score`, `game_guest_score`) AS `home_score`,
                   `game_id`,
                   `game_played`,
                   IF (`game_home_country_id`='$authorization_country_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
                   `shedule_date`,
                   `country_id`,
                   `country_name`,
                   `tournament_name`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `country`
            ON IF (`game_home_country_id`='$authorization_country_id', `game_guest_country_id`=`country_id`, `game_home_country_id`=`country_id`)
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            WHERE (`game_home_country_id`='$authorization_country_id'
            OR `game_guest_country_id`='$authorization_country_id')
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` ASC";
    $shedule_national_sql = $mysqli->query($sql);

    $shedule_national_array = $shedule_national_sql->fetch_all(MYSQLI_ASSOC);

    $shedule_array = array_merge($shedule_array, $shedule_national_array);

    usort($shedule_array, 'f_igosja_nearest_game_sort');
}

$num                = $authorization_id;
$header_title       = $authorization_login;
$seo_title          = $header_title . '. Матчи менеджера. ' . $seo_title;
$seo_description    = $header_title . '. Матчи менеджера. ' . $seo_description;
$seo_keywords       = $header_title . ', Матчи менеджера, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');