<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `continent_name`
        FROM `continent`
        WHERE `continent_id`='$num_get'
        LIMIT 1";
$continent_sql = $mysqli->query($sql);

$count_continent = $continent_sql->num_rows;

if (0 == $count_continent)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$continent_array = $continent_sql->fetch_all(1);

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
        WHERE `country_continent_id`='$num_get'
        AND `team_id`!='0'
        ORDER BY `team_reputation` DESC, `team_id` ASC
        LIMIT 10";
$team_sql = $mysqli->query($sql);

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_team`";
$count_team = $mysqli->query($sql);
$count_team = $count_team->fetch_all(1);
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

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_country`";
$count_country = $mysqli->query($sql);
$count_country = $count_country->fetch_all(1);
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
        WHERE `country_continent_id`='$num_get'
        AND `team_id`!='0'
        ORDER BY `player_reputation` DESC, `player_id` ASC
        LIMIT 10";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(1);

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
        WHERE `transferhistory_season_id`='$igosja_season_id'-'1'
        ORDER BY `transferhistory_price` DESC
        LIMIT 10";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $continent_name;
$seo_title          = $continent_name . '. Обзор. ' . $seo_title;
$seo_description    = $continent_name . '. Обзор. ' . $seo_description;
$seo_keywords       = $continent_name . ', обзор, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');