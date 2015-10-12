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
               `game_guest_team_id`,
               `t2`.`team_name` AS `game_guest_team_name`,
               `game_guest_score`,
               `game_home_team_id`,
               `t1`.`team_name` AS `game_home_team_name`,
               `game_home_score`,
               `game_id`,
               `game_played`,
               `name_name`,
               `referee_id`,
               `shedule_date`,
               `stadium_capacity`,
               `stadium_name`,
               `stadiumquality_name`,
               `statisticreferee_game`,
               `statisticreferee_red`,
               `statisticreferee_yellow`,
               `surname_name`,
               `tournament_id`,
               `tournament_name`
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
        LEFT JOIN `stadiumquality`
        ON `stadium_stadiumquality_id`=`stadiumquality_id`
        LEFT JOIN `team` AS `t3`
        ON `t3`.`team_id`=`stadium_team_id`
        LEFT JOIN `city`
        ON `city_id`=`t3`.`team_city_id`
        LEFT JOIN `statisticreferee`
        ON `referee_id`=`statisticreferee_referee_id`
        WHERE `game_id`='$get_num'
        AND `statisticreferee_season_id`='$igosja_season_id'
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

if (1 == $game_played)
{
    redirect('game_review_main.php?num=' . $get_num);

    exit;
}

$header_2_score = '-';

$sql = "SELECT `game_guest_score`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_team_id`,
               `game_id`,
               `guest`.`team_name` AS `guest_name`,
               `home`.`team_name` AS `home_name`,
               `shedule_date`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`game_tournament_id`
        LEFT JOIN `team` AS `home`
        ON `home`.`team_id`=`game_home_team_id`
        LEFT JOIN `team` AS `guest`
        ON `guest`.`team_id`=`game_guest_team_id`
        WHERE ((`game_home_team_id`='$header_2_home_id'
        AND `game_guest_team_id`='$header_2_guest_id')
        OR (`game_home_team_id`='$header_2_guest_id'
        AND `game_guest_team_id`='$header_2_home_id'))
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC";
$last_sql = $mysqli->query($sql);

$last_array = $last_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_id`,
               IF (`game_home_team_id`='$header_2_home_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
               IF (`game_home_team_id`='$header_2_home_id', `game_home_score`, `game_guest_score`) AS `home_score`,
               `shedule_date`,
               IF (`game_home_team_id`='$header_2_home_id', `game_guest_team_id`, `game_home_team_id`) AS `team_id`,
               `team_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$header_2_home_id', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        WHERE (`game_home_team_id`='$header_2_home_id'
        OR `game_guest_team_id`='$header_2_home_id')
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC
        LIMIT 5";
$home_latest_game_sql = $mysqli->query($sql);

$home_latest_game_array = $home_latest_game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT IF (`game_home_team_id`='$header_2_guest_id', `game_home_score`, `game_guest_score`) AS `home_score`,
               `game_id`,
               IF (`game_home_team_id`='$header_2_guest_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
               `shedule_date`,
               IF (`game_home_team_id`='$header_2_guest_id', `game_guest_team_id`, `game_home_team_id`) AS `team_id`,
               `team_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$header_2_guest_id', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        WHERE (`game_home_team_id`='$header_2_guest_id'
        OR `game_guest_team_id`='$header_2_guest_id')
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC
        LIMIT 5";
$guest_latest_game_sql = $mysqli->query($sql);

$guest_latest_game_array = $guest_latest_game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `standing_place`,
               `standing_point`
        FROM `standing`
        LEFT JOIN `game`
        ON `game_tournament_id`=`standing_tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_season_id`='$igosja_season_id'
        AND `game_id`='$get_num'
        ORDER BY `standing_place` ASC";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_2_home_id', $header_2_home_id);
$smarty->assign('header_2_home_name', $header_2_home_name);
$smarty->assign('header_2_guest_id', $header_2_guest_id);
$smarty->assign('header_2_guest_name', $header_2_guest_name);
$smarty->assign('header_2_score', $header_2_score);
$smarty->assign('game_array', $game_array);
$smarty->assign('home_latest_game_array', $home_latest_game_array);
$smarty->assign('guest_latest_game_array', $guest_latest_game_array);
$smarty->assign('standing_array', $standing_array);
$smarty->assign('last_array', $last_array);

$smarty->display('main.html');