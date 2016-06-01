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

$sql = "SELECT COUNT(`lineupmain_id`) AS `count`
        FROM `lineupmain`
        WHERE `lineupmain_game_id`='$game_id'
        AND `lineupmain_country_id`='$num_get'
        AND `lineupmain_formation_id`!='0'";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(1);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    include (__DIR__ . '/view/lineup_first.php');
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

    redirect('national_lineup_tactic_player.php?num=' . $num_get . '&game=' . $game_id);
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
        AND `lineupmain_id`>'0'
        ORDER BY `shedule_date` ASC
        LIMIT 5";
$nearest_sql = $mysqli->query($sql);

$nearest_array = $nearest_sql->fetch_all(1);

$sql = "SELECT `lineupmain_formation_id`
        FROM `lineupmain`
        WHERE `lineupmain_country_id`='$num_get'
        AND `lineupmain_game_id`='$game_id'
        LIMIT 1";
$lineup_sql = $mysqli->query($sql);

$lineup_array = $lineup_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $country_name;
$seo_title          = $header_title . '. Выбор роли игрока. ' . $seo_title;
$seo_description    = $header_title . '. Выбор роли игрока. ' . $seo_description;
$seo_keywords       = $header_title . ', выбор роли игрока, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');