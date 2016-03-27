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

$sql = "SELECT `game_guest_team_id`,
               `t2`.`team_name` AS `game_guest_team_name`,
               `game_guest_score`,
               `game_guest_shoot_out`,
               `game_home_team_id`,
               `t1`.`team_name` AS `game_home_team_name`,
               `game_home_score`,
               `game_home_shoot_out`,
               `game_id`,
               `game_played`
        FROM `game`
        LEFT JOIN `team` AS `t1`
        ON `game_home_team_id`=`t1`.`team_id`
        LEFT JOIN `team` AS `t2`
        ON `game_guest_team_id`=`t2`.`team_id`
        WHERE `game_id`='$get_num'
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (0 == $count_game)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$game_played          = $game_array[0]['game_played'];
$header_2_home_id     = $game_array[0]['game_home_team_id'];
$header_2_home_name   = $game_array[0]['game_home_team_name'];
$header_2_guest_id    = $game_array[0]['game_guest_team_id'];
$header_2_guest_name  = $game_array[0]['game_guest_team_name'];

if (0 == $game_played)
{
    redirect('game_before_before.php?num=' . $get_num);
}

$home_score     = $game_array[0]['game_home_score'];
$guest_score    = $game_array[0]['game_guest_score'];
$header_2_score = $home_score . '-' . $guest_score;
$home_shootout  = $game_array[0]['game_home_shoot_out'];
$guest_shootout = $game_array[0]['game_guest_shoot_out'];

if (0 != $home_shootout && 0 != $guest_shootout)
{
    $header_2_shootout = '(пен. ' . $home_shootout . ':' . $guest_shootout . ')';
}
else
{
    $header_2_shootout = '';
}

$sql = "SELECT `lineup_condition`,
               `lineup_goal`,
               `lineup_mark`,
               `name_name`,
               `player_id`,
               `player_number`,
               `position_name`,
               `surname_name`
        FROM `lineup`
        LEFT JOIN `player`
        ON `lineup_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `position`
        ON `lineup_position_id`=`position_id`
        WHERE `lineup_game_id`='$get_num'
        AND `lineup_team_id`='$header_2_home_id'
        ORDER BY `lineup_id` ASC";
$home_player_sql = $mysqli->query($sql);

$home_player_array = $home_player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineup_condition`,
               `lineup_goal`,
               `lineup_mark`,
               `name_name`,
               `player_id`,
               `player_number`,
               `position_name`,
               `surname_name`
        FROM `lineup`
        LEFT JOIN `player`
        ON `lineup_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `position`
        ON `lineup_position_id`=`position_id`
        WHERE `lineup_game_id`='$get_num'
        AND `lineup_team_id`='$header_2_guest_id'
        ORDER BY `lineup_id` ASC";
$guest_player_sql = $mysqli->query($sql);

$guest_player_array = $guest_player_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $header_2_home_name . ' ' . $header_2_score . ' ' . $header_2_shootout . ' ' . $header_2_guest_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');