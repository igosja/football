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

$today = date('Y-m-d');

$sql = "SELECT `team_id`,
               `team_name`,
               `standing_score`-`standing_pass` AS `standing_difference`,
               `standing_draw`,
               `standing_game`,
               `standing_loose`,
               `standing_place`,
               `standing_point`,
               `standing_win`
        FROM `standing`
        LEFT JOIN `team`
        ON `standing_team_id`=`team_id`
        WHERE `standing_tournament_id`='$get_num'
        AND `standing_season_id`='$igosja_season_id'
        ORDER BY `standing_place` ASC";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_id`,
               `game_guest_score`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_team_id`,
               `game_played`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_name` AS `home_team_name`,
               `shedule_date`,
               DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
               `shedule_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `team` AS `home_team`
        ON `home_team`.`team_id`=`game_home_team_id`
        LEFT JOIN `team` AS `guest_team`
        ON `guest_team`.`team_id`=`game_guest_team_id`
        WHERE `game_tournament_id`='$get_num'
        AND `shedule_season_id`='$igosja_season_id'
        AND `shedule_date`=
        (
            SELECT `shedule_date`
            FROM `shedule`
            LEFT JOIN `game`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`<='$today'
            AND `game_tournament_id`='$get_num'
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` DESC
            LIMIT 1
        )
        ORDER BY `game_id` ASC";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `standing_season_id`,
               `team_id`,
               `team_name`
        FROM `standing`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_tournament_id`='$get_num'
        AND `standing_season_id`<'$igosja_season_id'
        AND `standing_place`='1'
        ORDER BY `standing_season_id` DESC
        LIMIT 4";
$winner_sql = $mysqli->query($sql);

$winner_array = $winner_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_goal`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        ORDER BY `statisticplayer_goal` DESC
        LIMIT 5";
$player_goal_sql = $mysqli->query($sql);

$player_goal_array = $player_goal_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_pass_scoring`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        ORDER BY `statisticplayer_pass_scoring` DESC
        LIMIT 5";
$player_pass_sql = $mysqli->query($sql);

$player_pass_array = $player_pass_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(`statisticplayer_mark`/`statisticplayer_game`, 2) AS `statisticplayer_mark`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        ORDER BY `statisticplayer_mark` DESC
        LIMIT 5";
$player_mark_sql = $mysqli->query($sql);

$player_mark_array = $player_mark_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_2_title', $tournament_name);
$smarty->assign('standing_array', $standing_array);
$smarty->assign('game_array', $game_array);
$smarty->assign('winner_array', $winner_array);
$smarty->assign('player_goal_array', $player_goal_array);
$smarty->assign('player_pass_array', $player_pass_array);
$smarty->assign('player_mark_array', $player_mark_array);

$smarty->display('main.html');