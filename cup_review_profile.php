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

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

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
               `shedule_id`,
               `stage_id`,
               `stage_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `team` AS `home_team`
        ON `home_team`.`team_id`=`game_home_team_id`
        LEFT JOIN `team` AS `guest_team`
        ON `guest_team`.`team_id`=`game_guest_team_id`
        LEFT JOIN `stage`
        ON `game_stage_id`=`stage_id`
        WHERE `game_tournament_id`='$num_get'
        AND `shedule_season_id`='$igosja_season_id'
        AND `shedule_date`=
        (
            SELECT `shedule_date`
            FROM `shedule`
            LEFT JOIN `game`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`<=CURDATE()
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
                   `stage_id`,
                   `stage_name`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            LEFT JOIN `stage`
            ON `game_stage_id`=`stage_id`
            WHERE `game_tournament_id`='$num_get'
            AND `shedule_season_id`='$igosja_season_id'
            AND `shedule_date`=
            (
                SELECT `shedule_date`
                FROM `shedule`
                LEFT JOIN `game`
                ON `game_shedule_id`=`shedule_id`
                WHERE `shedule_date`>CURDATE()
                AND `game_tournament_id`='$num_get'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` ASC
                LIMIT 1
            )
            ORDER BY `game_id` ASC";
    $game_sql = $mysqli->query($sql);
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$stage_id   = $game_array[0]['stage_id'];

$sql = "SELECT `game_first_game_id`,
               `game_guest_score`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_team_id`,
               `game_id`,
               `game_played`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_name` AS `home_team_name`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `guest_team`.`team_id`=`game_guest_team_id`
        LEFT JOIN `team` AS `home_team`
        ON `home_team`.`team_id`=`game_home_team_id`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        WHERE `game_stage_id`='$stage_id'
        AND `game_tournament_id`='$num_get'
        AND `shedule_season_id`='$igosja_season_id'
        ORDER BY `game_first_game_id` ASC, `game_id` ASC";
$stage_game_sql = $mysqli->query($sql);

$count_stage_game = $stage_game_sql->num_rows;
$stage_game_array = $stage_game_sql->fetch_all(MYSQLI_ASSOC);

$stage_array = array();

for ($i=0; $i<$count_stage_game; $i++)
{
    $first_game_id  = $stage_game_array[$i]['game_first_game_id'];
    $game_played    = $stage_game_array[$i]['game_played'];
    $game_id        = $stage_game_array[$i]['game_id'];

    if (0 == $first_game_id)
    {
        $home_team_id       = $stage_game_array[$i]['game_home_team_id'];
        $home_team_name     = $stage_game_array[$i]['home_team_name'];
        $home_score_1       = $stage_game_array[$i]['game_home_score'];
        $guest_team_id      = $stage_game_array[$i]['game_guest_team_id'];
        $guest_team_name    = $stage_game_array[$i]['guest_team_name'];
        $guest_score_1      = $stage_game_array[$i]['game_guest_score'];

        $stage_array[$game_id] = array
        (
            'home_team_id' => $home_team_id,
            'home_team_name' => $home_team_name,
            'home_score_1' => $home_score_1,
            'guest_team_id' => $guest_team_id,
            'guest_team_name' => $guest_team_name,
            'guest_score_1' => $guest_score_1,
            'game_played_1' => $game_played,
            'game_id_1' => $game_id,
        );
    }
    else
    {
        $home_score_2   = $stage_game_array[$i]['game_guest_score'];
        $guest_score_2  = $stage_game_array[$i]['game_home_score'];

        $stage_array[$first_game_id]['home_score_2']    = $home_score_2;
        $stage_array[$first_game_id]['guest_score_2']   = $guest_score_2;
        $stage_array[$first_game_id]['game_played_2']   = $game_played;
        $stage_array[$first_game_id]['game_id_2']       = $game_id;
    }
}

$sql = "SELECT `cupparticipant_season_id`,
               `team_id`,
               `team_name`
        FROM `cupparticipant`
        LEFT JOIN `team`
        ON `team_id`=`cupparticipant_team_id`
        WHERE `cupparticipant_tournament_id`='$num_get'
        AND `cupparticipant_season_id`<'$igosja_season_id'
        AND `cupparticipant_out`='" . CUP_WINNER_STAGE . "'
        ORDER BY `cupparticipant_season_id` DESC
        LIMIT 4";
$winner_sql = $mysqli->query($sql);

$winner_array = $winner_sql->fetch_all(MYSQLI_ASSOC);

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
        ORDER BY `statisticplayer_goal` DESC
        LIMIT 5";
$player_goal_sql = $mysqli->query($sql);

$player_goal_array = $player_goal_sql->fetch_all(MYSQLI_ASSOC);

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
        ORDER BY `statisticplayer_pass_scoring` DESC
        LIMIT 5";
$player_pass_sql = $mysqli->query($sql);

$player_pass_array = $player_pass_sql->fetch_all(MYSQLI_ASSOC);

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
        ORDER BY `statisticplayer_mark` DESC
        LIMIT 5";
$player_mark_sql = $mysqli->query($sql);

$player_mark_array = $player_mark_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $tournament_name;
$seo_title          = $tournament_name . '. Профиль турнира. ' . $seo_title;
$seo_description    = $tournament_name . '. Профиль турнира. ' . $seo_description;
$seo_keywords       = $tournament_name . ', профиль турнира, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');