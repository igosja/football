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

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    $smarty->display('wrong_page.html');

    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `country_id`, `country_name`, `name_name`, `staff_id`, `staffpost_name`, `surname_name`
        FROM `staff`
        LEFT JOIN `country`
        ON `staff_country_id`=`country_id`
        LEFT JOIN `name`
        ON `name_id`=`staff_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`staff_surname_id`
        LEFT JOIN `staffpost`
        ON `staffpost_id`=`staff_staffpost_id`
        WHERE `staff_team_id`='$get_num'";
$staff_sql = $mysqli->query($sql);

$staff_array = $staff_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('staff_array', $staff_array);

$smarty->display('main.html');