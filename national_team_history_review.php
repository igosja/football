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

$sql = "SELECT `worldcup_place`,
               `worldcup_season_id`,
               `tournament_id`,
               `tournament_name`
        FROM `worldcup`
        LEFT JOIN `tournament`
        ON `worldcup_tournament_id`=`tournament_id`
        WHERE `worldcup_country_id`='$num_get'
        AND `worldcup_season_id`<'$igosja_season_id'
        ORDER BY `worldcup_season_id` DESC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(1);

$sql = "SELECT `history_date`,
               `user_id`,
               `user_login`
        FROM `history`
        LEFT JOIN `user`
        ON `history_user_id`=`user_id`
        WHERE `history_country_id`='$num_get'
        AND `history_historytext_id`='22'
        ORDER BY `history_date` DESC";
$manager_sql = $mysqli->query($sql);

$manager_array = $manager_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $country_name;
$seo_title          = $header_title . '. История сборной. ' . $seo_title;
$seo_description    = $header_title . '. История сборной. ' . $seo_description;
$seo_keywords       = $header_title . ', история сборной, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');