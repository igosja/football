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
$captain_sql = $mysqli->query($sql);

$captain_array = $captain_sql->fetch_all(MYSQLI_ASSOC);

$count_captain = $captain_array[0]['count'];

if (0 == $count_captain)
{
    $sql = "INSERT INTO `teamrole`
            SET `teamrole_team_id`='$get_num'";
    $mysqli->query($sql);
}

if (isset($_POST['captain_1']))
{
    $captain_player_id_1    = (int) $_POST['captain_1'];
    $captain_player_id_2    = (int) $_POST['captain_2'];
    $captain_player_id_3    = (int) $_POST['captain_3'];
    $captain_player_id_4    = (int) $_POST['captain_4'];
    $captain_player_id_5    = (int) $_POST['captain_5'];

    $sql = "UPDATE `teamrole`
            SET `teamrole_captain_player_id_1`='$captain_player_id_1',
                `teamrole_captain_player_id_2`='$captain_player_id_2',
                `teamrole_captain_player_id_3`='$captain_player_id_3',
                `teamrole_captain_player_id_4`='$captain_player_id_4',
                `teamrole_captain_player_id_5`='$captain_player_id_5'
            WHERE `teamrole_team_id`='$get_num'
            LIMIT 1";
    $mysqli->query($sql);

    redirect('team_lineup_tactic_captain.php?num=' . $get_num);

    exit;
}

$sql = "SELECT `leader`, `name_name`, `player_age`, `player_id`, `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `leader`, `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='22'
        ) AS `t1`
        ON `playerattribute_player_id`=`player_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `leader` DESC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `teamrole_captain_player_id_1`, `teamrole_captain_player_id_2`, `teamrole_captain_player_id_3`, `teamrole_captain_player_id_4`, `teamrole_captain_player_id_5`
        FROM `teamrole`
        WHERE `teamrole_team_id`='$get_num'
        LIMIT 1";
$captain_sql = $mysqli->query($sql);

$captain_array = $captain_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('captain_array', $captain_array);

$smarty->display('main.html');