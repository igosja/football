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

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$get_num'";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    $smarty->display('wrong_page.html');

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
        WHERE `standing_season_id`='$igosja_season_id'
        AND `tournament_country_id`='$get_num'
        ORDER BY `standing_place` ASC
        LIMIT 1";
$championship_sql = $mysqli->query($sql);

$championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

$tournament_id = $championship_array[0]['tournament_id'];

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
        AND `statisticplayer_season_id`='$igosja_season_id'
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
        AND `statisticplayer_season_id`='$igosja_season_id'
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
        AND `statisticplayer_season_id`='$igosja_season_id'
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
        WHERE `cupparticipant_season_id`='$igosja_season_id'
        AND `cupparticipant_out`='0'
        AND `tournament_country_id`='$get_num'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
        LIMIT 1";
$cup_sql = $mysqli->query($sql);

$cup_array = $cup_sql->fetch_all(MYSQLI_ASSOC);

$tournament_id = $cup_array[0]['tournament_id'];

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
        AND `statisticplayer_season_id`='$igosja_season_id'
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
        AND `statisticplayer_season_id`='$igosja_season_id'
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
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `mark` DESC
        LIMIT 1";
$cup_mark_sql = $mysqli->query($sql);

$cup_mark_array = $cup_mark_sql->fetch_all(MYSQLI_ASSOC);

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
        WHERE `city_country_id`='$get_num'
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
        WHERE `city_country_id`='$get_num'
        AND `leagueparticipant_season_id`='$igosja_season_id'
        ORDER BY `leagueparticipant_out` DESC";
$champions_out_sql = $mysqli->query($sql);

$champions_out_array = $champions_out_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $country_name);
$smarty->assign('championship_array', $championship_array);
$smarty->assign('championship_goal_array', $championship_goal_array);
$smarty->assign('championship_pass_array', $championship_pass_array);
$smarty->assign('championship_mark_array', $championship_mark_array);
$smarty->assign('cup_array', $cup_array);
$smarty->assign('cup_goal_array', $cup_goal_array);
$smarty->assign('cup_pass_array', $cup_pass_array);
$smarty->assign('cup_mark_array', $cup_mark_array);
$smarty->assign('champions_qualify_array', $champions_qualify_array);
$smarty->assign('champions_out_array', $champions_out_array);

$smarty->display('main.html');