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

$sql = "SELECT `team_id`,
               `team_name`,
               `team_reputation`,
               `country_id`,
               `country_name`
        FROM `team`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `country_continent_id`='$get_num'
        AND `team_id`!='0'
        ORDER BY `team_reputation` DESC";
$team_sql = $mysqli->query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('header_2_title', $continent_name);
$smarty->assign('num', $get_num);
$smarty->assign('team_array', $team_array);

$smarty->display('main.html');