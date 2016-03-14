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
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT MAX(`lineup_mark`) AS `max_mark`,
               MIN(`lineup_mark`) AS `min_mark`
        FROM `lineup`
        LEFT JOIN `game`
        ON `game_id`=`lineup_game_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `lineup_player_id`='$get_num'
        AND `shedule_season_id`='$igosja_season_id'
        AND `game_played`='1'";
$mark_sql = $mysqli->query($sql);

$mark_array = $mark_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT IF (`game_home_team_id`=`lineup_team_id`, `game_home_score`, `game_guest_score`) AS `home_score`,
               `game_id`,
               IF (`game_home_team_id`=`lineup_team_id`, `game_guest_score`, `game_home_score`) AS `guest_score`,
               `lineup_foul_made`,
               `lineup_goal`,
               `lineup_mark`,
               `lineup_ontarget`,
               ROUND(`lineup_pass_accurate`/`lineup_pass`*'100') AS `lineup_pass_accurate`,
               `lineup_pass_scoring`,
               `lineup_penalty_goal`,
               `lineup_red`,
               `lineup_yellow`,
               `shedule_date`,
               `team_id`,
               `team_name`
        FROM `lineup`
        LEFT JOIN `game`
        ON `lineup_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`lineup_team_id`=`game_home_team_id`, `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        WHERE `lineup_player_id`='$get_num'
        AND `shedule_season_id`='$igosja_season_id'
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `statisticplayer_best`,
               `statisticplayer_foul`,
               `statisticplayer_game`,
               `statisticplayer_goal`,
               ROUND(`statisticplayer_mark`/`statisticplayer_game`,'2') AS `statisticplayer_mark`,
               `statisticplayer_ontarget`,
               ROUND(`statisticplayer_pass_accurate`/`statisticplayer_pass`*'100') AS `statisticplayer_pass_accurate`,
               `statisticplayer_pass_scoring`,
               `statisticplayer_penalty`,
               `statisticplayer_red`,
               `statisticplayer_shot`,
               `statisticplayer_yellow`,
               `tournamenttype_name`
        FROM `statisticplayer`
        LEFT JOIN `tournament`
        ON `tournament_id`=`statisticplayer_tournament_id`
        LEFT JOIN `tournamenttype`
        ON `tournamenttype_id`=`tournament_tournamenttype_id`
        WHERE `statisticplayer_player_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `tournament_id` ASC";
$statistic_sql = $mysqli->query($sql);

$statistic_array = $statistic_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`statisticplayer_best`) AS `count_best`,
               SUM(`statisticplayer_foul`) AS `count_foul`,
               SUM(`statisticplayer_game`) AS `count_game`,
               SUM(`statisticplayer_goal`) AS `count_goal`,
               ROUND(SUM(`statisticplayer_mark`)/SUM(`statisticplayer_game`),2) AS `count_mark`,
               SUM(`statisticplayer_ontarget`) AS `count_ontarget`,
               ROUND(SUM(`statisticplayer_pass_accurate`)/SUM(`statisticplayer_pass`)*'100') AS `count_pass_accurate`,
               SUM(`statisticplayer_pass_scoring`) AS `count_pass_scoring`,
               SUM(`statisticplayer_penalty`) AS `count_penalty`,
               SUM(`statisticplayer_penalty_goal`) AS `count_penalty_goal`,
               SUM(`statisticplayer_red`) AS `count_red`,
               SUM(`statisticplayer_shot`) AS `count_shot`,
               SUM(`statisticplayer_yellow`) AS `count_yellow`,
               SUM(`statisticplayer_win`) AS `count_win`
        FROM `statisticplayer`
        WHERE `statisticplayer_player_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'";
$total_statistic_sql = $mysqli->query($sql);

$total_statistic_array = $total_statistic_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $player_name . ' ' . $player_surname;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');