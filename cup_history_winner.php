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

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `looser`.`team_id` AS `looser_id`,
               `looser`.`team_name` AS `looser_name`,
               `shedule_season_id`,
               `winner`.`team_id` AS `winner_id`,
               `winner`.`team_name` AS `winner_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team` AS `winner`
        ON `winner`.`team_id`=IF(`game_home_score`+`game_home_shoot_out`>`game_guest_score`+`game_guest_shoot_out`, `game_home_team_id`, `game_guest_team_id`)
        LEFT JOIN `team` AS `looser`
        ON `looser`.`team_id`=IF(`game_home_score`+`game_home_shoot_out`>`game_guest_score`+`game_guest_shoot_out`, `game_guest_team_id`, `game_home_team_id`)
        WHERE `game_tournament_id`='$get_num'
        AND `shedule_season_id`<'$igosja_season_id'
        AND `game_stage_id`='" . CUP_FINAL_STAGE . "'
        ORDER BY `shedule_season_id` DESC";
$winner_sql = $mysqli->query($sql);

$winner_array = $winner_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');