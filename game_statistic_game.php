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

$sql = "SELECT `game_guest_corner`,
               `game_guest_foul`,
               `game_guest_moment`,
               `game_guest_offside`,
               `game_guest_ontarget`,
               `game_guest_pass`,
               `game_guest_penalty`,
               `game_guest_possession`,
               `game_guest_red`,
               `game_guest_team_id`,
               `t2`.`team_name` AS `game_guest_team_name`,
               `game_guest_score`,
               `game_guest_shoot_out`,
               `game_guest_shot`,
               `game_guest_yellow`,
               `game_home_corner`,
               `game_home_foul`,
               `game_home_moment`,
               `game_home_offside`,
               `game_home_ontarget`,
               `game_home_pass`,
               `game_home_penalty`,
               `game_home_possession`,
               `game_home_red`,
               `game_home_team_id`,
               `t1`.`team_name` AS `game_home_team_name`,
               `game_home_score`,
               `game_home_shoot_out`,
               `game_home_shot`,
               `game_home_yellow`,
               `game_id`,
               `game_played`,
               `guest_average`,
               `home_average`
        FROM `game`
        LEFT JOIN `team` AS `t1`
        ON `game_home_team_id`=`t1`.`team_id`
        LEFT JOIN `team` AS `t2`
        ON `game_guest_team_id`=`t2`.`team_id`
        LEFT JOIN
        (
            SELECT ROUND(AVG(`lineup_mark`),2) AS `home_average`,
                   `lineup_team_id`
            FROM `lineup`
            WHERE `lineup_game_id`='$get_num'
            AND `lineup_position_id`<='25'
            GROUP BY `lineup_team_id`
        ) AS `t3`
        ON `t3`.`lineup_team_id`=`game_home_team_id`
        LEFT JOIN
        (
            SELECT ROUND(AVG(`lineup_mark`),2) AS `guest_average`,
                   `lineup_team_id`
            FROM `lineup`
            WHERE `lineup_game_id`='$get_num'
            AND `lineup_position_id`<='25'
            GROUP BY `lineup_team_id`
        ) AS `t4`
        ON `t4`.`lineup_team_id`=`game_guest_team_id`
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
$header_2_score = $home_score . '-' . $guest_score;
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

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $header_2_home_name . ' ' . $header_2_score . ' ' . $header_2_shootout . ' ' . $header_2_guest_name);
$smarty->assign('game_array', $game_array);

$smarty->display('main.html');