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

$sql = "SELECT `country_id`, `country_name`, `continent_id`, `continent_name`
        FROM `country`
        LEFT JOIN `continent`
        ON `continent_id`=`country_continent_id`
        WHERE `country_continent_id`='$get_num'
        ORDER BY `country_name` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('header_2_title', $continent_name);
$smarty->assign('num', $get_num);
$smarty->assign('continent_name', $continent_name);
$smarty->assign('country_array', $country_array);

$smarty->display('main.html');