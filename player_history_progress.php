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

$sql = "SELECT `name_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `team_id`=`player_team_id`
        WHERE `player_id`='$get_num'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$team_id        = $player_array[0]['team_id'];
$team_name      = $player_array[0]['team_name'];
$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `trophyplayer_place`,
               `trophyplayer_season_id`
        FROM `trophyplayer`
        LEFT JOIN `team`
        ON `team_id`=`trophyplayer_team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`trophyplayer_tournament_id`
        WHERE `trophyplayer_player_id`='$get_num'
        ORDER BY `trophyplayer_season_id` DESC";
$trophy_sql = $mysqli->query($sql);

$trophy_array = $trophy_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $player_name . ' ' . $player_surname;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');