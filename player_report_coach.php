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
               `player_ability`,
               `position_description`,
               `role_name`,
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
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        LEFT JOIN `positionrole`
        ON `positionrole_position_id`=`position_id`
        LEFT JOIN `role`
        ON `positionrole_role_id`=`role_id`
        WHERE `player_id`='$get_num'
        ORDER BY `positionrole_position_id` ASC";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    $smarty->display('wrong_page.html');
    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];
$header_2_title = $player_name . ' ' . $player_surname;

$smarty->assign('num', $get_num);
$smarty->assign('header_itle', $header_2_title);
$smarty->assign('player_array', $player_array);

$smarty->display('main.html');