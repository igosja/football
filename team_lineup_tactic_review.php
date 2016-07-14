<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $num_get = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
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
            WHERE (`game_home_team_id`='$num_get'
            OR `game_guest_team_id`='$num_get')
            AND `game_played`='0'
            ORDER BY `shedule_date` ASC
            LIMIT 1";
    $game_sql = $mysqli->query($sql);

    $game_array = $game_sql->fetch_all(1);

    if (isset($game_array[0]['game_id']))
    {
        $game_id = $game_array[0]['game_id'];
    }
    else
    {
        include (__DIR__ . '/view/no_game.php');
        exit;
    }
}

if (isset($_GET['lineupsave_delete']))
{
    $delete = (int) $_GET['lineupsave_delete'];

    $sql = "DELETE FROM `lineupsave`
            WHERE `lineupsave_id`='$delete'
            AND `lineupsave_team_id`='$num_get'";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Схема успешно удалена.';

    redirect('team_lineup_tactic_review.php?num=' . $num_get . '&game=' . $game_id);
}

if (isset($_GET['lineupsave_load']))
{
    $load = (int) $_GET['lineupsave_load'];

    $sql = "SELECT `lineupsave_formation_id`,
                   `lineupsave_gamemood_id`,
                   `lineupsave_gamestyle_id`,
                   `lineupsave_player_id_1`,
                   `lineupsave_player_id_2`,
                   `lineupsave_player_id_3`,
                   `lineupsave_player_id_4`,
                   `lineupsave_player_id_5`,
                   `lineupsave_player_id_6`,
                   `lineupsave_player_id_7`,
                   `lineupsave_player_id_8`,
                   `lineupsave_player_id_9`,
                   `lineupsave_player_id_10`,
                   `lineupsave_player_id_11`,
                   `lineupsave_player_id_12`,
                   `lineupsave_player_id_13`,
                   `lineupsave_player_id_14`,
                   `lineupsave_player_id_15`,
                   `lineupsave_player_id_16`,
                   `lineupsave_player_id_17`,
                   `lineupsave_player_id_18`,
                   `lineupsave_position_id_1`,
                   `lineupsave_position_id_2`,
                   `lineupsave_position_id_3`,
                   `lineupsave_position_id_4`,
                   `lineupsave_position_id_5`,
                   `lineupsave_position_id_6`,
                   `lineupsave_position_id_7`,
                   `lineupsave_position_id_8`,
                   `lineupsave_position_id_9`,
                   `lineupsave_position_id_10`,
                   `lineupsave_position_id_11`,
                   `lineupsave_position_id_12`,
                   `lineupsave_position_id_13`,
                   `lineupsave_position_id_14`,
                   `lineupsave_position_id_15`,
                   `lineupsave_position_id_16`,
                   `lineupsave_position_id_17`,
                   `lineupsave_position_id_18`,
                   `lineupsave_role_id_1`,
                   `lineupsave_role_id_2`,
                   `lineupsave_role_id_3`,
                   `lineupsave_role_id_4`,
                   `lineupsave_role_id_5`,
                   `lineupsave_role_id_6`,
                   `lineupsave_role_id_7`,
                   `lineupsave_role_id_8`,
                   `lineupsave_role_id_9`,
                   `lineupsave_role_id_10`,
                   `lineupsave_role_id_11`,
                   `lineupsave_role_id_12`,
                   `lineupsave_role_id_13`,
                   `lineupsave_role_id_14`,
                   `lineupsave_role_id_15`,
                   `lineupsave_role_id_16`,
                   `lineupsave_role_id_17`,
                   `lineupsave_role_id_18`
            FROM `lineupsave`
            WHERE `lineupsave_team_id`='$num_get'
            AND `lineupsave_id`='$load'
            LIMIT 1";
    $lineupsave_sql = $mysqli->query($sql);

    $count_lineupsave = $lineupsave_sql->num_rows;

    if (0 == $count_lineupsave)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Схема сохранена неправильно. Данные загрузить не удалось.1';

        redirect('team_lineup_tactic_review.php?num=' . $num_get . '&game=' . $game_id);
    }

    $lineupsave_array = $lineupsave_sql->fetch_all(1);

    for ($i=1; $i<=18; $i++)
    {
        $player_id      = 'player_id_' . $i;
        $$player_id     = $lineupsave_array[0]['lineupsave_player_id_' . $i];
        $position_id    = 'position_id_' . $i;
        $$position_id   = $lineupsave_array[0]['lineupsave_position_id_' . $i];
        $role_id        = 'role_id_' . $i;
        $$role_id       = $lineupsave_array[0]['lineupsave_role_id_' . $i];

        $sql = "SELECT `player_team_id`
                FROM `player`
                WHERE `player_id`='" . $$player_id . "'
                LIMIT 1";
        $player_sql = $mysqli->query($sql);

        $count_player = $player_sql->num_rows;

        if (0 != $$player_id && 0 == $count_player)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'Схема сохранена неправильно. Данные загрузить не удалось.2';

            redirect('team_lineup_tactic_review.php?num=' . $num_get . '&game=' . $game_id);
        }

        $player_array = $player_sql->fetch_all(1);

        $team_id = $player_array[0]['player_team_id'];

        if (0 != $$player_id && $team_id != $num_get)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'Схема сохранена неправильно. Данные загрузить не удалось.3.';

            redirect('team_lineup_tactic_review.php?num=' . $num_get . '&game=' . $game_id);
        }
    }

    $sql = "SELECT `lineup_id`
            FROM `lineup`
            WHERE `lineup_team_id`='$num_get'
            AND `lineup_game_id`='$game_id'";
    $lineup_sql = $mysqli->query($sql);

    $count_lineup = $lineup_sql->num_rows;

    if (18 != $count_lineup)
    {
        $sql = "DELETE FROM `lineup`
                WHERE `lineup_team_id`='$num_get'
                AND lineup_game_id`='$game_id'";
        $mysqli->query($sql);

        $sql = "INSERT INTO `lineup` (`lineup_player_id`, `lineup_position_id`, `lineup_role_id`, `lineup_team_id`, `lineup_game_id`)
                VALUES ('$player_id_1', '$position_id_1', '$role_id_1', '$num_get', '$game_id'),
                       ('$player_id_2', '$position_id_2', '$role_id_2', '$num_get', '$game_id'),
                       ('$player_id_3', '$position_id_3', '$role_id_3', '$num_get', '$game_id'),
                       ('$player_id_4', '$position_id_4', '$role_id_4', '$num_get', '$game_id'),
                       ('$player_id_5', '$position_id_5', '$role_id_5', '$num_get', '$game_id'),
                       ('$player_id_6', '$position_id_6', '$role_id_6', '$num_get', '$game_id'),
                       ('$player_id_7', '$position_id_7', '$role_id_7', '$num_get', '$game_id'),
                       ('$player_id_8', '$position_id_8', '$role_id_8', '$num_get', '$game_id'),
                       ('$player_id_9', '$position_id_9', '$role_id_9', '$num_get', '$game_id'),
                       ('$player_id_10', '$position_id_10', '$role_id_10', '$num_get', '$game_id'),
                       ('$player_id_11', '$position_id_11', '$role_id_11', '$num_get', '$game_id'),
                       ('$player_id_12', '$position_id_12', '$role_id_12', '$num_get', '$game_id'),
                       ('$player_id_13', '$position_id_13', '$role_id_13', '$num_get', '$game_id'),
                       ('$player_id_14', '$position_id_14', '$role_id_14', '$num_get', '$game_id'),
                       ('$player_id_15', '$position_id_15', '$role_id_15', '$num_get', '$game_id'),
                       ('$player_id_16', '$position_id_16', '$role_id_16', '$num_get', '$game_id'),
                       ('$player_id_17', '$position_id_17', '$role_id_17', '$num_get', '$game_id'),
                       ('$player_id_18', '$position_id_18', '$role_id_18', '$num_get', '$game_id');";
        $mysqli->query($sql);
    }
    else
    {
        for ($i=0; $i<18; $i++)
        {
            $player_id      = 'player_id_' . ($i + 1);
            $position_id    = 'position_id_' . ($i + 1);
            $role_id        = 'role_id_' . ($i + 1);
            $offset         = $i;

            $sql = "UPDATE `lineup`
                    SET `lineup_player_id`='" . $$player_id . "',
                        `lineup_position_id`='" . $$position_id . "',
                        `lineup_role_id`='" . $$role_id . "'
                    WHERE `lineup_team_id`='$num_get'
                    AND lineup_game_id`='$game_id'
                    LIMIT $offset, 1";
            $mysqli->query($sql);
        }
    }

    $formation_id   = $lineupsave_array[0]['lineupsave_formation_id'];
    $gamemood_id    = $lineupsave_array[0]['lineupsave_gamemood_id'];
    $gamestyle_id   = $lineupsave_array[0]['lineupsave_gamestyle_id'];

    $sql = "SELECT COUNT(`lineupmain_id`) AS `count`
            FROM `lineupmain`
            WHERE `lineupmain_game_id`='$game_id'
            AND `lineupmain_team_id`='$num_get'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(1);

    $count_lineup = $count_array[0]['count'];

    if (0 == $count_lineup)
    {
        $sql = "INSERT INTO `lineupmain`
                SET `lineupmain_formation_id`='$formation_id',
                    `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id',
                    `lineupmain_team_id`='$num_get',
                    `lineupmain_game_id`='$game_id'";
    }
    else
    {
        $sql = "UPDATE `lineupmain`
                SET `lineupmain_formation_id`='$formation_id',
                    `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id'
                WHERE `lineupmain_team_id`='$num_get'
                AND `lineupmain_game_id`='$game_id'
                LIMIT 1";
    }

    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_review.php?num=' . $num_get . '&game=' . $game_id);
}

