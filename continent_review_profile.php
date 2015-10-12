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

$sql = "SELECT `continent_name`
        FROM `continent`
        WHERE `continent_id`='$get_num'
        LIMIT 1";
$continent_sql = $mysqli->query($sql);

$count_continent = $continent_sql->num_rows;

if (0 == $count_continent)
{
    $smarty->display('wrong_page.html');

    exit;
}

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$continent_name = $continent_array[0]['continent_name'];

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `team_id`,
               `team_name`,
               `country_id`,
               `country_name`
        FROM `team`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `country_continent_id`='$get_num'
        AND `team_id`!='0'
        ORDER BY `team_reputation` DESC
        LIMIT 10";
$team_sql = $mysqli->query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_team`";
$count_team = $mysqli->query($sql);
$count_team = $count_team->fetch_all(MYSQLI_ASSOC);
$count_team = $count_team[0]['count_team'];

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `country_id`,
               `country_name`,
               `ratingcountry_position`
        FROM `country`
        CROSS JOIN `ratingcountry`
        ON `ratingcountry_country_id`=`country_id`
        ORDER BY `ratingcountry_position` ASC
        LIMIT 10";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_country`";
$count_country = $mysqli->query($sql);
$count_country = $count_country->fetch_all(MYSQLI_ASSOC);
$count_country = $count_country[0]['count_country'];

$sql = "SELECT `name_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`
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
        WHERE `country_continent_id`='$get_num'
        AND `team_id`!='0'
        ORDER BY `player_reputation` DESC
        LIMIT 10";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `buyer`.`team_id` AS `buyer_id`,
               `buyer`.`team_name` AS `buyer_name`,
               `name_name`,
               `player_id`,
               `seller`.`team_id` AS `seller_id`,
               `seller`.`team_name` AS `seller_name`,
               `surname_name`
        FROM `transferhistory`
        LEFT JOIN `player`
        ON `player_id`=`transferhistory_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team` AS `buyer`
        ON `buyer`.`team_id`=`transferhistory_buyer_id`
        LEFT JOIN `team` AS `seller`
        ON `seller`.`team_id`=`transferhistory_seller_id`
        WHERE `transferhistory_season_id`='$igosja_season_id'
        ORDER BY `transferhistory_price` DESC
        LIMIT 10";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('header_2_title', $continent_name);
$smarty->assign('num', $get_num);
$smarty->assign('continent_array', $continent_array);
$smarty->assign('count_team', $count_team);
$smarty->assign('count_country', $count_country);
$smarty->assign('team_array', $team_array);
$smarty->assign('country_array', $country_array);
$smarty->assign('player_array', $player_array);
$smarty->assign('transfer_array', $transfer_array);

$smarty->display('main.html');