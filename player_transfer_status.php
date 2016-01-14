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
               `player_price`,
               `player_salary`,
               `player_statusrent_id`,
               `player_statusteam_id`,
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
        LEFT JOIN `statustransfer`
        ON `statustransfer_id`=`player_statustransfer_id`
        LEFT JOIN `statusrent`
        ON `statusrent_id`=`player_statusrent_id`
        LEFT JOIN `statusteam`
        ON `statusteam_id`=`player_statusteam_id`
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

$sql = "SELECT `team_id`,
               `team_name`,
               `playeroffer_date`,
               `playeroffer_price`
        FROM `playeroffer`
        LEFT JOIN `team`
        ON `team_id`=`playeroffer_team_id`
        WHERE `playeroffer_player_id`='$get_num'
        AND `playeroffer_offertype_id`='1'
        ORDER BY `playeroffer_date` DESC
        LIMIT 5";
$playeroffer_sql = $mysqli->query($sql);

$playeroffer_array = $playeroffer_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `statusteam_id`,
               `statusteam_name`
        FROM `statusteam`
        ORDER BY `statusteam_id` ASC";
$statusteam_sql = $mysqli->query($sql);

$statusteam_array = $statusteam_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `statustransfer_id`,
               `statustransfer_name`
        FROM `statustransfer`
        ORDER BY `statustransfer_id` ASC";
$statustransfer_sql = $mysqli->query($sql);

$statustransfer_array = $statustransfer_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `statusrent_id`,
               `statusrent_name`
        FROM `statusrent`
        ORDER BY `statusrent_id` ASC";
$statusrent_sql = $mysqli->query($sql);

$statusrent_array = $statusrent_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('team_id', $team_id);
$smarty->assign('team_name', $team_name);
$smarty->assign('header_title', $header_2_title);
$smarty->assign('num', $get_num);
$smarty->assign('player_array', $player_array);
$smarty->assign('playeroffer_array', $playeroffer_array);
$smarty->assign('statusteam_array', $statusteam_array);
$smarty->assign('statustransfer_array', $statustransfer_array);
$smarty->assign('statusrent_array', $statusrent_array);

$smarty->display('main.html');