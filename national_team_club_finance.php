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

$country_array = $country_sql->fetch_all(1);

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
        WHERE `country_id`='$num_get'
        AND `team_id`!='0'
        ORDER BY `team_price` DESC";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $country_name;
$seo_title          = $header_title . '. Финансовое положение клубов. ' . $seo_title;
$seo_description    = $header_title . '. Финансовое положение клубов. ' . $seo_description;
$seo_keywords       = $header_title . ', финансовое положение клубов, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');