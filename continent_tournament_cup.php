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

$continent_array = $continent_sql->fetch_all(1);

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
            SELECT `cupparticipant_tournament_id`,
                   `team_id`,
                   `team_name`
            FROM `cupparticipant`
            LEFT JOIN `team`
            ON `cupparticipant_team_id`=`team_id`
            WHERE `cupparticipant_season_id`='$igosja_season_id'-'1'
            AND `cupparticipant_out`='" . CUP_WINNER_STAGE . "'
        ) AS `t1`
        ON `tournament_id`=`cupparticipant_tournament_id`
        WHERE `country_continent_id`='$num_get'
        AND `tournament_tournamenttype_id`='3'
        ORDER BY `tournament_reputation` DESC, `tournament_id` ASC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $continent_name;
$seo_title          = $continent_name . '. Рейтинг национальных кубков. ' . $seo_title;
$seo_description    = $continent_name . '. Рейтинг национальных кубков. ' . $seo_description;
$seo_keywords       = $continent_name . ', рейтинг национальных кубков, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');