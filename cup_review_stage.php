<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

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
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `team_id`,
               `team_name`,
               `standing_score`-`standing_pass` AS `standing_difference`,
               `standing_draw`,
               `standing_game`,
               `standing_loose`,
               `standing_pass`,
               `standing_place`,
               `standing_point`,
               `standing_score`,
               `standing_win`
        FROM `standing`
        LEFT JOIN `team`
        ON `standing_team_id`=`team_id`
        WHERE `standing_tournament_id`='$num_get'
        AND `standing_season_id`='$igosja_season_id'
        ORDER BY `standing_place` ASC";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $tournament_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');