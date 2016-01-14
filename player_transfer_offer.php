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
               `player_statustransfer_id`,
               `player_transfer_price`,
               `statusrent_name`,
               `statusteam_name`,
               `statustransfer_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `statusrent`
        ON `statusrent_id`=`player_statusrent_id`
        LEFT JOIN `statusteam`
        ON `statusteam_id`=`player_statusteam_id`
        LEFT JOIN `statustransfer`
        ON `statustransfer_id`=`player_statustransfer_id`
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

$sql = "SELECT `offertype_id`,
               `offertype_name`
        FROM `offertype`
        WHERE `offertype_status`='1'
        ORDER BY `offertype_id` ASC";
$offertype_sql = $mysqli->query($sql);

$offertype_array = $offertype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('team_id', $team_id);
$smarty->assign('team_name', $team_name);
$smarty->assign('header_title', $header_2_title);
$smarty->assign('num', $get_num);
$smarty->assign('player_array', $player_array);
$smarty->assign('offertype_array', $offertype_array);

$smarty->display('main.html');