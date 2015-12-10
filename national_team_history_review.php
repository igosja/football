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

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$get_num'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    $smarty->display('wrong_page.html');

    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `worldcup_place`,
               `worldcup_season_id`,
               `tournament_id`,
               `tournament_name`
        FROM `worldcup`
        LEFT JOIN `tournament`
        ON `worldcup_tournament_id`=`tournament_id`
        WHERE `worldcup_country_id`='$get_num'
        ORDER BY `worldcup_season_id` DESC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `history_date`,
               `user_login`
        FROM `history`
        LEFT JOIN `user`
        ON `history_user_id`=`user_id`
        WHERE `history_country_id`='$get_num'
        AND `history_historytext_id`='1'
        ORDER BY `history_date` DESC";
$manager_sql = $mysqli->query($sql);

$manager_array = $manager_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $country_name);
$smarty->assign('tournament_array', $tournament_array);
$smarty->assign('manager_array', $manager_array);

$smarty->display('main.html');