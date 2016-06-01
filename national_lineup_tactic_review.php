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

$sql = "SELECT COUNT(`game_id`) AS `count`
        FROM `game`
        WHERE `game_id`='$game_id'
        AND (`game_home_country_id`='$num_get'
        OR `game_guest_country_id`='$num_get')";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(1);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    include (__DIR__ . '/view/only_my_game.php');
    exit;
}

$country_array = $country_sql->fetch_all(1);

$country_name = $country_array[0]['country_name'];

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
                        `lineup_country_id`='$num_get',
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
            AND `lineupmain_country_id`='$num_get'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(1);

    $count_lineup = $count_array[0]['count'];

    if (0 == $count_lineup)
    {
        $sql = "INSERT INTO `lineupmain`
                SET `lineupmain_formation_id`='$formation_id',
                    `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id',
                    `lineupmain_country_id`='$num_get',
                    `lineupmain_game_id`='$game_id'";
    }
    else
    {
        $sql = "UPDATE `lineupmain`
                SET `lineupmain_formation_id`='$formation_id',
                    `lineupmain_gamemood_id`='$gamemood_id',
                    `lineupmain_gamestyle_id`='$gamestyle_id'
                WHERE `lineupmain_country_id`='$num_get'
                AND `lineupmain_game_id`='$game_id'
                LIMIT 1";
    }

    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('national_lineup_tactic_review.php?num=' . $num_get . '&game=' . $game_id);
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

$nearest_array = $nearest_sql->fetch_all(1);

$sql = "SELECT `disqualification_player_id`,
               `name_name`,
               `player_condition`,
               `player_id`,
               `player_practice`,
               `position_name`,
               `surname_name`,
               `country_id`,
               `country_name`
        FROM `player`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_national_id`=`country_id`
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
        WHERE `country_id`='$num_get'
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
        WHERE `lineupmain_country_id`='$num_get'
        AND `lineupmain_game_id`='$game_id'
        LIMIT 1";
$lineupmain_sql = $mysqli->query($sql);

$lineupmain_array = $lineupmain_sql->fetch_all(1);

$sql = "SELECT `lineup_id`,
               `lineup_player_id`,
               `lineup_position_id`,
               `lineup_role_id`
        FROM `lineup`
        WHERE `lineup_country_id`='$num_get'
        AND `lineup_game_id`='$game_id'
        ORDER BY `lineup_id` ASC";
$lineup_sql = $mysqli->query($sql);

$count_lineup = $lineup_sql->num_rows;
$lineup_array = $lineup_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $country_name;
$seo_title          = $header_title . '. Выбор тактической схемы. ' . $seo_title;
$seo_description    = $header_title . '. Выбор тактической схемы. ' . $seo_description;
$seo_keywords       = $header_title . ', выбор тактической схемы, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');