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

$sql = "SELECT `city_name`, `team_id`, `team_name`, `team_school_level`, `team_training_level`, `stadium_capacity`, `stadium_length`, `stadium_name`, `stadium_width`
        FROM `team`
        LEFT JOIN `stadium`
        ON `stadium_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
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

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('team_array', $team_array);

$smarty->display('main.html');