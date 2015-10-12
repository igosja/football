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

$sql = "SELECT COUNT(`teamrole_id`) AS `count`
        FROM `teamrole`
        WHERE `teamrole_team_id`='$get_num'";
$standard_sql = $mysqli->query($sql);

$standard_array = $standard_sql->fetch_all(MYSQLI_ASSOC);

$count_standard = $standard_array[0]['count'];

if (0 == $count_standard)
{
    $sql = "INSERT INTO `teamrole`
            SET `teamrole_team_id`='$get_num'";
    $mysqli->query($sql);
}

if (isset($_POST['corner_left_1']))
{
    $corner_left_player_id_1    = (int) $_POST['corner_left_1'];
    $corner_left_player_id_2    = (int) $_POST['corner_left_2'];
    $corner_left_player_id_3    = (int) $_POST['corner_left_3'];
    $corner_left_player_id_4    = (int) $_POST['corner_left_4'];
    $corner_left_player_id_5    = (int) $_POST['corner_left_5'];
    $corner_right_player_id_1   = (int) $_POST['corner_right_1'];
    $corner_right_player_id_2   = (int) $_POST['corner_right_2'];
    $corner_right_player_id_3   = (int) $_POST['corner_right_3'];
    $corner_right_player_id_4   = (int) $_POST['corner_right_4'];
    $corner_right_player_id_5   = (int) $_POST['corner_right_5'];
    $freekick_left_player_id_1  = (int) $_POST['freekick_left_1'];
    $freekick_left_player_id_2  = (int) $_POST['freekick_left_2'];
    $freekick_left_player_id_3  = (int) $_POST['freekick_left_3'];
    $freekick_left_player_id_4  = (int) $_POST['freekick_left_4'];
    $freekick_left_player_id_5  = (int) $_POST['freekick_left_5'];
    $freekick_right_player_id_1 = (int) $_POST['freekick_right_1'];
    $freekick_right_player_id_2 = (int) $_POST['freekick_right_2'];
    $freekick_right_player_id_3 = (int) $_POST['freekick_right_3'];
    $freekick_right_player_id_4 = (int) $_POST['freekick_right_4'];
    $freekick_right_player_id_5 = (int) $_POST['freekick_right_5'];
    $out_left_player_id_1       = (int) $_POST['out_left_1'];
    $out_left_player_id_2       = (int) $_POST['out_left_2'];
    $out_left_player_id_3       = (int) $_POST['out_left_3'];
    $out_left_player_id_4       = (int) $_POST['out_left_4'];
    $out_left_player_id_5       = (int) $_POST['out_left_5'];
    $out_right_player_id_1      = (int) $_POST['out_right_1'];
    $out_right_player_id_2      = (int) $_POST['out_right_2'];
    $out_right_player_id_3      = (int) $_POST['out_right_3'];
    $out_right_player_id_4      = (int) $_POST['out_right_4'];
    $out_right_player_id_5      = (int) $_POST['out_right_5'];

    $sql = "UPDATE `teamrole`
            SET `teamrole_corner_left_player_id_1`='$corner_left_player_id_1',
                `teamrole_corner_left_player_id_2`='$corner_left_player_id_2',
                `teamrole_corner_left_player_id_3`='$corner_left_player_id_3',
                `teamrole_corner_left_player_id_4`='$corner_left_player_id_4',
                `teamrole_corner_left_player_id_5`='$corner_left_player_id_5',
                `teamrole_corner_right_player_id_1`='$corner_right_player_id_1',
                `teamrole_corner_right_player_id_2`='$corner_right_player_id_2',
                `teamrole_corner_right_player_id_3`='$corner_right_player_id_3',
                `teamrole_corner_right_player_id_4`='$corner_right_player_id_4',
                `teamrole_corner_right_player_id_5`='$corner_right_player_id_5',
                `teamrole_freekick_left_player_id_1`='$freekick_left_player_id_1',
                `teamrole_freekick_left_player_id_2`='$freekick_left_player_id_2',
                `teamrole_freekick_left_player_id_3`='$freekick_left_player_id_3',
                `teamrole_freekick_left_player_id_4`='$freekick_left_player_id_4',
                `teamrole_freekick_left_player_id_5`='$freekick_left_player_id_5',
                `teamrole_freekick_right_player_id_1`='$freekick_right_player_id_1',
                `teamrole_freekick_right_player_id_2`='$freekick_right_player_id_2',
                `teamrole_freekick_right_player_id_3`='$freekick_right_player_id_3',
                `teamrole_freekick_right_player_id_4`='$freekick_right_player_id_4',
                `teamrole_freekick_right_player_id_5`='$freekick_right_player_id_5',
                `teamrole_out_left_player_id_1`='$out_left_player_id_1',
                `teamrole_out_left_player_id_2`='$out_left_player_id_2',
                `teamrole_out_left_player_id_3`='$out_left_player_id_3',
                `teamrole_out_left_player_id_4`='$out_left_player_id_4',
                `teamrole_out_left_player_id_5`='$out_left_player_id_5',
                `teamrole_out_right_player_id_1`='$out_right_player_id_1',
                `teamrole_out_right_player_id_2`='$out_right_player_id_2',
                `teamrole_out_right_player_id_3`='$out_right_player_id_3',
                `teamrole_out_right_player_id_4`='$out_right_player_id_4',
                `teamrole_out_right_player_id_5`='$out_right_player_id_5'
            WHERE `teamrole_team_id`='$get_num'
            LIMIT 1";
    $mysqli->query($sql);

    redirect('team_lineup_tactic_standard.php?num=' . $get_num);

    exit;
}

$sql = "SELECT `corner`, `free_kick`, `name_name`, `out`, `player_id`, `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `free_kick`, `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='6'
        ) AS `t1`
        ON `t1`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `corner`, `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='14'
        ) AS `t2`
        ON `t2`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `out`, `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='1'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `free_kick` DESC, `corner` DESC, `out` DESC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `teamrole_corner_left_player_id_1`, `teamrole_corner_left_player_id_2`, `teamrole_corner_left_player_id_3`, `teamrole_corner_left_player_id_4`, `teamrole_corner_left_player_id_5`, `teamrole_corner_right_player_id_1`, `teamrole_corner_right_player_id_2`, `teamrole_corner_right_player_id_3`, `teamrole_corner_right_player_id_4`, `teamrole_corner_right_player_id_5`, `teamrole_freekick_left_player_id_1`, `teamrole_freekick_left_player_id_2`, `teamrole_freekick_left_player_id_3`, `teamrole_freekick_left_player_id_4`, `teamrole_freekick_left_player_id_5`, `teamrole_freekick_right_player_id_1`, `teamrole_freekick_right_player_id_2`, `teamrole_freekick_right_player_id_3`, `teamrole_freekick_right_player_id_4`, `teamrole_freekick_right_player_id_5`, `teamrole_out_left_player_id_1`, `teamrole_out_left_player_id_2`, `teamrole_out_left_player_id_3`, `teamrole_out_left_player_id_4`, `teamrole_out_left_player_id_5`, `teamrole_out_right_player_id_1`, `teamrole_out_right_player_id_2`, `teamrole_out_right_player_id_3`, `teamrole_out_right_player_id_4`, `teamrole_out_right_player_id_5`
        FROM `teamrole`
        WHERE `teamrole_team_id`='$get_num'
        LIMIT 1";
$standard_sql = $mysqli->query($sql);

$standard_array = $standard_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('standard_array', $standard_array);

$smarty->display('main.html');