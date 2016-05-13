<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `standing_place`,
               `standing_season_id` AS `season_id`,
               `tournament_id`,
               `tournament_name`
        FROM `standing`
        LEFT JOIN `tournament`
        ON `standing_tournament_id`=`tournament_id`
        WHERE `standing_team_id`='$num_get'
        AND `standing_season_id`<'$igosja_season_id'
        ORDER BY `standing_season_id` DESC";
$championship_sql = $mysqli->query($sql);

$championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name` AS `standing_place`,
               `cupparticipant_season_id` AS `season_id`,
               `tournament_id`,
               `tournament_name`
        FROM `cupparticipant`
        LEFT JOIN `tournament`
        ON `cupparticipant_tournament_id`=`tournament_id`
        LEFT JOIN `stage`
        ON `stage_id`=`cupparticipant_out`
        WHERE `cupparticipant_team_id`='$num_get'
        AND `cupparticipant_season_id`<'$igosja_season_id'
        ORDER BY `cupparticipant_season_id` DESC";
$cup_sql = $mysqli->query($sql);

$cup_array = $cup_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name` AS `standing_place`,
               `leagueparticipant_season_id` AS `season_id`,
               `tournament_id`,
               `tournament_name`
        FROM `leagueparticipant`
        LEFT JOIN `tournament`
        ON `leagueparticipant_tournament_id`=`tournament_id`
        LEFT JOIN `stage`
        ON `stage_id`=`leagueparticipant_out`
        WHERE `leagueparticipant_team_id`='$num_get'
        AND `leagueparticipant_season_id`<'$igosja_season_id'
        ORDER BY `leagueparticipant_season_id` DESC";
$league_sql = $mysqli->query($sql);

$league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

$tournament_array = array_merge($championship_array, $cup_array, $league_array);

usort($tournament_array, 'f_igosja_trophy_sort');

$sql = "SELECT `history_date`,
               `user_id`,
               `user_login`
        FROM `history`
        LEFT JOIN `user`
        ON `history_user_id`=`user_id`
        WHERE `history_team_id`='$num_get'
        AND `history_historytext_id`='1'
        ORDER BY `history_date` DESC";
$manager_sql = $mysqli->query($sql);

$manager_array = $manager_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. История клуба. ' . $seo_title;
$seo_description    = $header_title . '. История клуба. ' . $seo_description;
$seo_keywords       = $header_title . ', История клуба, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');