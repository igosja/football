<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/only_my_team.html');
    exit;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

if (isset($_GET['game']))
{
    $game_id = (int) $_GET['game'];
}
else
{
    $sql = "SELECT `game_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE (`game_home_team_id`='$get_num'
            OR `game_guest_team_id`='$get_num')
            AND `game_played`='0'
            ORDER BY `shedule_date` ASC
            LIMIT 1";
    $game_sql = $mysqli->query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    if (isset($game_array[0]['game_id']))
    {
        $game_id = $game_array[0]['game_id'];
    }
    else
    {
        include ($_SERVER['DOCUMENT_ROOT'] . '/view/no_game.html');
        exit;
    }
}

$sql = "SELECT COUNT(`game_id`) AS `count`
        FROM `game`
        WHERE `game_id`='$game_id'
        AND (`game_home_team_id`='$get_num'
        OR `game_guest_team_id`='$get_num')";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/only_my_game.html');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT COUNT(`lineupmain_id`) AS `count`
        FROM `lineupmain`
        WHERE `lineupmain_game_id`='$game_id'
        AND `lineupmain_team_id`='$get_num'
        AND `lineupmain_formation_id`!='0'";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/lineup_first.html');
    exit;
}

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    $role_id    = (int) $data['role'];
    $lineup_id  = (int) $data['lineup_id'];

    $sql = "UPDATE `lineup`
            SET `lineup_role_id`='$role_id'
            WHERE `lineup_id`='$lineup_id'
            LIMIT 1";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_player.php?num=' . $get_num . '&game=' . $game_id);
    exit;
}

$sql = "SELECT `game_home_team_id`,
               `game_id`,
               `game_temperature`,
               `game_weather_id`,
               `lineupmain_id`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$get_num', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `lineupmain`
        ON (`lineupmain_game_id`=`game_id`
        AND `lineupmain_team_id`='$get_num')
        WHERE (`game_home_team_id`='$get_num'
        OR `game_guest_team_id`='$get_num')
        AND `game_played`='0'
        AND `lineupmain_id`>'0'
        ORDER BY `shedule_date` ASC
        LIMIT 5";
$nearest_sql = $mysqli->query($sql);

$nearest_array = $nearest_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineupmain_formation_id`
        FROM `lineupmain`
        WHERE `lineupmain_team_id`='$get_num'
        AND `lineupmain_game_id`='$game_id'
        LIMIT 1";
$lineup_sql = $mysqli->query($sql);

$lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');