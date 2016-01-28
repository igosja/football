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
    $smarty->display('wrong_page.html');
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

$sql = "SELECT `team_price`
        FROM `team`
        ORDER BY `team_price` DESC
        LIMIT 1";
$best_team_sql = $mysqli->query($sql);

$best_team_array = $best_team_sql->fetch_all(MYSQLI_ASSOC);

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
        WHERE `country_continent_id`='$get_num'
        AND `team_id`!='0'
        ORDER BY `team_price` DESC, `team_id` ASC
        LIMIT $offset, 30";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_page`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(MYSQLI_ASSOC);
$count_page = $count_page[0]['count_page'];
$count_page = ceil($count_page / 30);

$num            = $get_num;
$header_title   = $continent_name;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');