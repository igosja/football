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
            WHERE `statisticplayer_player_id`='$get_num'
            AND `statisticplayer_season_id`='$igosja_season_id'
        ) AS `t2`
        ON `player_id`=`statisticplayer_player_id`
        WHERE `player_id`='$get_num'
        LIMIT 1";
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

$attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `playerposition_value`,
               `position_coordinate_x`,
               `position_coordinate_y`,
               `position_description`,
               `position_name`
        FROM `playerposition`
        LEFT JOIN `position`
        ON `position_id`=`playerposition_position_id`
        WHERE `playerposition_player_id`='$get_num'
        ORDER BY `playerposition_value` DESC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineup_mark`
        FROM `lineup`
        LEFT JOIN `game`
        ON `lineup_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `lineup_player_id`='$get_num'
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC
        LIMIT 5";
$last_five_sql = $mysqli->query($sql);

$last_five_array = $last_five_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `disqualification_yellow`,
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
        AND `player_id`='$get_num'
        ORDER BY `disqualification_tournament_id` ASC";
$disqualification_sql = $mysqli->query($sql);

$disqualification_array = $disqualification_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('team_id', $team_id);
$smarty->assign('team_name', $team_name);
$smarty->assign('header_title', $header_2_title);
$smarty->assign('num', $get_num);
$smarty->assign('player_array', $player_array);
$smarty->assign('attribute_array', $attribute_array);
$smarty->assign('position_array', $position_array);
$smarty->assign('last_five_array', $last_five_array);
$smarty->assign('disqualification_array', $disqualification_array);

$smarty->display('main.html');