$sql = "SELECT COUNT(`game_id`) AS `count`
        FROM `game`
        WHERE `game_id`='$game_id'
        AND (`game_home_team_id`='$num_get'
        OR `game_guest_team_id`='$num_get')";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(1);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    include (__DIR__ . '/view/only_my_game.php');
    exit;
}

$team_array = $team_sql->fetch_all(1);

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
                        `lineup_team_id`='$num_get',
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
            AND `lineupmain_team_id`='$num_get'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(1);

    $count_lineup = $count_array[0]['count'];

    if (0 == $count_lineup)
    {
        $sql = "INSERT INTO `lineupmain`
                SET `lineupmain_formation_id`='$formation_id',
                    `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id',
                    `lineupmain_team_id`='$num_get',
                    `lineupmain_game_id`='$game_id'";
    }
    else
    {
        $sql = "UPDATE `lineupmain`
                SET `lineupmain_formation_id`='$formation_id',
                    `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id'
                WHERE `lineupmain_team_id`='$num_get'
                AND `lineupmain_game_id`='$game_id'
                LIMIT 1";
    }

    $mysqli->query($sql);

    if (1 == $data['save'])
    {
        $save_name = $data['save_name'];

        $sql = "INSERT INTO `lineupsave`
                SET `lineupsave_date`=UNIX_TIMESTAMP(),
                    `lineupsave_formation_id`='$formation_id',
                    `lineupsave_gamemood_id`='$gamemood_id',
                    `lineupsave_gamestyle_id`='$gamestyle_id',
                    `lineupsave_name`=?,
                    `lineupsave_player_id_1`='$lineup_player_id_1',
                    `lineupsave_player_id_2`='$lineup_player_id_2',
                    `lineupsave_player_id_3`='$lineup_player_id_3',
                    `lineupsave_player_id_4`='$lineup_player_id_4',
                    `lineupsave_player_id_5`='$lineup_player_id_5',
                    `lineupsave_player_id_6`='$lineup_player_id_6',
                    `lineupsave_player_id_7`='$lineup_player_id_7',
                    `lineupsave_player_id_8`='$lineup_player_id_8',
                    `lineupsave_player_id_9`='$lineup_player_id_9',
                    `lineupsave_player_id_10`='$lineup_player_id_10',
                    `lineupsave_player_id_11`='$lineup_player_id_11',
                    `lineupsave_player_id_12`='$lineup_player_id_12',
                    `lineupsave_player_id_13`='$lineup_player_id_13',
                    `lineupsave_player_id_14`='$lineup_player_id_14',
                    `lineupsave_player_id_15`='$lineup_player_id_15',
                    `lineupsave_player_id_16`='$lineup_player_id_16',
                    `lineupsave_player_id_17`='$lineup_player_id_17',
                    `lineupsave_player_id_18`='$lineup_player_id_18',
                    `lineupsave_position_id_1`='$lineup_position_id_1',
                    `lineupsave_position_id_2`='$lineup_position_id_2',
                    `lineupsave_position_id_3`='$lineup_position_id_3',
                    `lineupsave_position_id_4`='$lineup_position_id_4',
                    `lineupsave_position_id_5`='$lineup_position_id_5',
                    `lineupsave_position_id_6`='$lineup_position_id_6',
                    `lineupsave_position_id_7`='$lineup_position_id_7',
                    `lineupsave_position_id_8`='$lineup_position_id_8',
                    `lineupsave_position_id_9`='$lineup_position_id_9',
                    `lineupsave_position_id_10`='$lineup_position_id_10',
                    `lineupsave_position_id_11`='$lineup_position_id_11',
                    `lineupsave_position_id_12`='$lineup_position_id_12',
                    `lineupsave_position_id_13`='$lineup_position_id_13',
                    `lineupsave_position_id_14`='$lineup_position_id_14',
                    `lineupsave_position_id_15`='$lineup_position_id_15',
                    `lineupsave_position_id_16`='$lineup_position_id_16',
                    `lineupsave_position_id_17`='$lineup_position_id_17',
                    `lineupsave_position_id_18`='$lineup_position_id_18',
                    `lineupsave_role_id_1`='$lineup_role_id_1',
                    `lineupsave_role_id_2`='$lineup_role_id_2',
                    `lineupsave_role_id_3`='$lineup_role_id_3',
                    `lineupsave_role_id_4`='$lineup_role_id_4',
                    `lineupsave_role_id_5`='$lineup_role_id_5',
                    `lineupsave_role_id_6`='$lineup_role_id_6',
                    `lineupsave_role_id_7`='$lineup_role_id_7',
                    `lineupsave_role_id_8`='$lineup_role_id_8',
                    `lineupsave_role_id_9`='$lineup_role_id_9',
                    `lineupsave_role_id_10`='$lineup_role_id_10',
                    `lineupsave_role_id_11`='$lineup_role_id_11',
                    `lineupsave_role_id_12`='$lineup_role_id_12',
                    `lineupsave_role_id_13`='$lineup_role_id_13',
                    `lineupsave_role_id_14`='$lineup_role_id_14',
                    `lineupsave_role_id_15`='$lineup_role_id_15',
                    `lineupsave_role_id_16`='$lineup_role_id_16',
                    `lineupsave_role_id_17`='$lineup_role_id_17',
                    `lineupsave_role_id_18`='$lineup_role_id_18',
                    `lineupsave_team_id`='$num_get'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $save_name);
        $prepare->execute();
        $prepare->close();
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_review.php?num=' . $num_get . '&game=' . $game_id);
}

