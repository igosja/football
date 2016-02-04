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

$sql = "SELECT `country_id`,
               `country_name`,
               `tournament_id`,
               `tournament_name`,
               `tournament_reputation`
        FROM `country`
        LEFT JOIN `continent`
        ON `continent_id`=`country_continent_id`
        CROSS JOIN `tournament`
        ON `tournament_country_id`=`country_id`
        WHERE `country_continent_id`='$get_num'
        AND `tournament_tournamenttype_id`='3'
        ORDER BY `tournament_reputation` DESC, `tournament_id` ASC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $continent_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');