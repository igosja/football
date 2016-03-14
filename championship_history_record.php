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

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `recordtournamenttype_id`
        FROM `recordtournamenttype`
        ORDER BY `recordtournamenttype_id` ASC";
$recordtype_sql = $mysqli->query($sql);

$count_recordtype = $recordtype_sql->num_rows;

$sql = "SELECT `recordtournament_tournament_id`
        FROM `recordtournament`
        WHERE `recordtournament_tournament_id`='$get_num'
        ORDER BY `recordtournament_recordtournamenttype_id` ASC";
$record_sql = $mysqli->query($sql);

$count_record = $record_sql->num_rows;

if ($count_record != $count_recordtype)
{
    $recordtype_array = $recordtype_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_recordtype; $i++)
    {
        $recordtype_id = $recordtype_array[$i]['recordtournamenttype_id'];

        $sql = "SELECT `recordtournament_tournament_id`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$get_num'
                AND `recordtournament_recordtournamenttype_id`='$recordtype_id'";
        $check_sql = $mysqli->query($sql);

        $count_check = $check_sql->num_rows;

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_tournament_id`='$get_num',
                        `recordtournament_recordtournamenttype_id`='$recordtype_id'";
            $mysqli->query($sql);
        }
    }
}

$sql = "SELECT `game_guest_score`,
               `game_home_score`,
               `game_id`,
               `name_name`,
               `player_id`,
               `recordtournament_date_end`,
               `recordtournament_date_start`,
               `recordtournament_season_id`,
               `recordtournament_value_1`,
               `recordtournament_value_2`,
               `recordtournamenttype_name`,
               `shedule_date`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `recordtournament`
        LEFT JOIN `recordtournamenttype`
        ON `recordtournamenttype_id`=`recordtournament_recordtournamenttype_id`
        LEFT JOIN `team`
        ON `team_id`=`recordtournament_team_id`
        LEFT JOIN `game`
        ON `recordtournament_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `player`
        ON `player_id`=`recordtournament_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        WHERE `recordtournament_tournament_id`='$get_num'
        ORDER BY `recordtournamenttype_id` ASC";
$record_sql = $mysqli->query($sql);

$count_record = $record_sql->num_rows;
$record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $tournament_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');