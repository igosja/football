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

$sql = "SELECT `cupparticipant_season_id`,
               `team_id`,
               `team_name`
        FROM `cupparticipant`
        LEFT JOIN `team`
        ON `cupparticipant_team_id`=`team_id`
        WHERE `cupparticipant_out`='" . CUP_WINNER_STAGE . "'
        AND `cupparticipant_season_id`<'$igosja_season_id'
        AND `cupparticipant_tournament_id`='$num_get'
        ORDER BY `cupparticipant_season_id` DESC";
$winner_sql = $mysqli->query($sql);

$count_winner = $winner_sql->num_rows;
$winner_array = $winner_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`
        FROM `cupparticipant`
        LEFT JOIN `team`
        ON `cupparticipant_team_id`=`team_id`
        WHERE `cupparticipant_out`='" . CUP_FINAL_STAGE . "'
        AND `cupparticipant_season_id`<'$igosja_season_id'
        AND `cupparticipant_tournament_id`='$num_get'
        ORDER BY `cupparticipant_season_id` DESC";
$looser_sql = $mysqli->query($sql);

$looser_array = $looser_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. Побудители турнира. ' . $seo_title;
$seo_description    = $tournament_name . '. Побудители турнира. ' . $seo_description;
$seo_keywords       = $tournament_name . ', побудители турнира, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');