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

if (isset($_GET['stage']))
{
    $stage_id = (int) $_GET['stage'];
}
else
{
    $sql = "SELECT `game_stage_id`
            FROM `shedule`
            LEFT JOIN `game`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_date`<=CURDATE()
            AND `game_tournament_id`='$num_get'
            AND `shedule_season_id`='$igosja_season_id'
            ORDER BY `shedule_date` DESC
            LIMIT 1";
    $stage_sql = $mysqli->query($sql);

    $count_stage = $stage_sql->num_rows;

    if (0 == $count_stage)
    {
        $sql = "SELECT `game_stage_id`
                FROM `shedule`
                LEFT JOIN `game`
                ON `game_shedule_id`=`shedule_id`
                WHERE `shedule_date`>CURDATE()
                AND `game_tournament_id`='$num_get'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` ASC
                LIMIT 1";
        $stage_sql = $mysqli->query($sql);
    }

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    if (isset($stage_sql[0]['game_stage_id']))
    {
        $stage_id = $stage_sql[0]['game_stage_id'];
    }
    else
    {
        $stage_id = 0;
    }
}

if (39 <= $stage_id)
{
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

    $game_array = array();

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

            $game_array[$game_id] = array
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

            $game_array[$first_game_id]['home_score_2']    = $home_score_2;
            $game_array[$first_game_id]['guest_score_2']   = $guest_score_2;
            $game_array[$first_game_id]['game_played_2']   = $game_played;
            $game_array[$first_game_id]['game_id_2']       = $game_id;
        }
    }
}
else
{
    $sql = "SELECT `city_name`,
                   `country_name`,
                   `league_score`-`league_pass` AS `league_difference`,
                   `league_draw`,
                   `league_game`,
                   `league_place`,
                   `league_group`,
                   `league_loose`,
                   `league_pass`,
                   `league_point`,
                   `league_score`,
                   `league_win`,
                   `team_id`,
                   `team_name`
            FROM `league`
            LEFT JOIN `team`
            ON `league_team_id`=`team_id`
            LEFT JOIN `city`
            ON `city_id`=`team_city_id`
            LEFT JOIN `country`
            ON `country_id`=`city_country_id`
            WHERE `league_season_id`='$igosja_season_id'
            ORDER BY `league_group` ASC, `league_place` ASC";
    $league_sql = $mysqli->query($sql);

    $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);
}

$sql = "SELECT `stage_id`,
               `stage_name`
        FROM `game`
        LEFT JOIN `stage`
        ON `game_stage_id`=`stage_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$num_get'
        AND `shedule_season_id`='$igosja_season_id'
        AND `game_stage_id` BETWEEN '39' AND '42'
        GROUP BY `stage_id`
        ORDER BY `shedule_date` ASC";
$stage_1_sql = $mysqli->query($sql);

$stage_1_array = $stage_1_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_id`,
               `stage_name`
        FROM `game`
        LEFT JOIN `stage`
        ON `game_stage_id`=`stage_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$num_get'
        AND `shedule_season_id`='$igosja_season_id'
        AND `game_stage_id` BETWEEN '1' AND '6'
        GROUP BY `stage_id`
        ORDER BY `shedule_date` ASC";
$stage_2_sql = $mysqli->query($sql);

$count_stage_2 = $stage_2_sql->num_rows;

if (0 == $count_stage_2)
{
    $stage_2_array = array();
}
else
{
    $stage_2_array = array(array('stage_id' => 1, 'stage_name' => 'Групповой этап'));
}

$sql = "SELECT `stage_id`,
               `stage_name`
        FROM `game`
        LEFT JOIN `stage`
        ON `game_stage_id`=`stage_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$num_get'
        AND `shedule_season_id`='$igosja_season_id'
        AND `game_stage_id` BETWEEN '43' AND '49'
        GROUP BY `stage_id`
        ORDER BY `shedule_date` ASC";
$stage_3_sql = $mysqli->query($sql);

$stage_3_array = $stage_3_sql->fetch_all(MYSQLI_ASSOC);

$stage_array = array_merge($stage_1_array, $stage_2_array, $stage_3_array);

$num            = $num_get;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');