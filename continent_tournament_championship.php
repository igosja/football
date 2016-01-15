<?php

include ('include/include.php');

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
        AND `tournament_tournamenttype_id`='2'
        ORDER BY `tournament_reputation` DESC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('header_title', $continent_name);
$smarty->assign('num', $get_num);
$smarty->assign('tournament_array', $tournament_array);

$smarty->display('main.html');