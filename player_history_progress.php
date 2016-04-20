<?php

include (__DIR__ . '/include/include.php');

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
    include (__DIR__ . '/view/wrong_page.php');
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
               `standing_place`,
               `standing_season_id`
        FROM `statisticplayer`
        LEFT JOIN `standing`
        ON (`statisticplayer_team_id`=`standing_team_id`
        AND `standing_season_id`=`statisticplayer_season_id`
        AND `statisticplayer_tournament_id`=`standing_tournament_id`)
        LEFT JOIN `team`
        ON `team_id`=`statisticplayer_team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        WHERE `statisticplayer_player_id`='$get_num'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
        ORDER BY `statisticplayer_season_id` DESC";
$trophy_sql = $mysqli->query($sql);

$trophy_array = $trophy_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $player_name . ' ' . $player_surname;

include (__DIR__ . '/view/main.php');