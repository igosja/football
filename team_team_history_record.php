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

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `recordteamtype_id`
        FROM `recordteamtype`
        ORDER BY `recordteamtype_id` ASC";
$recordtype_sql = $mysqli->query($sql);

$count_recordtype = $recordtype_sql->num_rows;

$sql = "SELECT `recordteam_id`
        FROM `recordteam`
        WHERE `recordteam_team_id`='$get_num'
        ORDER BY `recordteam_recordteamtype_id` ASC";
$record_sql = $mysqli->query($sql);

$count_record = $record_sql->num_rows;

if ($count_record != $count_recordtype)
{
    $recordtype_array = $recordtype_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_recordtype; $i++)
    {
        $recordtype_id = $recordtype_array[$i]['recordteamtype_id'];

        $sql = "SELECT `recordteam_id`
                FROM `recordteam`
                WHERE `recordteam_team_id`='$get_num'
                AND `recordteam_recordteamtype_id`='$recordtype_id'";
        $check_sql = $mysqli->query($sql);

        $count_check = $check_sql->num_rows;

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `recordteam`
                    SET `recordteam_team_id`='$get_num',
                        `recordteam_recordteamtype_id`='$recordtype_id'";
            $mysqli->query($sql);
        }
    }
}

$sql = "SELECT `game_guest_score`,
               `game_home_score`,
               `game_id`,
               `name_name`,
               `player_id`,
               `recordteam_date_end`,
               `recordteam_date_start`,
               `recordteam_value`,
               `recordteamtype_name`,
               `shedule_date`,
               `surname_name`,
               `tournament_id`,
               `tournament_name`
        FROM `recordteam`
        LEFT JOIN `recordteamtype`
        ON `recordteamtype_id`=`recordteam_recordteamtype_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`recordteam_tournament_id`
        LEFT JOIN `game`
        ON `recordteam_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `player`
        ON `player_id`=`recordteam_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        WHERE `recordteam_team_id`='$get_num'
        ORDER BY `recordteamtype_id` ASC";
$record_sql = $mysqli->query($sql);

$count_record = $record_sql->num_rows;
$record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');