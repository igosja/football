<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_user_id))
{
    $num_get = $authorization_user_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

if (isset($_GET['country']) && !empty($_GET['country']))
{
    $sql_country = (int) $_GET['country'];
}
else
{
    $sql_country = 0;
}

if (0 == $sql_country)
{
    $sql_country = 1;
}
else
{
    $sql_country = "`country_id`='$sql_country'";
}

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
               `team_finance`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`,
               `user_id`,
               `user_login`
        FROM `team`
        LEFT JOIN `user`
        ON `user_id`=`team_user_id`
        LEFT JOIN `city`
        ON `city_id`=`team_city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `standing`
        ON `standing_team_id`=`team_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        WHERE `standing_season_id`='$igosja_season_id'
        AND `tournament_tournamenttype_id`='2'
        AND $sql_country
        ORDER BY `user_id` ASC, `team_finance` DESC, `team_id` ASC
        LIMIT $offset, 30";
$team_sql = $mysqli->query($sql);

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_page`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(1);
$count_page = $count_page[0]['count_page'];
$count_page = ceil($count_page / 30);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_season_id`!='0'
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(1);

$num                = $authorization_user_id;
$header_title       = $authorization_login;
$seo_title          = $header_title . '. ???????????????? ???? ?????????? ??????????. ' . $seo_title;
$seo_description    = $header_title . '. ???????????????? ???? ?????????? ??????????. ' . $seo_description;
$seo_keywords       = $header_title . ', ???????????????? ???? ?????????? ??????????, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');