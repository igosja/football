<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

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
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$continent_name = $continent_array[0]['continent_name'];

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}
else
{
    $page = 1;
}

$offset = ($page - 1) * 30;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `buyer`.`team_id` AS `buyer_id`,
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
        LEFT JOIN `team` AS `seller`
        ON `seller`.`team_id`=`transferhistory_seller_id`
        WHERE `transferhistory_season_id`='$igosja_season_id'
        ORDER BY `transferhistory_price` DESC, `transferhistory_id` ASC
        LIMIT $offset, 30";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_page`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(MYSQLI_ASSOC);
$count_page = $count_page[0]['count_page'];
$count_page = ceil($count_page / 30);

$num            = $get_num;
$header_title   = $continent_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');