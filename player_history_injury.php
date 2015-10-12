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

$sql = "SELECT `name_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `team_id`=`player_team_id`
        WHERE `player_id`='$get_num'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    $smarty->display('wrong_page.html');

    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$team_id        = $player_array[0]['team_id'];
$team_name      = $player_array[0]['team_name'];
$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];
$header_2_title = $player_name . ' ' . $player_surname;

$sql = "SELECT `injury_start_date`,
               `injurytype_day`,
               `injurytype_name`
        FROM `injury`
        LEFT JOIN `injurytype`
        ON `injurytype_id`=`injury_injurytype_id`
        WHERE `injury_player_id`='$get_num'
        ORDER BY `injury_start_date` ASC";
$injury_sql = $mysqli->query($sql);

$injury_array = $injury_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('team_id', $team_id);
$smarty->assign('team_name', $team_name);
$smarty->assign('header_2_title', $header_2_title);
$smarty->assign('num', $get_num);
$smarty->assign('injury_array', $injury_array);

$smarty->display('main.html');