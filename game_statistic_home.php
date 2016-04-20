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

$sql = "SELECT `game_home_team_id`
        FROM `game`
        WHERE `game_id`='$get_num'
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (0 == $count_game)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$home_team_id = $game_array[0]['game_home_team_id'];

if (0 != $home_team_id)
{
    $team_country   = 'team';
    $number         = '';
}
else
{
    $team_country   = 'country';
    $number         = '_national';
}

$sql = "SELECT `game_guest_" . $team_country . "_id`,
               `t2`.`" . $team_country . "_name` AS `game_guest_" . $team_country . "_name`,
               `game_guest_score`,
               `game_guest_shoot_out`,
               `game_home_" . $team_country . "_id`,
               `t1`.`" . $team_country . "_name` AS `game_home_" . $team_country . "_name`,
               `game_home_score`,
               `game_home_shoot_out`,
               `game_id`,
               `game_played`,
               `lineup_condition`,
               `lineup_distance`,
               `lineup_foul_made`,
               `lineup_foul_recieve`,
               `lineup_goal`,
               `lineup_mark`,
               `lineup_ontarget`,
               `lineup_offside`,
               `lineup_pass`,
               `lineup_pass_accurate`,
               `lineup_pass_scoring`,
               `lineup_red`,
               `lineup_shot`,
               `lineup_yellow`,
               `name_name`,
               `player_id`,
               `player_number" . $number . "`,
               `surname_name`
        FROM `game`
        LEFT JOIN `" . $team_country . "` AS `t1`
        ON `game_home_" . $team_country . "_id`=`t1`.`" . $team_country . "_id`
        LEFT JOIN `" . $team_country . "` AS `t2`
        ON `game_guest_" . $team_country . "_id`=`t2`.`" . $team_country . "_id`
        LEFT JOIN `lineup`
        ON (`lineup_" . $team_country . "_id`=`game_home_" . $team_country . "_id`
        AND `lineup_game_id`=`game_id`)
        LEFT JOIN `player`
        ON `player_id`=`lineup_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `position`
        ON `position_id`=`lineup_position_id`
        WHERE `game_id`='$get_num'
        ORDER BY `lineup_id` ASC";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$game_played          = $game_array[0]['game_played'];
$header_2_home_id     = $game_array[0]['game_home_' . $team_country . '_id'];
$header_2_home_name   = $game_array[0]['game_home_' . $team_country . '_name'];
$header_2_guest_id    = $game_array[0]['game_guest_' . $team_country . '_id'];
$header_2_guest_name  = $game_array[0]['game_guest_' . $team_country . '_name'];

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

$num            = $get_num;
$header_title   = $header_2_home_name . ' ' . $header_2_score . ' ' . $header_2_shootout . ' ' . $header_2_guest_name;

include (__DIR__ . '/view/main.php');