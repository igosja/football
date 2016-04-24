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

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `standing`
        LEFT JOIN `tournament`
        ON `standing_tournament_id`=`tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_season_id`='$igosja_season_id'-'1'
        AND `tournament_country_id`='$num_get'
        ORDER BY `standing_place` ASC
        LIMIT 1";
$championship_sql = $mysqli->query($sql);

$championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

if (isset($championship_array[0]['tournament_id']))
{
    $tournament_id = $championship_array[0]['tournament_id'];
}

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_goal`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `statisticplayer_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$tournament_id'
        AND `statisticplayer_season_id`='$igosja_season_id'-'1'
        ORDER BY `statisticplayer_goal` DESC
        LIMIT 1";
$championship_goal_sql = $mysqli->query($sql);

$championship_goal_array = $championship_goal_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_pass_scoring`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `statisticplayer_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$tournament_id'
        AND `statisticplayer_season_id`='$igosja_season_id'-'1'
        ORDER BY `statisticplayer_pass_scoring` DESC
        LIMIT 1";
$championship_pass_sql = $mysqli->query($sql);

$championship_pass_array = $championship_pass_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT ROUND(`statisticplayer_mark`/`statisticplayer_game`, '1') AS `mark`,
               `name_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `statisticplayer_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$tournament_id'
        AND `statisticplayer_season_id`='$igosja_season_id'-'1'
        ORDER BY `mark` DESC
        LIMIT 1";
$championship_mark_sql = $mysqli->query($sql);

$championship_mark_array = $championship_mark_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `cupparticipant`
        LEFT JOIN `tournament`
        ON `cupparticipant_tournament_id`=`tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`cupparticipant_team_id`
        WHERE `cupparticipant_season_id`='$igosja_season_id'-'1'
        AND `cupparticipant_out`='-1'
        AND `tournament_country_id`='$num_get'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
        LIMIT 1";
$cup_sql = $mysqli->query($sql);

$cup_array = $cup_sql->fetch_all(MYSQLI_ASSOC);

if (isset($cup_array[0]['tournament_id']))
{
    $tournament_id = $cup_array[0]['tournament_id'];
}

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_goal`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `statisticplayer_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$tournament_id'
        AND `statisticplayer_season_id`='$igosja_season_id'-'1'
        ORDER BY `statisticplayer_goal` DESC
        LIMIT 1";
$cup_goal_sql = $mysqli->query($sql);

$cup_goal_array = $cup_goal_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_pass_scoring`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `statisticplayer_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$tournament_id'
        AND `statisticplayer_season_id`='$igosja_season_id'-'1'
        ORDER BY `statisticplayer_pass_scoring` DESC
        LIMIT 1";
$cup_pass_sql = $mysqli->query($sql);

$cup_pass_array = $cup_pass_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT ROUND(`statisticplayer_mark`/`statisticplayer_game`, '1') AS `mark`,
               `name_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `statisticplayer_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$tournament_id'
        AND `statisticplayer_season_id`='$igosja_season_id'-'1'
        ORDER BY `mark` DESC
        LIMIT 1";
$cup_mark_sql = $mysqli->query($sql);

$cup_mark_array = $cup_mark_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`
        FROM `leagueparticipant`
        LEFT JOIN `team`
        ON `leagueparticipant_team_id`=`team_id`
        LEFT JOIN `city`
        ON `city_id`=`team_city_id`
        WHERE `city_country_id`='$num_get'
        AND `leagueparticipant_in`='1'
        AND `leagueparticipant_season_id`='$igosja_season_id'
        ORDER BY `leagueparticipant_in` DESC";
$champions_qualify_group_sql = $mysqli->query($sql);

$champions_qualify_group_array = $champions_qualify_group_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name`,
               `team_id`,
               `team_name`
        FROM `leagueparticipant`
        LEFT JOIN `team`
        ON `leagueparticipant_team_id`=`team_id`
        LEFT JOIN `city`
        ON `city_id`=`team_city_id`
        LEFT JOIN `stage`
        ON `leagueparticipant_in`=`stage_id`
        WHERE `city_country_id`='$num_get'
        AND `leagueparticipant_in`!='1'
        AND `leagueparticipant_season_id`='$igosja_season_id'
        ORDER BY `leagueparticipant_in` DESC";
$champions_qualify_sql = $mysqli->query($sql);

$champions_qualify_array = $champions_qualify_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name`,
               `team_id`,
               `team_name`
        FROM `leagueparticipant`
        LEFT JOIN `team`
        ON `leagueparticipant_team_id`=`team_id`
        LEFT JOIN `city`
        ON `city_id`=`team_city_id`
        LEFT JOIN `stage`
        ON `leagueparticipant_out`=`stage_id`
        WHERE `city_country_id`='$num_get'
        AND `leagueparticipant_season_id`='$igosja_season_id'
        ORDER BY `leagueparticipant_out` DESC";
$champions_out_sql = $mysqli->query($sql);

$champions_out_array = $champions_out_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $country_name;

include (__DIR__ . '/view/main.php');