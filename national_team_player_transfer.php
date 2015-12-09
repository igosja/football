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

$sql = "SELECT `country_name`
        FROM `country`
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
        WHERE `transferhistory_season_id`='$igosja_season_id'
        AND (`seller_city`.`city_country_id`='$get_num'
        OR `buyer_city`.`city_country_id`='$get_num')
        ORDER BY `transferhistory_price` DESC";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('team_name', $country_name);
$smarty->assign('num', $get_num);
$smarty->assign('transfer_array', $transfer_array);

$smarty->display('main.html');