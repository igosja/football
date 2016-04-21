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

$sql = "SELECT `game_home_team_id`,
               `game_tournament_id`,
               `game_shedule_id`,
               `tournament_tournamenttype_id`
        FROM `game`
        LEFT JOIN `tournament`
        ON `tournament_id`=`game_tournament_id`
        WHERE `game_id`='$num_get'
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (0 == $count_game)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$home_team_id       = $game_array[0]['game_home_team_id'];
$tournamenttype_id  = $game_array[0]['tournament_tournamenttype_id'];
$tournament_id      = $game_array[0]['game_tournament_id'];
$shedule_id         = $game_array[0]['game_shedule_id'];

if (0 != $home_team_id)
{
    $team_country = 'team';
}
else
{
    $team_country = 'country';
}

$sql = "SELECT `city_name`,
               `game_guest_" . $team_country . "_id`,
               `t2`.`" . $team_country . "_name` AS `game_guest_" . $team_country . "_name`,
               `game_guest_score`,
               `game_home_" . $team_country . "_id`,
               `t1`.`" . $team_country . "_name` AS `game_home_" . $team_country . "_name`,
               `game_home_score`,
               `game_id`,
               `game_played`,
               `name_name`,
               `referee_id`,
               `shedule_date`,
               `stadium_capacity`,
               `stadium_name`,
               `stadiumquality_name`,
               `surname_name`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `" . $team_country . "` AS `t1`
        ON `game_home_" . $team_country . "_id`=`t1`.`" . $team_country . "_id`
        LEFT JOIN `" . $team_country . "` AS `t2`
        ON `game_guest_" . $team_country . "_id`=`t2`.`" . $team_country . "_id`
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `referee`
        ON `game_referee_id`=`referee_id`
        LEFT JOIN `name`
        ON `name_id`=`referee_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`referee_surname_id`
        LEFT JOIN `stadium`
        ON `game_stadium_id`=`stadium_id`
        LEFT JOIN `stadiumquality`
        ON `stadium_stadiumquality_id`=`stadiumquality_id`
        LEFT JOIN `team` AS `t3`
        ON `t3`.`team_id`=`stadium_team_id`
        LEFT JOIN `city`
        ON `city_id`=`t3`.`team_city_id`
        WHERE `game_id`='$num_get'
        LIMIT 1";

$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (0 == $count_game)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$game_played            = $game_array[0]['game_played'];
$header_2_home_id       = $game_array[0]['game_home_' . $team_country . '_id'];
$header_2_home_name     = $game_array[0]['game_home_' . $team_country . '_name'];
$header_2_guest_id      = $game_array[0]['game_guest_' . $team_country . '_id'];
$header_2_guest_name    = $game_array[0]['game_guest_' . $team_country . '_name'];

if (1 == $game_played)
{
    redirect('game_review_main.php?num=' . $num_get);
}

$header_2_score = '-';

$sql = "SELECT `statisticreferee_game`,
               `statisticreferee_red`,
               `statisticreferee_yellow`
        FROM `game`
        LEFT JOIN `statisticreferee`
        ON `game_referee_id`=`statisticreferee_referee_id`
        WHERE `game_id`='$num_get'
        AND `statisticreferee_season_id`='$igosja_season_id'
        LIMIT 1";
$referee_sql = $mysqli->query($sql);

$referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_guest_score`,
               `game_guest_" . $team_country . "_id`,
               `game_home_score`,
               `game_home_" . $team_country . "_id`,
               `game_id`,
               `guest`.`" . $team_country . "_name` AS `guest_name`,
               `home`.`" . $team_country . "_name` AS `home_name`,
               `shedule_date`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`game_tournament_id`
        LEFT JOIN `" . $team_country . "` AS `home`
        ON `home`.`" . $team_country . "_id`=`game_home_" . $team_country . "_id`
        LEFT JOIN `" . $team_country . "` AS `guest`
        ON `guest`.`" . $team_country . "_id`=`game_guest_" . $team_country . "_id`
        WHERE ((`game_home_" . $team_country . "_id`='$header_2_home_id'
        AND `game_guest_" . $team_country . "_id`='$header_2_guest_id')
        OR (`game_home_" . $team_country . "_id`='$header_2_guest_id'
        AND `game_guest_" . $team_country . "_id`='$header_2_home_id'))
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC";

