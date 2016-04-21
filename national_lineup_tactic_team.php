<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_country_id))
{
    $num_get = $authorization_country_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
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
            WHERE (`game_home_country_id`='$num_get'
            OR `game_guest_country_id`='$num_get')
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
        include (__DIR__ . '/view/no_game.php');
        exit;
    }
}

$sql = "SELECT COUNT(`game_id`) AS `count`
        FROM `game`
        WHERE `game_id`='$game_id'
        AND (`game_home_country_id`='$num_get'
        OR `game_guest_country_id`='$num_get')";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    include (__DIR__ . '/view/only_my_game.php');
    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    $gamemood_id  = (int) $data['gamemood'];
    $gamestyle_id = (int) $data['gamestyle'];

    $sql = "SELECT COUNT(`lineupmain_id`) AS `count`
            FROM `lineupmain`
            WHERE `lineupmain_game_id`='$game_id'
            AND `lineupmain_country_id`='$num_get'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

    $count_lineup = $count_array[0]['count'];

    if (0 == $count_lineup)
    {
        $sql = "INSERT INTO `lineupmain`
                SET `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id',
                    `lineupmain_country_id`='$num_get',
                    `lineupmain_game_id`='$game_id'";
    }
    else
    {
        $sql = "UPDATE `lineupmain`
                SET `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id'
                WHERE `lineupmain_country_id`='$num_get'
                AND `lineupmain_game_id`='$game_id'
                LIMIT 1";
    }

    $mysqli->query($sql);

    $sql = "UPDATE `teaminstruction`
            SET `teaminstruction_status`='0'
            WHERE `teaminstruction_country_id`='$num_get'
            AND `teaminstruction_game_id`='$game_id'";
    $mysqli->query($sql);

    foreach ($data['instruction'] as $item)
    {
        $instruction_id = (int) $item;

        $sql = "SELECT `teaminstruction_id`
                FROM `teaminstruction`
                WHERE `teaminstruction_country_id`='$authorization_country_id'
                AND `teaminstruction_instruction_id`='$instruction_id'
                AND `teaminstruction_game_id`='$game_id'
                LIMIT 1";
        $teaminstruction_sql = $mysqli->query($sql);

        $count_teaminstruction = $teaminstruction_sql->num_rows;

        if (0 == $count_teaminstruction)
        {
            $sql = "INSERT INTO `teaminstruction`
                    SET `teaminstruction_country_id`='$authorization_country_id',
                        `teaminstruction_instruction_id`='$instruction_id',
                        `teaminstruction_game_id`='$game_id'";
            $mysqli->query($sql);
        }
        else
        {
            $teaminstruction_array = $teaminstruction_sql->fetch_all(MYSQLI_ASSOC);

            $teaminstruction_id = $teaminstruction_array[0]['teaminstruction_id'];

            $sql = "UPDATE `teaminstruction`
                    SET `teaminstruction_status`='1'
                    WHERE `teaminstruction_id`='$teaminstruction_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('national_lineup_tactic_team.php?num=' . $num_get . '&game=' . $game_id);
}

$sql = "SELECT `game_home_country_id`,
               `game_id`,
               `game_temperature`,
               `lineupmain_id`,
               `shedule_date`,
               `country_id`,
               `country_name`,
               `tournament_id`,
               `tournament_name`,
               `weather_id`,
               `weather_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `country`
        ON IF (`game_home_country_id`='$num_get', `game_guest_country_id`=`country_id`, `game_home_country_id`=`country_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `weather`
        ON `weather_id`=`game_weather_id`
        LEFT JOIN `lineupmain`
        ON (`lineupmain_game_id`=`game_id`
        AND `lineupmain_country_id`='$num_get')
        WHERE (`game_home_country_id`='$num_get'
        OR `game_guest_country_id`='$num_get')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 5";
$nearest_sql = $mysqli->query($sql);

$nearest_array = $nearest_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamestyle_description`,
               `gamestyle_id`,
               `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamemood_description`,
               `gamemood_id`,
               `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineupmain_gamemood_id`,
               `lineupmain_gamestyle_id`
        FROM `lineupmain`
        WHERE `lineupmain_country_id`='$num_get'
        AND `lineupmain_game_id`='$game_id'
        LIMIT 1";
$lineup_sql = $mysqli->query($sql);

$lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `instruction_id`,
               `instruction_name`,
               `instructionchapter_id`,
               `instructionchapter_name`
        FROM `instruction`
        LEFT JOIN `instructionchapter`
        ON `instruction_instructionchapter_id`=`instructionchapter_id`
        ORDER BY `instructionchapter_id` ASC, `instruction_id` ASC";
$instruction_sql = $mysqli->query($sql);

$count_instruction = $instruction_sql->num_rows;
$instruction_array = $instruction_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `teaminstruction_instruction_id`
        FROM `teaminstruction`
        WHERE `teaminstruction_country_id`='$num_get'
        AND `teaminstruction_status`='1'
        AND `teaminstruction_game_id`='$game_id'
        ORDER BY `teaminstruction_instruction_id` ASC";
$teaminstruction_sql = $mysqli->query($sql);

$teaminstruction_array = $teaminstruction_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $country_name;

include (__DIR__ . '/view/main.php');