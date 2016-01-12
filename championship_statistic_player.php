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

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               `statisticplayer_game`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_game` DESC, `player_id` ASC
        LIMIT 5";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               `statisticplayer_win`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_win` DESC, `player_id` ASC
        LIMIT 5";
$win_sql = $mysqli->query($sql);

$win_array = $win_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               `statisticplayer_best`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_best` DESC, `player_id` ASC
        LIMIT 5";
$best_sql = $mysqli->query($sql);

$best_array = $best_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               `statisticplayer_goal`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_goal` DESC, `player_id` ASC
        LIMIT 5";
$goal_sql = $mysqli->query($sql);

$goal_array = $goal_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               `statisticplayer_pass_scoring`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_pass_scoring` DESC, `player_id` ASC
        LIMIT 5";
$pass_sql = $mysqli->query($sql);

$pass_array = $pass_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               ROUND(`statisticplayer_ontarget`/`statisticplayer_shot`*'100','0') AS `statisticplayer_shot`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        AND `statisticplayer_shot`>'0'
        ORDER BY `statisticplayer_ontarget`/`statisticplayer_shot` DESC, `player_id` ASC
        LIMIT 5";
$shot_sql = $mysqli->query($sql);

$shot_array = $shot_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               `statisticplayer_red`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_red` DESC, `player_id` ASC
        LIMIT 5";
$red_sql = $mysqli->query($sql);

$red_array = $red_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               `statisticplayer_yellow`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_yellow` DESC, `player_id` ASC
        LIMIT 5";
$yellow_sql = $mysqli->query($sql);

$yellow_array = $yellow_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`,
               `name_name`,
               `surname_name`,
               `statisticplayer_distance`,
               `team_id`,
               `team_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `statisticplayer_tournament_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_distance` DESC, `player_id` ASC
        LIMIT 5";
$distance_sql = $mysqli->query($sql);

$distance_array = $distance_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $tournament_name);
$smarty->assign('game_array', $game_array);
$smarty->assign('win_array', $win_array);
$smarty->assign('best_array', $best_array);
$smarty->assign('goal_array', $goal_array);
$smarty->assign('pass_array', $pass_array);
$smarty->assign('shot_array', $shot_array);
$smarty->assign('red_array', $red_array);
$smarty->assign('yellow_array', $yellow_array);
$smarty->assign('distance_array', $distance_array);

$smarty->display('main.html');