$sql = "SELECT `game_tournament_id`
        FROM `game`
        WHERE `game_id`='$game_id'
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(1);

$tourname_id = $game_array[0]['game_tournament_id'];

$sql = "SELECT `game_id`
        FROM `game`
        WHERE `game_tournament_id`='$tourname_id'
        AND `game_played`='0'
        AND (`game_home_team_id`='$num_get'
        OR `game_guest_team_id`='$num_get')
        ORDER BY `game_id` ASC
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(1);

$check_game_id = $game_array[0]['game_id'];

if ($check_game_id == $game_id)
{
    $disqualification_show = 1;
}
else
{
    $disqualification_show = 0;
}

$sql = "SELECT `game_home_team_id`,
               `game_id`,
               `game_temperature`,
               `lineupmain_id`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `weather_id`,
               `weather_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$num_get', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `weather`
        ON `weather_id`=`game_weather_id`
        LEFT JOIN `lineupmain`
        ON (`lineupmain_game_id`=`game_id`
        AND `lineupmain_team_id`='$num_get')
        WHERE (`game_home_team_id`='$num_get'
        OR `game_guest_team_id`='$num_get')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 5";
$nearest_sql = $mysqli->query($sql);

$nearest_array = $nearest_sql->fetch_all(1);

$sql = "SELECT `disqualification_player_id`,
               `name_name`,
               `player_condition`,
               `player_id`,
               `player_national_id`,
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
        LEFT JOIN
        (
            SELECT `disqualification_player_id`
            FROM `disqualification`
            WHERE `disqualification_tournament_id`=
            (
                SELECT `game_tournament_id`
                FROM `game`
                WHERE `game_id`='$game_id'
            )
            AND (`disqualification_red`>'0'
            OR `disqualification_yellow`>'1')
        ) AS `t1`
        ON `player_id`=`disqualification_player_id`
        WHERE `team_id`='$num_get'
        ORDER BY `position_id` ASC, `player_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(1);

