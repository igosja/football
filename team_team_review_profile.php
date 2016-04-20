<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `captain_country_id`,
               `captain_country_name`,
               `captain_id`,
               `captain_name`,
               `captain_surname`,
               `city_name`,
               `country_id`,
               `country_name`,
               `stadium_capacity`,
               `stadium_name`,
               `standing_place`,
               `team_name`,
               `team_season_id`,
               `tournament_id`,
               `tournament_name`,
               `user_country_id`,
               `user_country_name`,
               `user_id`,
               `user_login`,
               `vicecaptain_country_id`,
               `vicecaptain_country_name`,
               `vicecaptain_id`,
               `vicecaptain_name`,
               `vicecaptain_surname`
        FROM `team`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `stadium`
        ON `stadium_team_id`=`team_id`
        LEFT JOIN `tournament`
        ON `tournament_country_id`=`country_id`
        LEFT JOIN `standing`
        ON (`standing_tournament_id`=`tournament_id`
        AND `standing_team_id`=`team_id`)
        LEFT JOIN 
        (
            SELECT `country_id` AS `user_country_id`,
                   `country_name` AS `user_country_name`,
                   `user_id`,
                   `user_login`
            FROM `user`
            LEFT JOIN `country`
            ON `country_id`=`user_country_id`
        ) AS `t1`
        ON `user_id`=`team_user_id`
        LEFT JOIN
        (
            SELECT `country_id` AS `captain_country_id`,
                   `country_name` AS `captain_country_name`,
                   `player_id` AS `captain_id`,
                   `name_name` AS `captain_name`,
                   `surname_name` AS `captain_surname`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `country`
            ON `player_country_id`=`country_id`
        ) AS `t2`
        ON `captain_id`=`team_captain_player_id_1`
        LEFT JOIN
        (
            SELECT `country_id` AS `vicecaptain_country_id`,
                   `country_name` AS `vicecaptain_country_name`,
                   `player_id` AS `vicecaptain_id`,
                   `name_name` AS `vicecaptain_name`,
                   `surname_name` AS `vicecaptain_surname`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `country`
            ON `player_country_id`=`country_id`
        ) AS `t3`
        ON `vicecaptain_id`=`team_captain_player_id_2`
        WHERE `team_id`='$get_num'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
        AND `standing_season_id`='$igosja_season_id'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_id`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$get_num', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        WHERE (`game_home_team_id`='$get_num'
        OR `game_guest_team_id`='$get_num')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 1";
$nearest_game_sql = $mysqli->query($sql);

$nearest_game_array = $nearest_game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_home_team_id`,
               IF (`game_home_team_id`='$get_num', `game_home_score`, `game_guest_score`) AS `home_score`,
               `game_id`,
               IF (`game_home_team_id`='$get_num', `game_guest_score`, `game_home_score`) AS `guest_score`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$get_num', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        WHERE (`game_home_team_id`='$get_num'
        OR `game_guest_team_id`='$get_num')
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC
        LIMIT 5";
$latest_game_sql = $mysqli->query($sql);

$latest_game_array = $latest_game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`statisticteam_game`) AS `count_game`
        FROM `statisticteam`
        WHERE `statisticteam_team_id`='$get_num'
        AND `statisticteam_season_id`='$igosja_season_id'";
$count_game_sql = $mysqli->query($sql);

$count_game_array = $count_game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`statisticplayer_goal`) AS `goal`,
               `name_name`,
               `player_id`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_team_id`='$get_num'
        GROUP BY `statisticplayer_player_id`
        ORDER BY `statisticplayer_goal` DESC
        LIMIT 1";
$player_goal_sql = $mysqli->query($sql);

$player_goal_array = $player_goal_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               SUM(`statisticplayer_pass_scoring`) AS `pass`,
               `player_id`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_team_id`='$get_num'
        GROUP BY `statisticplayer_player_id`
        ORDER BY `statisticplayer_pass_scoring` DESC
        LIMIT 1";
$player_pass_sql = $mysqli->query($sql);

$player_pass_array = $player_pass_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`statisticplayer_best`) AS `best`,
               `name_name`,
               `player_id`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_team_id`='$get_num'
        GROUP BY `statisticplayer_player_id`
        ORDER BY `statisticplayer_best` DESC
        LIMIT 1";
$player_best_sql = $mysqli->query($sql);

$player_best_array = $player_best_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$num            = $get_num;
$header_title   = $team_name;

include (__DIR__ . '/view/main.php');