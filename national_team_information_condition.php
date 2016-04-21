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

$sql = "SELECT `country_name`,
               `city_name`,
               `stadium_capacity`,
               `stadium_length`,
               `stadium_name`,
               `stadium_width`,
               `stadiumquality_name`,
               `team_id`
        FROM `country`
        LEFT JOIN `stadium`
        ON `stadium_id`=`country_stadium_id`
        LEFT JOIN `team`
        ON `stadium_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `stadiumquality`
        ON `stadiumquality_id`=`stadium_stadiumquality_id`
        WHERE `city_country_id`='$num_get'
        ORDER BY `stadium_capacity` DESC
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

$num            = $num_get;
$header_title   = $country_name;

include (__DIR__ . '/view/main.php');