<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `captain_id`,
               `captain_name`,
               `captain_surname`,
               `country_id`,
               `country_name`,
               `team_finance`,
               `team_name`,
               `team_price`,
               `team_price_subscribe`,
               `team_price_ticket`,
               `team_season_id`,
               `team_subscriber`,
               `vicecaptain_id`,
               `vicecaptain_name`,
               `vicecaptain_surname`
        FROM `team`
        LEFT JOIN `city`
        ON `city_id`=`team_city_id`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        LEFT JOIN
        (
            SELECT `player_id` AS `captain_id`,
                   `name_name` AS `captain_name`,
                   `surname_name` AS `captain_surname`
            FROM `player`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
        ) AS `t1`
        ON `captain_id`=`team_captain_player_id_1`
        LEFT JOIN
        (
            SELECT `player_id` AS `vicecaptain_id`,
                   `name_name` AS `vicecaptain_name`,
                   `surname_name` AS `vicecaptain_surname`
            FROM `player`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
        ) AS `t2`
        ON `vicecaptain_id`=`team_captain_player_id_2`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$num            = $get_num;
$header_title   = $team_name;

include (__DIR__ . '/view/main.php');