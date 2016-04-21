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

$today = date('Y-m-d');

$standing_array = array();

$sql = "SELECT `game_first_game_id`,
               `game_guest_score`,
               `game_guest_shoot_out`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_shoot_out`,
               `game_home_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_name` AS `home_team_name`,
               `shedule_season_id`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `guest_team`.`team_id`=`game_guest_team_id`
        LEFT JOIN `team` AS `home_team`
        ON `home_team`.`team_id`=`game_home_team_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$num_get'
        AND `shedule_season_id`<'$igosja_season_id'
        AND `game_stage_id`='" . CUP_FINAL_STAGE . "'
        ORDER BY `shedule_season_id` DESC, `game_first_game_id` ASC
        LIMIT 8";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;
$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$final_game_array   = array();
$winner_array       = array();

for ($i=0; $i<$count_game; $i++)
{
    $first_game_id  = $game_array[$i]['game_first_game_id'];
    $season_id      = $game_array[$i]['shedule_season_id'];

    if (0 == $first_game_id)
    {
        $home_team_id       = $game_array[$i]['game_home_team_id'];
        $home_team_name     = $game_array[$i]['home_team_name'];
        $home_score_1       = $game_array[$i]['game_home_score'] + $game_array[$i]['game_home_shoot_out'];
        $guest_team_id      = $game_array[$i]['game_guest_team_id'];
        $guest_team_name    = $game_array[$i]['guest_team_name'];
        $guest_score_1      = $game_array[$i]['game_guest_score'] + $game_array[$i]['game_guest_shoot_out'];

        $final_game_array[$season_id] = array
        (
            'home_team_id'          => $home_team_id,
            'home_team_name'        => $home_team_name,
            'home_score_1'          => $home_score_1,
            'guest_team_id'         => $guest_team_id,
            'guest_team_name'       => $guest_team_name,
            'guest_score_1'         => $guest_score_1,
            'season_id'             => $season_id,
        );
    }
    else
    {
        $home_score_2   = $game_array[$i]['game_guest_score'] + $game_array[$i]['game_guest_shoot_out'];;
        $guest_score_2  = $game_array[$i]['game_home_score'] + $game_array[$i]['game_home_shoot_out'];;

        $final_game_array[$season_id]['home_score_2']   = $home_score_2;
        $final_game_array[$season_id]['guest_score_2']  = $guest_score_2;
    }
}

foreach ($final_game_array as $item)
{
    $home_score     = $item['home_score_1'] + $item['home_score_2'];
    $guest_score    = $item['guest_score_1'] + $item['guest_score_2'];
    $season_id      = $item['season_id'];

    if ($home_score > $guest_score)
    {
        $winner_id          = $item['home_team_id'];
        $winner_name        = $item['home_team_name'];
    }
    else
    {
        $winner_id          = $item['guest_team_id'];
        $winner_name        = $item['guest_team_name'];
    }

    $winner_array[] = array
    (
        'standing_season_id'    => $season_id,
        'team_id'               => $winner_id,
        'team_name'             => $winner_name,
    );
}

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

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

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
        AND `statisticplayer_season_id`='$igosja_season_id'
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
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_mark` DESC
        LIMIT 5";
$player_mark_sql = $mysqli->query($sql);

$player_mark_array = $player_mark_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');