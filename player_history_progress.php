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
        WHERE `player_id`='$num_get'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$team_id        = $player_array[0]['team_id'];
$team_name      = $player_array[0]['team_name'];
$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `standing_place`,
               `standing_season_id` AS `season_id`
        FROM `statisticplayer`
        LEFT JOIN `standing`
        ON (`statisticplayer_team_id`=`standing_team_id`
        AND `standing_season_id`=`statisticplayer_season_id`
        AND `statisticplayer_tournament_id`=`standing_tournament_id`)
        LEFT JOIN `team`
        ON `team_id`=`statisticplayer_team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        WHERE `statisticplayer_player_id`='$num_get'
        AND `statisticplayer_season_id`<'$igosja_season_id'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
        ORDER BY `statisticplayer_season_id` DESC";
$championship_sql = $mysqli->query($sql);

$championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `stage_name` AS `standing_place`,
               `cupparticipant_season_id` AS `season_id`
        FROM `statisticplayer`
        LEFT JOIN `cupparticipant`
        ON (`statisticplayer_team_id`=`cupparticipant_team_id`
        AND `cupparticipant_season_id`=`statisticplayer_season_id`
        AND `statisticplayer_tournament_id`=`cupparticipant_tournament_id`)
        LEFT JOIN `team`
        ON `team_id`=`statisticplayer_team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`cupparticipant_tournament_id`
        LEFT JOIN `stage`
        ON `cupparticipant_out`=`stage_id`
        WHERE `statisticplayer_player_id`='$num_get'
        AND `statisticplayer_season_id`<'$igosja_season_id'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
        ORDER BY `statisticplayer_season_id` DESC";
$cup_sql = $mysqli->query($sql);

$cup_array = $cup_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `stage_name` AS `standing_place`,
               `leagueparticipant_season_id` AS `season_id`
        FROM `statisticplayer`
        LEFT JOIN `leagueparticipant`
        ON (`statisticplayer_team_id`=`leagueparticipant_team_id`
        AND `leagueparticipant_season_id`=`statisticplayer_season_id`
        AND `statisticplayer_tournament_id`=`leagueparticipant_tournament_id`)
        LEFT JOIN `team`
        ON `team_id`=`statisticplayer_team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`leagueparticipant_tournament_id`
        LEFT JOIN `stage`
        ON `leagueparticipant_out`=`stage_id`
        WHERE `statisticplayer_player_id`='$num_get'
        AND `statisticplayer_season_id`<'$igosja_season_id'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "'
        ORDER BY `statisticplayer_season_id` DESC";
$league_sql = $mysqli->query($sql);

$league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`,
               `tournament_id`,
               `tournament_name`,
               `worldcup_place` AS `standing_place`,
               `worldcup_season_id` AS `season_id`
        FROM `statisticplayer`
        LEFT JOIN `worldcup`
        ON (`statisticplayer_country_id`=`worldcup_country_id`
        AND `worldcup_season_id`=`statisticplayer_season_id`
        AND `statisticplayer_tournament_id`=`worldcup_tournament_id`)
        LEFT JOIN `country`
        ON `country_id`=`statisticplayer_country_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`worldcup_tournament_id`
        WHERE `statisticplayer_player_id`='$num_get'
        AND `statisticplayer_season_id`<'$igosja_season_id'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_WORLD_CUP . "'
        ORDER BY `statisticplayer_season_id` DESC";
$worldcup_sql = $mysqli->query($sql);

$worldcup_array = $worldcup_sql->fetch_all(MYSQLI_ASSOC);

$trophy_array = array_merge($championship_array, $worldcup_array, $cup_array, $league_array);

usort($trophy_array, 'f_igosja_trophy_sort');

$num            = $num_get;
$header_title   = $player_name . ' ' . $player_surname;

include (__DIR__ . '/view/main.php');