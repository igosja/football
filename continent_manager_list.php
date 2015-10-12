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
        ORDER BY `user_reputation` DESC";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('header_2_title', $continent_name);
$smarty->assign('num', $get_num);
$smarty->assign('user_array', $user_array);

$smarty->display('main.html');