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

$tournament_array = $tournament_sql->fetch_all(1);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `worldcup_season_id`,
               `country_id`,
               `country_name`
        FROM `worldcup`
        LEFT JOIN `country`
        ON `country_id`=`worldcup_country_id`
        WHERE `worldcup_tournament_id`='$num_get'
        AND `worldcup_season_id`<'$igosja_season_id'
        AND `worldcup_place`='1'
        ORDER BY `worldcup_season_id` DESC";
$first_sql = $mysqli->query($sql);

$count_first = $first_sql->num_rows;
$first_array = $first_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `worldcup`
        LEFT JOIN `country`
        ON `country_id`=`worldcup_country_id`
        WHERE `worldcup_tournament_id`='$num_get'
        AND `worldcup_season_id`<'$igosja_season_id'
        AND `worldcup_place`='2'
        ORDER BY `worldcup_season_id` DESC";
$second_sql = $mysqli->query($sql);

$second_array = $second_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `worldcup`
        LEFT JOIN `country`
        ON `country_id`=`worldcup_country_id`
        WHERE `worldcup_tournament_id`='$num_get'
        AND `worldcup_season_id`<'$igosja_season_id'
        AND `worldcup_place`='3'
        ORDER BY `worldcup_season_id` DESC";
$third_sql = $mysqli->query($sql);

$third_array = $third_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $header_title . '. Победители турнира. ' . $seo_title;
$seo_description    = $header_title . '. Победители турнира. ' . $seo_description;
$seo_keywords       = $header_title . ', победители турнира, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');