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
$user_array = $user_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_page`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(1);
$count_page = $count_page[0]['count_page'];
$count_page = ceil($count_page / 30);

$num                = $num_get;
$header_title       = $continent_name;
$seo_title          = $continent_name . '. Рейтинг менеджеров. ' . $seo_title;
$seo_description    = $continent_name . '. Рейтинг менеджеров. ' . $seo_description;
$seo_keywords       = $continent_name . ', рейтинг менеджеров, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');