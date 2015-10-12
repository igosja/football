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

$sql = "SELECT `corner`,
               `free_kick`,
               `name_name`,
               `out`,
               `player_id`,
               `position_name`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `free_kick`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='6'
        ) AS `t1`
        ON `t1`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `corner`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='14'
        ) AS `t2`
        ON `t2`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `out`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='1'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        LEFT JOIN `playerposition`
        ON `playerposition_player_id`=`player_id`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `position_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN
        (
            SELECT `playerattribute_value` AS `corner`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='14'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `corner` DESC";
$corner_sql = $mysqli->query($sql);

$corner_array = $corner_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN
        (
            SELECT `playerattribute_value` AS `freekick`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='6'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `freekick` DESC";
$freekick_sql = $mysqli->query($sql);

$freekick_array = $freekick_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN
        (
            SELECT `playerattribute_value` AS `out`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='1'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `out` DESC";
$out_sql = $mysqli->query($sql);

$out_array = $out_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_corner_left_player_id_1`,
               `team_corner_left_player_id_2`,
               `team_corner_left_player_id_3`,
               `team_corner_left_player_id_4`,
               `team_corner_left_player_id_5`,
               `team_corner_right_player_id_1`,
               `team_corner_right_player_id_2`,
               `team_corner_right_player_id_3`,
               `team_corner_right_player_id_4`,
               `team_corner_right_player_id_5`,
               `team_freekick_left_player_id_1`,
               `team_freekick_left_player_id_2`,
               `team_freekick_left_player_id_3`,
               `team_freekick_left_player_id_4`,
               `team_freekick_left_player_id_5`,
               `team_freekick_right_player_id_1`,
               `team_freekick_right_player_id_2`,
               `team_freekick_right_player_id_3`,
               `team_freekick_right_player_id_4`,
               `team_freekick_right_player_id_5`,
               `team_out_left_player_id_1`,
               `team_out_left_player_id_2`,
               `team_out_left_player_id_3`,
               `team_out_left_player_id_4`,
               `team_out_left_player_id_5`,
               `team_out_right_player_id_1`,
               `team_out_right_player_id_2`,
               `team_out_right_player_id_3`,
               `team_out_right_player_id_4`,
               `team_out_right_player_id_5`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$standard_sql = $mysqli->query($sql);

$standard_array = $standard_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('corner_array', $corner_array);
$smarty->assign('freekick_array', $freekick_array);
$smarty->assign('out_array', $out_array);
$smarty->assign('standard_array', $standard_array);

$smarty->display('main.html');