$last_sql = $mysqli->query($sql);

$last_array = $last_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_id`,
               IF (`game_home_" . $team_country . "_id`='$header_2_home_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
               IF (`game_home_" . $team_country . "_id`='$header_2_home_id', `game_home_score`, `game_guest_score`) AS `home_score`,
               `shedule_date`,
               IF (`game_home_" . $team_country . "_id`='$header_2_home_id', `game_guest_" . $team_country . "_id`, `game_home_" . $team_country . "_id`) AS `" . $team_country . "_id`,
               `" . $team_country . "_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `" . $team_country . "`
        ON IF (`game_home_" . $team_country . "_id`='$header_2_home_id', `game_guest_" . $team_country . "_id`=`" . $team_country . "_id`, `game_home_" . $team_country . "_id`=`" . $team_country . "_id`)
        WHERE (`game_home_" . $team_country . "_id`='$header_2_home_id'
        OR `game_guest_" . $team_country . "_id`='$header_2_home_id')
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC
        LIMIT 5";

$home_latest_game_sql = $mysqli->query($sql);

$home_latest_game_array = $home_latest_game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT IF (`game_home_" . $team_country . "_id`='$header_2_guest_id', `game_home_score`, `game_guest_score`) AS `home_score`,
               `game_id`,
               IF (`game_home_" . $team_country . "_id`='$header_2_guest_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
               `shedule_date`,
               IF (`game_home_" . $team_country . "_id`='$header_2_guest_id', `game_guest_" . $team_country . "_id`, `game_home_" . $team_country . "_id`) AS `" . $team_country . "_id`,
               `" . $team_country . "_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `" . $team_country . "`
        ON IF (`game_home_" . $team_country . "_id`='$header_2_guest_id', `game_guest_" . $team_country . "_id`=`" . $team_country . "_id`, `game_home_" . $team_country . "_id`=`" . $team_country . "_id`)
        WHERE (`game_home_" . $team_country . "_id`='$header_2_guest_id'
        OR `game_guest_" . $team_country . "_id`='$header_2_guest_id')
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC
        LIMIT 5";

$guest_latest_game_sql = $mysqli->query($sql);

$guest_latest_game_array = $guest_latest_game_sql->fetch_all(MYSQLI_ASSOC);

if (TOURNAMENT_TYPE_WORLD_CUP == $tournamenttype_id)
{
    $sql = "SELECT `country_id`,
                   `country_name`,
                   `worldcup_place`,
                   `worldcup_point`
            FROM `worldcup`
            LEFT JOIN `game`
            ON `game_tournament_id`=`worldcup_tournament_id`
            LEFT JOIN `country`
            ON `country_id`=`worldcup_country_id`
            WHERE `worldcup_season_id`='$igosja_season_id'
            AND `game_id`='$num_get'
            ORDER BY `worldcup_place` ASC";
}
elseif (TOURNAMENT_TYPE_CHAMPIONSHIP == $tournamenttype_id)
{
    $sql = "SELECT `team_id`,
                   `team_name`,
                   `standing_place`,
                   `standing_point`
            FROM `standing`
            LEFT JOIN `game`
            ON `game_tournament_id`=`standing_tournament_id`
            LEFT JOIN `team`
            ON `team_id`=`standing_team_id`
            WHERE `standing_season_id`='$igosja_season_id'
            AND `game_id`='$num_get'
            ORDER BY `standing_place` ASC";
}
elseif (TOURNAMENT_TYPE_CUP == $tournamenttype_id)
{
    $sql = "SELECT `game_guest_team_id`,
                   `guest`.`team_name` AS `guest_team_name`,
                   `game_home_team_id`,
                   `home`.`team_name` AS `home_team_name`,
                   `stage_name`
            FROM `game`
            LEFT JOIN `stage`
            ON `stage_id`=`game_stage_id`
            LEFT JOIN `team` AS `home`
            ON `game_home_team_id`=`home`.`team_id`
            LEFT JOIN `team` AS `guest`
            ON `game_guest_team_id`=`guest`.`team_id`
            WHERE `game_shedule_id`='$shedule_id'
            AND `game_tournament_id`='$tournament_id'";
}

$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $header_2_home_name . ' ' . $header_2_score . ' ' . $header_2_guest_name;

include (__DIR__ . '/view/main.php');