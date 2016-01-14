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

$sql = "SELECT `attribute_name`,
               `attributechapter_name`,
               `country_id`,
               `country_name`,
               `mood_id`,
               `mood_name`,
               `name_name`,
               `player_age`,
               `player_condition`,
               `player_height`,
               `player_leg_left`,
               `player_leg_right`,
               `player_mark`,
               `player_practice`,
               `player_price`,
               `player_salary`,
               `player_weight`,
               `playerattribute_value`,
               `position_description`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `playerattribute`
        ON `playerattribute_player_id`=`player_id`
        LEFT JOIN `attribute`
        ON `attribute_id`=`playerattribute_attribute_id`
        LEFT JOIN `attributechapter`
        ON `attributechapter_id`=`attribute_attributechapter_id`
        LEFT JOIN `mood`
        ON `player_mood_id`=`mood_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `playerposition`
        ON `playerposition_player_id`=`player_id`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        LEFT JOIN
        (
            SELECT `lineup_player_id`, ROUND(AVG(`lineup_mark`),2) AS `player_mark`
            FROM `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `lineup_player_id`='$get_num'
            AND `game_played`='1'
            ORDER BY `shedule_date` DESC
            LIMIT 5
        ) AS `t1`
        ON `lineup_player_id`=`player_id`
        WHERE `player_id`='$get_num'
        ANd `playerposition_value`='100'";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    $smarty->display('wrong_page.html');

    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$team_id        = $player_array[0]['team_id'];
$team_name      = $player_array[0]['team_name'];
$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];
$header_2_title = $player_name . ' ' . $player_surname;

$sql = "SELECT `statisticplayer_best`,
               `statisticplayer_foul`,
               `statisticplayer_game`,
               `statisticplayer_goal`,
               ROUND(`statisticplayer_mark`/`statisticplayer_game`,2) AS `statisticplayer_mark`,
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
               SUM(`statisticplayer_player_id`) AS `count_player_id`,
               SUM(`statisticplayer_red`) AS `count_red`,
               SUM(`statisticplayer_shot`) AS `count_shot`,
               SUM(`statisticplayer_yellow`) AS `count_yellow`
        FROM `statisticplayer`
        WHERE `statisticplayer_player_id`='$get_num'
        AND `statisticplayer_season_id`='$igosja_season_id'";
$total_statistic_sql = $mysqli->query($sql);

$total_statistic_array = $total_statistic_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('team_id', $team_id);
$smarty->assign('team_name', $team_name);
$smarty->assign('header_title', $header_2_title);
$smarty->assign('num', $get_num);
$smarty->assign('player_array', $player_array);
$smarty->assign('statistic_array', $statistic_array);
$smarty->assign('total_statistic_array', $total_statistic_array);

$smarty->display('main.html');