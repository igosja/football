<?php

include ('include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `country_name`, `country_season_id`, `stadium_name`, `stadium_capacity`
        FROM `country` AS `t1`
        LEFT JOIN 
        (
            SELECT `stadium_name`, `stadium_capacity`, `city_country_id`
            FROM `stadium`
            LEFT JOIN `team`
            ON `team_id`=`stadium_team_id`
            LEFT JOIN `city`
            ON `city_id`=`team_city_id`
            WHERE `city_country_id`='$get_num'
            ORDER BY `stadium_capacity` DESC
            LIMIT 1
        ) AS `t2`
        ON `t1`.`country_id`=`t2`.`city_country_id`
        WHERE `country_id`='$get_num'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    $smarty->display('wrong_page.html');

    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `team_id`, `team_name`, `country_id`, `country_name`
        FROM `team`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `country_id`='$get_num'
        AND `team_id`!='0'";
$team_sql = $mysqli->query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `player_id`, `name_name`, `surname_name`, `team_id`, `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `country_id`='$get_num'
        AND `team_id`!='0'
        LIMIT 7";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_2_title', $country_name);
$smarty->assign('country_id', $get_num);
$smarty->assign('top_team_array', $team_array);
$smarty->assign('top_player_array', $player_array);
$smarty->assign('country_array', $country_array);

$smarty->display('main.html');