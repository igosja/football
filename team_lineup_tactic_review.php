<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/only_my_team.php');
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
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
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
        include ($_SERVER['DOCUMENT_ROOT'] . '/view/no_game.php');
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
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/only_my_game.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    $formation_id   = (int) $data['formation_id'];
    $gamemood_id    = (int) $data['gamemood_id'];
    $gamestyle_id   = (int) $data['gamestyle_id'];

    for ($i=1; $i<=18; $i++)
    {
        $lineup     = 'lineup_' . $i;
        $$lineup    = (int) $data['lineup_' . $i];
        $player     = 'lineup_player_id_' . $i;
        $$player    = (int) $data['player_' . $i];
        $position   = 'lineup_position_id_' . $i;
        $$position  = (int) $data['position_' . $i];
        $role       = 'lineup_role_id_' . $i;
        $$role      = (int) $data['role_' . $i];

        $sql = "SELECT `lineup_id`
                FROM `lineup`
                WHERE `lineup_id`='" . $$lineup . "'
                LIMIT 1";
        $lineup_sql = $mysqli->query($sql);

        $count_lineup = $lineup_sql->num_rows;

        if (0 == $count_lineup)
        {
            $sql = "INSERT INTO `lineup`
                    SET `lineup_player_id`='" . $$player . "',
                        `lineup_position_id`='" . $$position . "',
                        `lineup_role_id`='" . $$role . "',
                        `lineup_team_id`='$get_num',
                        `lineup_game_id`='$game_id'";
        }
        else
        {
            $sql = "UPDATE `lineup`
                    SET `lineup_player_id`='" . $$player . "',
                        `lineup_position_id`='" . $$position . "',
                        `lineup_role_id`='" . $$role . "'
                    WHERE `lineup_id`='" . $$lineup . "'
                    LIMIT 1";
        }

        $mysqli->query($sql);
    }

    $sql = "SELECT COUNT(`lineupmain_id`) AS `count`
            FROM `lineupmain`
            WHERE `lineupmain_game_id`='$game_id'
            AND `lineupmain_team_id`='$get_num'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

    $count_lineup = $count_array[0]['count'];

    if (0 == $count_lineup)
    {
        $sql = "INSERT INTO `lineupmain`
                SET `lineupmain_formation_id`='$formation_id',
                    `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id',
                    `lineupmain_team_id`='$get_num',
                    `lineupmain_game_id`='$game_id'";
    }
    else
    {
        $sql = "UPDATE `lineupmain`
                SET `lineupmain_formation_id`='$formation_id',
                    `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id'
                WHERE `lineupmain_team_id`='$get_num'
                AND `lineupmain_game_id`='$game_id'
                LIMIT 1";
    }

    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_review.php?num=' . $get_num . '&game=' . $game_id);
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
        ORDER BY `shedule_date` ASC
        LIMIT 5";
$nearest_sql = $mysqli->query($sql);

$nearest_array = $nearest_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_condition`,
               `player_id`,
               `player_practice`,
               `position_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `team_id`='$get_num'
        ORDER BY `position_id` ASC, `player_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `formation_id`, `formation_name`
        FROM `formation`
        ORDER BY `formation_id` ASC";
$formation_sql = $mysqli->query($sql);

$formation_array = $formation_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamemood_id`, `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamestyle_id`, `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineupmain_formation_id`,
               `lineupmain_gamemood_id`,
               `lineupmain_gamestyle_id`
        FROM `lineupmain`
        WHERE `lineupmain_team_id`='$get_num'
        AND `lineupmain_game_id`='$game_id'
        LIMIT 1";
$lineupmain_sql = $mysqli->query($sql);

$lineupmain_array = $lineupmain_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineup_id`,
               `lineup_player_id`,
               `lineup_position_id`,
               `lineup_role_id`
        FROM `lineup`
        WHERE `lineup_team_id`='$get_num'
        AND `lineup_game_id`='$game_id'
        ORDER BY `lineup_id` ASC";
$lineup_sql = $mysqli->query($sql);

$count_lineup = $lineup_sql->num_rows;
$lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');