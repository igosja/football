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

$sql = "SELECT `country_id`,
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
        LEFT JOIN `mood`
        ON `player_mood_id`=`mood_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
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
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT `attribute_name`,
               `attributechapter_name`,
               `playerattribute_value`
        FROM `playerattribute`
        LEFT JOIN `attribute`
        ON `attribute_id`=`playerattribute_attribute_id`
        LEFT JOIN `attributechapter`
        ON `attributechapter_id`=`attribute_attributechapter_id`
        WHERE `playerattribute_player_id`='$get_num'
        ORDER BY `attributechapter_id` ASC, `attribute_id` ASC";
$attribute_sql = $mysqli->query($sql);

$count_attribute = $attribute_sql->num_rows;
$attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

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

$num            = $get_num;
$header_title   = $player_name . ' ' . $player_surname;;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');