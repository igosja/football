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

$sql = "SELECT `standing_score`-`standing_pass` AS `standing_difference`,
               `standing_draw`,
               `standing_game`,
               `standing_loose`,
               `standing_pass`,
               `standing_place`,
               `standing_point`,
               `standing_score`,
               `standing_win`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `standing`
        LEFT JOIN `team`
        ON `standing_team_id`=`team_id`
        LEFT JOIN `user`
        ON `user_id`=`team_user_id`
        WHERE `standing_tournament_id`='$num_get'
        AND `standing_season_id`='$igosja_season_id'
        ORDER BY `standing_place` ASC";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. Турнирная таблица. ' . $seo_title;
$seo_description    = $tournament_name . '. Турнирная таблица. ' . $seo_description;
$seo_keywords       = $tournament_name . ', турнирная таблица, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');