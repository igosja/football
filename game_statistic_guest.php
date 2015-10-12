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

$sql = "SELECT `game_guest_team_id`,
               `t2`.`team_name` AS `game_guest_team_name`,
               `game_guest_score`,
               `game_home_team_id`,
               `t1`.`team_name` AS `game_home_team_name`,
               `game_home_score`,
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
               `player_number`,
               `surname_name`
        FROM `game`
        LEFT JOIN `team` AS `t1`
        ON `game_home_team_id`=`t1`.`team_id`
        LEFT JOIN `team` AS `t2`
        ON `game_guest_team_id`=`t2`.`team_id`
        LEFT JOIN `lineup`
        ON (`lineup_team_id`=`game_guest_team_id`
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
    header('Location: game_before_before.php?num=' . $get_num);

    exit;
}

$home_score     = $game_array[0]['game_home_score'];
$guest_score    = $game_array[0]['game_guest_score'];
$header_2_score = $home_score . '-' . $guest_score;

$smarty->assign('num', $get_num);
$smarty->assign('header_2_home_id', $header_2_home_id);
$smarty->assign('header_2_home_name', $header_2_home_name);
$smarty->assign('header_2_guest_id', $header_2_guest_id);
$smarty->assign('header_2_guest_name', $header_2_guest_name);
$smarty->assign('header_2_score', $header_2_score);
$smarty->assign('game_array', $game_array);

$smarty->display('main.html');