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

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    $smarty->display('wrong_page.html');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

if (isset($_GET['stage']))
{
    $stage_id = (int) $_GET['stage'];
}
else
{
    $today = date('Y-m-d');

    $sql = "SELECT `game_stage_id`
            FROM `shedule`
            LEFT JOIN `game`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`<='$today'
            AND `game_tournament_id`='$get_num'
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` DESC
            LIMIT 1";
    $stage_sql = $mysqli->query($sql);

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    $stage_id = $stage_array[0]['game_stage_id'];
}

$sql = "SELECT `game_id`,
               `game_guest_score`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_team_id`,
               `game_played`,
               `game_stage_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_name` AS `home_team_name`
        FROM `game`
        LEFT JOIN `team` AS `home_team`
        ON `home_team`.`team_id`=`game_home_team_id`
        LEFT JOIN `team` AS `guest_team`
        ON `guest_team`.`team_id`=`game_guest_team_id`
        WHERE `game_tournament_id`='$get_num'
        AND `game_stage_id`='$stage_id'
        ORDER BY `game_id` ASC";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `shedule_date`,
               `stage_id`,
               `stage_name`
        FROM `game`
        LEFT JOIN `stage`
        ON `game_stage_id`=`stage_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$get_num'
        GROUP BY `stage_id`
        ORDER BY `shedule_date` ASC";
$stage_sql = $mysqli->query($sql);

$stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $tournament_name);
$smarty->assign('game_array', $game_array);
$smarty->assign('stage_array', $stage_array);

$smarty->display('main.html');