$sql = "SELECT `formation_id`, `formation_name`
        FROM `formation`
        ORDER BY `formation_id` ASC";
$formation_sql = $mysqli->query($sql);

$formation_array = $formation_sql->fetch_all(1);

$sql = "SELECT `gamemood_id`, `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(1);

$sql = "SELECT `gamestyle_id`, `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(1);

$sql = "SELECT `lineupmain_formation_id`,
               `lineupmain_gamemood_id`,
               `lineupmain_gamestyle_id`
        FROM `lineupmain`
        WHERE `lineupmain_team_id`='$num_get'
        AND `lineupmain_game_id`='$game_id'
        LIMIT 1";
$lineupmain_sql = $mysqli->query($sql);

$lineupmain_array = $lineupmain_sql->fetch_all(1);

$sql = "SELECT `lineup_id`,
               `lineup_player_id`,
               `lineup_position_id`,
               `lineup_role_id`
        FROM `lineup`
        WHERE `lineup_team_id`='$num_get'
        AND `lineup_game_id`='$game_id'
        ORDER BY `lineup_id` ASC";
$lineup_sql = $mysqli->query($sql);

$count_lineup = $lineup_sql->num_rows;
$lineup_array = $lineup_sql->fetch_all(1);

$sql = "SELECT `lineupsave_id`,
               `lineupsave_date`,
               `lineupsave_name`
        FROM `lineupsave`
        WHERE `lineupsave_team_id`='$num_get'
        ORDER BY `lineupsave_id` DESC";
$lineupsave_sql = $mysqli->query($sql);

$lineupsave_array = $lineupsave_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Выбор тактической схемы. ' . $seo_title;
$seo_description    = $header_title . '. Выбор тактической схемы. ' . $seo_description;
$seo_keywords       = $header_title . ', выбор тактической схемы, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');