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

$sql = "SELECT `country_id`,
               `country_name`,
               `user_login`,
               `worldcup_score`-`worldcup_pass` AS `worldcup_difference`,
               `worldcup_draw`,
               `worldcup_game`,
               `worldcup_loose`,
               `worldcup_pass`,
               `worldcup_place`,
               `worldcup_point`,
               `worldcup_score`,
               `worldcup_win`
        FROM `worldcup`
        LEFT JOIN `country`
        ON `worldcup_country_id`=`country_id`
        LEFT JOIN `user`
        ON `user_id`=`country_user_id`
        WHERE `worldcup_tournament_id`='$num_get'
        AND `worldcup_season_id`='$igosja_season_id'
        ORDER BY `worldcup_place` ASC";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $header_title . '. Стадии турнира. ' . $seo_title;
$seo_description    = $header_title . '. Стадии турнира. ' . $seo_description;
$seo_keywords       = $header_title . ', стадии турнира, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');