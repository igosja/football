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

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `buyer`.`team_id` AS `buyer_id`,
               `buyer`.`team_name` AS `buyer_name`,
               `name_name`,
               `player_id`,
               `seller`.`team_id` AS `seller_id`,
               `seller`.`team_name` AS `seller_name`,
               `surname_name`,
               `transferhistory_date`,
               `transferhistory_price`
        FROM `transferhistory`
        LEFT JOIN `player`
        ON `player_id`=`transferhistory_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team` AS `buyer`
        ON `buyer`.`team_id`=`transferhistory_buyer_id`
        LEFT JOIN `city` AS `buyer_city`
        ON `buyer`.`team_city_id`=`buyer_city`.`city_id`
        LEFT JOIN `team` AS `seller`
        ON `seller`.`team_id`=`transferhistory_seller_id`
        LEFT JOIN `city` AS `seller_city`
        ON `seller`.`team_city_id`=`seller_city`.`city_id`
        WHERE `transferhistory_season_id`='$igosja_season_id'-'1'
        AND (`seller_city`.`city_country_id`='$num_get'
        OR `buyer_city`.`city_country_id`='$num_get')
        ORDER BY `transferhistory_price` DESC";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $country_name;

include (__DIR__ . '/view/main.php');