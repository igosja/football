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
        WHERE `city_country_id`='$get_num'
        ORDER BY `stadium_capacity` DESC
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$num            = $get_num;
$header_title   = $country_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');