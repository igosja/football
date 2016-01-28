<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/only_my_team.html');
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
    include($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `name_name`,
               `staff_id`,
               `staff_salary`,
               `surname_name`
        FROM `staff`
        LEFT JOIN `name`
        ON `name_id`=`staff_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`staff_surname_id`
        WHERE `staff_team_id`='$get_num'
        AND `staff_staffpost_id`='6'
        ORDER BY `staff_id` ASC";
$scout_sql = $mysqli->query($sql);

$scout_array = $scout_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT ROUND(COUNT(DISTINCT `scout_player_id`)/`count_player`*100) AS `count_scout`,
               COUNT(DISTINCT `scout_player_id`) AS `count_scout_player`,
               `country_id`,
               `country_name`
        FROM `scout`
        LEFT JOIN `player`
        ON `player_id`=`scout_player_id`
        LEFT JOIN `country`
        ON `player`.`player_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT COUNT(`player_country_id`) AS `count_player`,
                   `player_country_id`
            FROM `player`
            GROUP BY `player_country_id`
            ORDER BY `player_country_id` ASC
        ) AS `t1`
        ON `t1`.`player_country_id`=`country_id`
        LEFT JOIN `staff`
        ON `scout_team_id`=`staff_team_id`
        WHERE `staff_team_id`='$get_num'
        GROUP BY `player`.`player_country_id`
        ORDER BY `player`.`player_country_id` ASC";
$knowledge_sql = $mysqli->query($sql);

$knowledge_array = $knowledge_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');