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

$sql = "SELECT `count_game`,
               `count_goal`,
               `count_pass`,
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
               `player_number`,
               `player_practice`,
               `player_price`,
               `player_salary`,
               `player_weight`,
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
        LEFT JOIN
        (
            SELECT SUM(`statisticplayer_game`) AS `count_game`,
                   SUM(`statisticplayer_goal`) AS `count_goal`,
                   SUM(`statisticplayer_pass_scoring`) AS `count_pass`,
                   `statisticplayer_player_id`
            FROM `statisticplayer`
            WHERE `statisticplayer_player_id`='$num_get'
            AND `statisticplayer_season_id`='$igosja_season_id'
        ) AS `t2`
        ON `player_id`=`statisticplayer_player_id`
        WHERE `player_id`='$num_get'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(1);

$team_id        = $player_array[0]['team_id'];
$team_name      = $player_array[0]['team_name'];
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
        WHERE `playerattribute_player_id`='$num_get'
        ORDER BY `attributechapter_id` ASC, `attribute_id` ASC";
$attribute_sql = $mysqli->query($sql);

$count_attribute = $attribute_sql->num_rows;
$attribute_array = $attribute_sql->fetch_all(1);

$sql = "SELECT `playerposition_value`,
               `position_coordinate_x`,
               `position_coordinate_y`,
               `position_description`,
               `position_name`
        FROM `playerposition`
        LEFT JOIN `position`
        ON `position_id`=`playerposition_position_id`
        WHERE `playerposition_player_id`='$num_get'
        ORDER BY `playerposition_value` DESC";
$position_sql = $mysqli->query($sql);

$count_position = $position_sql->num_rows;

if (0 == $count_position)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$position_array = $position_sql->fetch_all(1);

$sql = "SELECT `lineup_mark`
        FROM `lineup`
        LEFT JOIN `game`
        ON `lineup_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `lineup_player_id`='$num_get'
        AND `game_played`='1'
        AND (`lineup_position_id` BETWEEN '1' AND '25'
        OR `lineup_in`!='0')
        ORDER BY `shedule_date` DESC
        LIMIT 5";
$last_five_sql = $mysqli->query($sql);

$last_five_array = $last_five_sql->fetch_all(1);

$sql = "SELECT `disqualification_red`,
               `disqualification_yellow`,
               `tournament_id`,
               `tournament_name`
        FROM `player`
        LEFT JOIN `team`
        ON `team_id`=`player_team_id`
        LEFT JOIN `standing`
        ON `standing_team_id`=`team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        LEFT JOIN `disqualification`
        ON (`disqualification_tournament_id`=`tournament_id`
        AND `disqualification_player_id`=`player_id`)
        WHERE `standing_season_id`='$igosja_season_id'
        AND `player_id`='$num_get'
        ORDER BY `disqualification_tournament_id` ASC";
$disqualification_sql = $mysqli->query($sql);

$disqualification_array = $disqualification_sql->fetch_all(1);

if (isset($authorization_team_id))
{
    $sql = "SELECT COUNT(`scout_id`) AS `count`
            FROM `scout`
            WHERE `scout_player_id`='$num_get'
            AND `scout_team_id`='$authorization_team_id'";
    $scout_sql = $mysqli->query($sql);

    $scout_array = $scout_sql->fetch_all(1);
    $count_scout = $scout_array[0]['count'];
}
else
{
    $count_scout = 0;
}

$num                = $num_get;
$header_title       = $player_name . ' ' . $player_surname;
$seo_title          = $header_title . '. Профиль футболиста. ' . $seo_title;
$seo_description    = $header_title . '. Профиль футболиста. ' . $seo_description;
$seo_keywords       = $header_title . ', профиль футболиста, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');
