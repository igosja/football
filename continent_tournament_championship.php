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

$sql = "SELECT `continent_name`
        FROM `continent`
        WHERE `continent_id`='$num_get'
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
            SELECT `team_id`,
                   `team_name`,
                   `standing_tournament_id`
            FROM `standing`
            LEFT JOIN `team`
            ON `standing_team_id`=`team_id`
            WHERE `standing_season_id`='$igosja_season_id'-'1'
            AND `standing_place`='1'
        ) AS `t1`
        ON `standing_tournament_id`=`tournament_id`
        WHERE `country_continent_id`='$num_get'
        AND `tournament_tournamenttype_id`='2'
        ORDER BY `tournament_reputation` DESC, `tournament_id` ASC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $continent_name;

include (__DIR__ . '/view/main.php');