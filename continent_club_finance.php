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

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}
else
{
    $page = 1;
}

$offset = ($page - 1) * 30;

$sql = "SELECT `team_price`
        FROM `team`
        ORDER BY `team_price` DESC
        LIMIT 1";
$best_team_sql = $mysqli->query($sql);

$best_team_array = $best_team_sql->fetch_all(1);

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `team_id`,
               `team_name`,
               `team_price`,
               `country_id`,
               `country_name`
        FROM `team`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `country_continent_id`='$num_get'
        AND `team_id`!='0'
        ORDER BY `team_price` DESC, `team_id` ASC
        LIMIT $offset, 30";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_page`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(1);
$count_page = $count_page[0]['count_page'];
$count_page = ceil($count_page / 30);

$num                = $num_get;
$header_title       = $continent_name;
$seo_title          = $continent_name . '. Финансовое положение клубов. ' . $seo_title;
$seo_description    = $continent_name . '. Финансовое положение клубов. ' . $seo_description;
$seo_keywords       = $continent_name . ', финансовое положение клубов, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');