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

$sql = "SELECT `player_id`, `name_name`, `surname_name`, `team_id`, `team_name`, `position_name`
        FROM `playerposition`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        LEFT JOIN `player`
        ON `playerposition_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `team_id`='$get_num'
        AND `playerposition_value`='100'";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('player_array', $player_array);

$smarty->display('main.html');