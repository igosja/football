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
$penalty_sql = $mysqli->query($sql);

$penalty_array = $penalty_sql->fetch_all(MYSQLI_ASSOC);

$count_penalty = $penalty_array[0]['count'];

if (0 == $count_penalty)
{
    $sql = "INSERT INTO `teamrole`
            SET `teamrole_team_id`='$get_num'";
    $mysqli->query($sql);
}

if (isset($_POST['penalty_1']))
{
    $penalty_player_id_1    = (int) $_POST['penalty_1'];
    $penalty_player_id_2    = (int) $_POST['penalty_2'];
    $penalty_player_id_3    = (int) $_POST['penalty_3'];
    $penalty_player_id_4    = (int) $_POST['penalty_4'];
    $penalty_player_id_5    = (int) $_POST['penalty_5'];
    $penalty_player_id_6    = (int) $_POST['penalty_6'];
    $penalty_player_id_7    = (int) $_POST['penalty_7'];

    $sql = "UPDATE `teamrole`
            SET `teamrole_penalty_player_id_1`='$penalty_player_id_1',
                `teamrole_penalty_player_id_2`='$penalty_player_id_2',
                `teamrole_penalty_player_id_3`='$penalty_player_id_3',
                `teamrole_penalty_player_id_4`='$penalty_player_id_4',
                `teamrole_penalty_player_id_5`='$penalty_player_id_5',
                `teamrole_penalty_player_id_6`='$penalty_player_id_6',
                `teamrole_penalty_player_id_7`='$penalty_player_id_7'
            WHERE `teamrole_team_id`='$get_num'
            LIMIT 1";
    $mysqli->query($sql);

    redirect('team_lineup_tactic_penalty.php?num=' . $get_num);

    exit;
}

$sql = "SELECT `composure`, `name_name`, `penalty`, `player_id`, `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `penalty`, `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='11'
        ) AS `t1`
        ON `t1`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `composure`, `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='26'
        ) AS `t2`
        ON `t2`.`playerattribute_player_id`=`player_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `penalty` DESC, `composure` DESC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `teamrole_penalty_player_id_1`, `teamrole_penalty_player_id_2`, `teamrole_penalty_player_id_3`, `teamrole_penalty_player_id_4`, `teamrole_penalty_player_id_5`, `teamrole_penalty_player_id_6`, `teamrole_penalty_player_id_7`
        FROM `teamrole`
        WHERE `teamrole_team_id`='$get_num'
        LIMIT 1";
$penalty_sql = $mysqli->query($sql);

$penalty_array = $penalty_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('penalty_array', $penalty_array);

$smarty->display('main.html');