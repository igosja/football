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

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$continent_name = $continent_array[0]['continent_name'];

$sql = "SELECT `country_id`,
               `country_name`,
               `ratingcountry_position`,
               `ratingcountry_value`
        FROM `country`
        LEFT JOIN `continent`
        ON `continent_id`=`country_continent_id`
        CROSS JOIN `ratingcountry`
        ON `ratingcountry_country_id`=`country_id`
        WHERE `country_continent_id`='$num_get'
        ORDER BY `ratingcountry_position` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $continent_name;
$seo_title          = $continent_name . '. Рейтинг сборных. ' . $seo_title;
$seo_description    = $continent_name . '. Рейтинг сборных. ' . $seo_description;
$seo_keywords       = $continent_name . ', рейтинг сборных, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');