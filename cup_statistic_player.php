<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_game`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_game` DESC, `player_id` ASC
        LIMIT 5";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_win`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_win` DESC, `player_id` ASC
        LIMIT 5";
$win_sql = $mysqli->query($sql);

$win_array = $win_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_best`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_best` DESC, `player_id` ASC
        LIMIT 5";
$best_sql = $mysqli->query($sql);

$best_array = $best_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_goal`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_goal` DESC, `player_id` ASC
        LIMIT 5";
$goal_sql = $mysqli->query($sql);

$goal_array = $goal_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_pass_scoring`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_pass_scoring` DESC, `player_id` ASC
        LIMIT 5";
$pass_sql = $mysqli->query($sql);

$pass_array = $pass_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(`statisticplayer_ontarget`/`statisticplayer_shot`*'100','0') AS `statisticplayer_shot`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        AND `statisticplayer_shot`>'0'
        ORDER BY `statisticplayer_ontarget`/`statisticplayer_shot` DESC, `player_id` ASC
        LIMIT 5";
$shot_sql = $mysqli->query($sql);

$shot_array = $shot_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_red`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_red` DESC, `player_id` ASC
        LIMIT 5";
$red_sql = $mysqli->query($sql);

$red_array = $red_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_yellow`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_yellow` DESC, `player_id` ASC
        LIMIT 5";
$yellow_sql = $mysqli->query($sql);

$yellow_array = $yellow_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(`statisticplayer_distance`/'1000', '1') AS `statisticplayer_distance`,
               `surname_name`,
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
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_distance` DESC, `player_id` ASC
        LIMIT 5";
$distance_sql = $mysqli->query($sql);

$distance_array = $distance_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. Статистика футболистов. ' . $seo_title;
$seo_description    = $tournament_name . '. Статистика футболистов. ' . $seo_description;
$seo_keywords       = $tournament_name . ', статистика футболистов, ' . $seo_keywords;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');