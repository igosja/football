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

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(1);

$tournament_name = $tournament_array[0]['tournament_name'];

$today = date('Y-m-d');

$sql = "SELECT `team_id`,
               `team_name`,
               `standing_draw`,
               `standing_game`,
               `standing_loose`,
               `standing_place`,
               `standing_point`,
               `standing_win`
        FROM `standing`
        LEFT JOIN `team`
        ON `standing_team_id`=`team_id`
        WHERE `standing_tournament_id`='$num_get'
        AND `standing_season_id`='$igosja_season_id'
        ORDER BY `standing_place` ASC";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(1);

$sql = "SELECT `game_id`,
               `game_guest_score`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_team_id`,
               `game_played`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_name` AS `home_team_name`,
               `shedule_date`,
               DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
               `shedule_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `team` AS `home_team`
        ON `home_team`.`team_id`=`game_home_team_id`
        LEFT JOIN `team` AS `guest_team`
        ON `guest_team`.`team_id`=`game_guest_team_id`
        WHERE `game_tournament_id`='$num_get'
        AND `shedule_season_id`='$igosja_season_id'
        AND `shedule_date`=
        (
            SELECT `shedule_date`
            FROM `shedule`
            LEFT JOIN `game`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`<='$today'
            AND `game_tournament_id`='$num_get'
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` DESC
            LIMIT 1
        )
        ORDER BY `game_id` ASC";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (0 == $count_game)
{
    $sql = "SELECT `game_id`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_home_score`,
                   `game_home_team_id`,
                   `game_played`,
                   `guest_team`.`team_name` AS `guest_team_name`,
                   `home_team`.`team_name` AS `home_team_name`,
                   `shedule_date`,
                   DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
                   `shedule_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            WHERE `game_tournament_id`='$num_get'
            AND `shedule_season_id`='$igosja_season_id'
            AND `shedule_date`=
            (
                SELECT `shedule_date`
                FROM `shedule`
                LEFT JOIN `game`
                ON `game_shedule_id`=`shedule_id`
                WHERE `shedule_date`>'$today'
                AND `game_tournament_id`='$num_get'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` ASC
                LIMIT 1
            )
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);
}

$game_array = $game_sql->fetch_all(1);

$sql = "SELECT `standing_season_id`,
               `team_id`,
               `team_name`
        FROM `standing`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_tournament_id`='$num_get'
        AND `standing_season_id`<'$igosja_season_id'
        AND `standing_place`='1'
        ORDER BY `standing_season_id` DESC
        LIMIT 4";
$winner_sql = $mysqli->query($sql);

$winner_array = $winner_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_goal`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_goal` DESC
        LIMIT 5";
$player_goal_sql = $mysqli->query($sql);

$player_goal_array = $player_goal_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `player_id`,
               `statisticplayer_pass_scoring`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_pass_scoring` DESC
        LIMIT 5";
$player_pass_sql = $mysqli->query($sql);

$player_pass_array = $player_pass_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `player_id`,
               ROUND(`statisticplayer_mark`/`statisticplayer_game`, 2) AS `statisticplayer_mark`,
               `surname_name`
        FROM `statisticplayer`
        LEFT JOIN `player`
        ON `statisticplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `statisticplayer_tournament_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_mark` DESC
        LIMIT 5";
$player_mark_sql = $mysqli->query($sql);

$player_mark_array = $player_mark_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. ?????????????? ??????????????. ' . $seo_title;
$seo_description    = $tournament_name . '. ?????????????? ??????????????. ' . $seo_description;
$seo_keywords       = $tournament_name . ', ?????????????? ??????????????, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');