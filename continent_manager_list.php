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
               `country_id`,
               `country_name`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`,
               `user_reputation`
        FROM `user`
        CROSS JOIN `team`
        ON `team_user_id`=`user_id`
        LEFT JOIN `country`
        ON `country_id`=`user_country_id`
        WHERE `user_id`!='0'
        ORDER BY `user_reputation` DESC, `user_id` ASC
        LIMIT $offset, 30";
$user_sql = $mysqli->query($sql);

$count_user = $user_sql->num_rows;
$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_page`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(MYSQLI_ASSOC);
$count_page = $count_page[0]['count_page'];
$count_page = ceil($count_page / 30);

$num            = $get_num;
$header_title   = $continent_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');