<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
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

$sql = "SELECT `country_id`,
               `country_name`,
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
        WHERE `worldcup_tournament_id`='$get_num'
        AND `worldcup_season_id`='$igosja_season_id'
        ORDER BY `worldcup_place` ASC";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $tournament_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');