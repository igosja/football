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

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$get_num'
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

$sql = "SELECT `team_id`,
               `team_name`,
               `team_price`,
               `country_id`,
               `country_name`
        FROM `team`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `country_id`='$get_num'
        AND `team_id`!='0'
        ORDER BY `team_price` DESC";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $country_name;

include (__DIR__ . '/view/main.php');