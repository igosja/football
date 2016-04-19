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

$sql = "SELECT `continent_name`
        FROM `continent`
        WHERE `continent_id`='$get_num'
        LIMIT 1";
$continent_sql = $mysqli->query($sql);

$count_continent = $continent_sql->num_rows;

if (0 == $count_continent)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$continent_name = $continent_array[0]['continent_name'];

$sql = "SELECT `country_id`,
               `country_name`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `tournament_reputation`
        FROM `country`
        LEFT JOIN `continent`
        ON `continent_id`=`country_continent_id`
        CROSS JOIN `tournament`
        ON `tournament_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT `game_tournament_id`,
                   `team_id`,
                   `team_name`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team`
            ON IF(`game_home_score`+`game_home_shoot_out`>`game_guest_score`+`game_guest_shoot_out`, `game_home_team_id`, `game_guest_team_id`)=`team_id`
            WHERE `shedule_season_id`='$igosja_season_id'-'1'
            AND `game_stage_id`='" . CUP_FINAL_STAGE . "'
            AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
        ) AS `t1`
        ON `tournament_id`=`game_tournament_id`
        WHERE `country_continent_id`='$get_num'
        AND `tournament_tournamenttype_id`='3'
        ORDER BY `tournament_reputation` DESC, `tournament_id` ASC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $continent_name;

include (__DIR__ . '/view/main.php');