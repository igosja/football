<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$sql = "SELECT `standing_place`,
               `standing_season_id` AS `season_id`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `standing`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_user_id`='$authorization_id'
        ORDER BY `standing_season_id` DESC";
$championship_sql = $mysqli->query($sql);

$championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name` AS `standing_place`,
               `cupparticipant_season_id` AS `season_id`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `cupparticipant`
        LEFT JOIN `tournament`
        ON `tournament_id`=`cupparticipant_tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`cupparticipant_team_id`
        LEFT JOIN `stage`
        ON `stage_id`=`cupparticipant_out`
        WHERE `cupparticipant_user_id`='$authorization_id'
        ORDER BY `cupparticipant_season_id` DESC";
$cup_sql = $mysqli->query($sql);

$cup_array = $cup_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name` AS `standing_place`,
               `leagueparticipant_season_id` AS `season_id`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `leagueparticipant`
        LEFT JOIN `tournament`
        ON `tournament_id`=`leagueparticipant_tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`leagueparticipant_team_id`
        LEFT JOIN `stage`
        ON `stage_id`=`leagueparticipant_out`
        WHERE `leagueparticipant_user_id`='$authorization_id'
        ORDER BY `leagueparticipant_season_id` DESC";
$league_sql = $mysqli->query($sql);

$league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `worldcup_place` AS `standing_place`,
               `worldcup_season_id` AS `season_id`,
               `country_id`,
               `country_name`,
               `tournament_id`,
               `tournament_name`
        FROM `worldcup`
        LEFT JOIN `tournament`
        ON `tournament_id`=`worldcup_tournament_id`
        LEFT JOIN `country`
        ON `country_id`=`worldcup_country_id`
        WHERE `worldcup_user_id`='$authorization_id'
        ORDER BY `worldcup_season_id` DESC";
$worldcup_sql = $mysqli->query($sql);

$worldcup_array = $worldcup_sql->fetch_all(MYSQLI_ASSOC);

$progress_array = array_merge($championship_array, $worldcup_array, $cup_array, $league_array);

usort($progress_array, 'f_igosja_trophy_sort');

$num            = $authorization_id;
$header_title   = $authorization_login;

include (__DIR__ . '/view/main.php');