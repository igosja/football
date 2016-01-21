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

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    $smarty->display('wrong_page.html');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `shedule_date`,
               `stage_id`,
               `stage_name`
        FROM `game`
        LEFT JOIN `stage`
        ON `game_stage_id`=`stage_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$get_num'
        GROUP BY `stage_id`
        ORDER BY `shedule_date` ASC";
$stage_sql = $mysqli->query($sql);

$stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $tournament_name);
$smarty->assign('stage_array', $stage_array);

$smarty->display('main.html');