<?php

include ('include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `city_name`,
               `game_guest_foul`,
               `game_guest_ontarget`,
               `game_guest_possession`,
               `game_guest_red`,
               `game_guest_score`,
               `game_guest_shot`,
               `game_guest_shoot_out`,
               `game_guest_team_id`,
               `t2`.`team_name` AS `game_guest_team_name`,
               `game_guest_yellow`,
               `game_home_foul`,
               `game_home_ontarget`,
               `game_home_possession`,
               `game_home_red`,
               `game_home_score`,
               `game_home_shot`,
               `game_home_shoot_out`,
               `game_home_team_id`,
               `t1`.`team_name` AS `game_home_team_name`,
               `game_home_yellow`,
               `game_id`,
               `game_played`,
               `game_temperature`,
               `game_referee_mark`,
               `game_visitor`,
               `name_name`,
               `referee_id`,
               `shedule_date`,
               `stadium_name`,
               `surname_name`,
               `tournament_id`,
               `tournament_name`,
               `weather_id`,
               `weather_name`
        FROM `game`
        LEFT JOIN `team` AS `t1`
        ON `game_home_team_id`=`t1`.`team_id`
        LEFT JOIN `team` AS `t2`
        ON `game_guest_team_id`=`t2`.`team_id`
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `referee`
        ON `game_referee_id`=`referee_id`
        LEFT JOIN `name`
        ON `name_id`=`referee_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`referee_surname_id`
        LEFT JOIN `stadium`
        ON `game_stadium_id`=`stadium_id`
        LEFT JOIN `team` AS `t3`
        ON `t3`.`team_id`=`stadium_team_id`
        LEFT JOIN `city`
        ON `city_id`=`t3`.`team_city_id`
        LEFT JOIN `weather`
        ON `weather_id`=`game_weather_id`
        WHERE `game_id`='$get_num'
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (0 == $count_game)
{
    $smarty->display('wrong_page.html');

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

    exit;
}

$home_score     = $game_array[0]['game_home_score'];
$guest_score    = $game_array[0]['game_guest_score'];
$header_2_score = $home_score . ':' . $guest_score;
$home_shootout  = $game_array[0]['game_home_shoot_out'];
$guest_shootout = $game_array[0]['game_guest_shoot_out'];

if (0 != $home_shootout && 0 != $guest_shootout)
{
    $header_2_shootout = '(пен. ' . $home_shootout . ':' . $guest_score . ')';
}
else
{
    $header_2_shootout = '';
}

$sql = "SELECT `event_minute`,
               `eventtype_id`,
               `eventtype_name`,
               `name_name`,
               `player_id`,
               `surname_name`
        FROM `event`
        LEFT JOIN `player`
        ON `player_id`=`event_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `eventtype`
        ON `event_eventtype_id`=`eventtype_id`
        WHERE `event_game_id`='$get_num'
        AND `event_team_id`='$header_2_home_id'
        ORDER BY `event_minute` ASC";
$home_event_sql = $mysqli->query($sql);

$home_event_array = $home_event_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `event_minute`,
               `eventtype_id`,
               `eventtype_name`,
               `name_name`,
               `player_id`,
               `surname_name`
        FROM `event`
        LEFT JOIN `player`
        ON `player_id`=`event_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `eventtype`
        ON `event_eventtype_id`=`eventtype_id`
        WHERE `event_game_id`='$get_num'
        AND `event_team_id`='$header_2_guest_id'
        ORDER BY `event_minute` ASC";
$guest_event_sql = $mysqli->query($sql);

$guest_event_array = $guest_event_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineup_condition`,
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

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $header_2_home_name . ' ' . $header_2_score . ' ' . $header_2_shootout . ' ' . $header_2_guest_name);
$smarty->assign('game_array', $game_array);
$smarty->assign('home_event_array', $home_event_array);
$smarty->assign('guest_event_array', $guest_event_array);
$smarty->assign('home_player_array', $home_player_array);
$smarty->assign('guest_player_array', $guest_player_array);

$smarty->display('main.html');