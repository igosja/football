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

$sql = "SELECT `statisticcountry_goal`,
               `country_id`,
               `country_name`
        FROM `statisticcountry`
        LEFT JOIN `country`
        ON `country_id`=`statisticcountry_country_id`
        WHERE `statisticcountry_tournament_id`='$num_get'
        AND `statisticcountry_season_id`='$igosja_season_id'
        ORDER BY `statisticcountry_goal` DESC, `country_id` ASC
        LIMIT 5";
$goal_sql = $mysqli->query($sql);

$goal_array = $goal_sql->fetch_all(1);

$sql = "SELECT `statisticcountry_pass`,
               `country_id`,
               `country_name`
        FROM `statisticcountry`
        LEFT JOIN `country`
        ON `country_id`=`statisticcountry_country_id`
        WHERE `statisticcountry_tournament_id`='$num_get'
        AND `statisticcountry_season_id`='$igosja_season_id'
        ORDER BY `statisticcountry_pass` DESC, `country_id` ASC
        LIMIT 5";
$pass_sql = $mysqli->query($sql);

$pass_array = $pass_sql->fetch_all(1);

$sql = "SELECT `statisticcountry_red`,
               `country_id`,
               `country_name`
        FROM `statisticcountry`
        LEFT JOIN `country`
        ON `country_id`=`statisticcountry_country_id`
        WHERE `statisticcountry_tournament_id`='$num_get'
        AND `statisticcountry_season_id`='$igosja_season_id'
        ORDER BY `statisticcountry_red` DESC, `country_id` ASC
        LIMIT 5";
$red_sql = $mysqli->query($sql);

$red_array = $red_sql->fetch_all(1);

$sql = "SELECT `statisticcountry_yellow`,
               `country_id`,
               `country_name`
        FROM `statisticcountry`
        LEFT JOIN `country`
        ON `country_id`=`statisticcountry_country_id`
        WHERE `statisticcountry_tournament_id`='$num_get'
        AND `statisticcountry_season_id`='$igosja_season_id'
        ORDER BY `statisticcountry_yellow` DESC, `country_id` ASC
        LIMIT 5";
$yellow_sql = $mysqli->query($sql);

$yellow_array = $yellow_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`,
               `series_value`
        FROM `series`
        LEFT JOIN `country`
        ON `country_id`=`series_country_id`
        WHERE `series_tournament_id`='$num_get'
        AND `series_seriestype_id`='" . SERIES_WIN . "'
        ORDER BY `series_value` DESC, `country_id` ASC
        LIMIT 5";
$win_sql = $mysqli->query($sql);

$win_array = $win_sql->fetch_all(1);

$sql = "SELECT `series_value`,
               `country_id`,
               `country_name`
        FROM `series`
        LEFT JOIN `country`
        ON `country_id`=`series_country_id`
        WHERE `series_tournament_id`='$num_get'
        AND `series_seriestype_id`='" . SERIES_NO_LOOSE . "'
        ORDER BY `series_value` DESC, `country_id` ASC
        LIMIT 5";
$no_loose_sql = $mysqli->query($sql);

$no_loose_array = $no_loose_sql->fetch_all(1);

$sql = "SELECT `series_value`,
               `country_id`,
               `country_name`
        FROM `series`
        LEFT JOIN `country`
        ON `country_id`=`series_country_id`
        WHERE `series_tournament_id`='$num_get'
        AND `series_seriestype_id`='" . SERIES_LOOSE . "'
        ORDER BY `series_value` DESC, `country_id` ASC
        LIMIT 5";
$loose_sql = $mysqli->query($sql);

$loose_array = $loose_sql->fetch_all(1);

$sql = "SELECT `series_value`,
               `country_id`,
               `country_name`
        FROM `series`
        LEFT JOIN `country`
        ON `country_id`=`series_country_id`
        WHERE `series_tournament_id`='$num_get'
        AND `series_seriestype_id`='" . SERIES_NO_PASS . "'
        ORDER BY `series_value` DESC, `country_id` ASC
        LIMIT 5";
$nopass_sql = $mysqli->query($sql);

$nopass_array = $nopass_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $header_title . '. ???????????????????? ??????????????. ' . $seo_title;
$seo_description    = $header_title . '. ???????????????????? ??????????????. ' . $seo_description;
$seo_keywords       = $header_title . ', ???????????????????? ??????????????, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');