<?php

include ('include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
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

$sql = "SELECT COUNT(`lineupcurrent_id`) AS `count`
        FROM `lineupcurrent`
        WHERE `lineupcurrent_team_id`='$get_num'";
$lineupcurrent_sql = $mysqli->query($sql);

$lineupcurrent_array = $lineupcurrent_sql->fetch_all(MYSQLI_ASSOC);

$count_lineupcurrent = $lineupcurrent_array[0]['count'];

if (0 == $count_lineupcurrent)
{
    $sql = "INSERT INTO `lineupcurrent`
            SET `lineupcurrent_team_id`='$get_num'";
    $mysqli->query($sql);
}

if (isset($_POST['formation_id']))
{
    $formation_id                   = (int) $_POST['formation_id'];
    $gamemood_id                    = (int) $_POST['gamemood_id'];
    $gamestyle_id                   = (int) $_POST['gamestyle_id'];
    $lineupcurrent_player_id_1      = (int) $_POST['player_1'];
    $lineupcurrent_player_id_2      = (int) $_POST['player_2'];
    $lineupcurrent_player_id_3      = (int) $_POST['player_3'];
    $lineupcurrent_player_id_4      = (int) $_POST['player_4'];
    $lineupcurrent_player_id_5      = (int) $_POST['player_5'];
    $lineupcurrent_player_id_6      = (int) $_POST['player_6'];
    $lineupcurrent_player_id_7      = (int) $_POST['player_7'];
    $lineupcurrent_player_id_8      = (int) $_POST['player_8'];
    $lineupcurrent_player_id_9      = (int) $_POST['player_9'];
    $lineupcurrent_player_id_10     = (int) $_POST['player_10'];
    $lineupcurrent_player_id_11     = (int) $_POST['player_11'];
    $lineupcurrent_player_id_12     = (int) $_POST['player_12'];
    $lineupcurrent_player_id_13     = (int) $_POST['player_13'];
    $lineupcurrent_player_id_14     = (int) $_POST['player_14'];
    $lineupcurrent_player_id_15     = (int) $_POST['player_15'];
    $lineupcurrent_player_id_16     = (int) $_POST['player_16'];
    $lineupcurrent_player_id_17     = (int) $_POST['player_17'];
    $lineupcurrent_player_id_18     = (int) $_POST['player_18'];
    $lineupcurrent_position_id_1    = (int) $_POST['position_1'];
    $lineupcurrent_position_id_2    = (int) $_POST['position_2'];
    $lineupcurrent_position_id_3    = (int) $_POST['position_3'];
    $lineupcurrent_position_id_4    = (int) $_POST['position_4'];
    $lineupcurrent_position_id_5    = (int) $_POST['position_5'];
    $lineupcurrent_position_id_6    = (int) $_POST['position_6'];
    $lineupcurrent_position_id_7    = (int) $_POST['position_7'];
    $lineupcurrent_position_id_8    = (int) $_POST['position_8'];
    $lineupcurrent_position_id_9    = (int) $_POST['position_9'];
    $lineupcurrent_position_id_10   = (int) $_POST['position_10'];
    $lineupcurrent_position_id_11   = (int) $_POST['position_11'];
    $lineupcurrent_position_id_12   = (int) $_POST['position_12'];
    $lineupcurrent_position_id_13   = (int) $_POST['position_13'];
    $lineupcurrent_position_id_14   = (int) $_POST['position_14'];
    $lineupcurrent_position_id_15   = (int) $_POST['position_15'];
    $lineupcurrent_position_id_16   = (int) $_POST['position_16'];
    $lineupcurrent_position_id_17   = (int) $_POST['position_17'];
    $lineupcurrent_position_id_18   = (int) $_POST['position_18'];
    $lineupcurrent_role_id_1        = (int) $_POST['role_1'];
    $lineupcurrent_role_id_2        = (int) $_POST['role_2'];
    $lineupcurrent_role_id_3        = (int) $_POST['role_3'];
    $lineupcurrent_role_id_4        = (int) $_POST['role_4'];
    $lineupcurrent_role_id_5        = (int) $_POST['role_5'];
    $lineupcurrent_role_id_6        = (int) $_POST['role_6'];
    $lineupcurrent_role_id_7        = (int) $_POST['role_7'];
    $lineupcurrent_role_id_8        = (int) $_POST['role_8'];
    $lineupcurrent_role_id_9        = (int) $_POST['role_9'];
    $lineupcurrent_role_id_10       = (int) $_POST['role_10'];
    $lineupcurrent_role_id_11       = (int) $_POST['role_11'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_formation_id`='$formation_id',
                `lineupcurrent_gamemood_id`='$gamemood_id',
                `lineupcurrent_gamestyle_id`='$gamestyle_id',
                `lineupcurrent_player_id_1`='$lineupcurrent_player_id_1',
                `lineupcurrent_player_id_2`='$lineupcurrent_player_id_2',
                `lineupcurrent_player_id_3`='$lineupcurrent_player_id_3',
                `lineupcurrent_player_id_4`='$lineupcurrent_player_id_4',
                `lineupcurrent_player_id_5`='$lineupcurrent_player_id_5',
                `lineupcurrent_player_id_6`='$lineupcurrent_player_id_6',
                `lineupcurrent_player_id_7`='$lineupcurrent_player_id_7',
                `lineupcurrent_player_id_8`='$lineupcurrent_player_id_8',
                `lineupcurrent_player_id_9`='$lineupcurrent_player_id_9',
                `lineupcurrent_player_id_10`='$lineupcurrent_player_id_10',
                `lineupcurrent_player_id_11`='$lineupcurrent_player_id_11',
                `lineupcurrent_player_id_12`='$lineupcurrent_player_id_12',
                `lineupcurrent_player_id_13`='$lineupcurrent_player_id_13',
                `lineupcurrent_player_id_14`='$lineupcurrent_player_id_14',
                `lineupcurrent_player_id_15`='$lineupcurrent_player_id_15',
                `lineupcurrent_player_id_16`='$lineupcurrent_player_id_16',
                `lineupcurrent_player_id_17`='$lineupcurrent_player_id_17',
                `lineupcurrent_player_id_18`='$lineupcurrent_player_id_18',
                `lineupcurrent_position_id_1`='$lineupcurrent_position_id_1',
                `lineupcurrent_position_id_2`='$lineupcurrent_position_id_2',
                `lineupcurrent_position_id_3`='$lineupcurrent_position_id_3',
                `lineupcurrent_position_id_4`='$lineupcurrent_position_id_4',
                `lineupcurrent_position_id_5`='$lineupcurrent_position_id_5',
                `lineupcurrent_position_id_6`='$lineupcurrent_position_id_6',
                `lineupcurrent_position_id_7`='$lineupcurrent_position_id_7',
                `lineupcurrent_position_id_8`='$lineupcurrent_position_id_8',
                `lineupcurrent_position_id_9`='$lineupcurrent_position_id_9',
                `lineupcurrent_position_id_10`='$lineupcurrent_position_id_10',
                `lineupcurrent_position_id_11`='$lineupcurrent_position_id_11',
                `lineupcurrent_position_id_12`='$lineupcurrent_position_id_12',
                `lineupcurrent_position_id_13`='$lineupcurrent_position_id_13',
                `lineupcurrent_position_id_14`='$lineupcurrent_position_id_14',
                `lineupcurrent_position_id_15`='$lineupcurrent_position_id_15',
                `lineupcurrent_position_id_16`='$lineupcurrent_position_id_16',
                `lineupcurrent_position_id_17`='$lineupcurrent_position_id_17',
                `lineupcurrent_position_id_18`='$lineupcurrent_position_id_18',
                `lineupcurrent_role_id_1`='$lineupcurrent_role_id_1',
                `lineupcurrent_role_id_2`='$lineupcurrent_role_id_2',
                `lineupcurrent_role_id_3`='$lineupcurrent_role_id_3',
                `lineupcurrent_role_id_4`='$lineupcurrent_role_id_4',
                `lineupcurrent_role_id_5`='$lineupcurrent_role_id_5',
                `lineupcurrent_role_id_6`='$lineupcurrent_role_id_6',
                `lineupcurrent_role_id_7`='$lineupcurrent_role_id_7',
                `lineupcurrent_role_id_8`='$lineupcurrent_role_id_8',
                `lineupcurrent_role_id_9`='$lineupcurrent_role_id_9',
                `lineupcurrent_role_id_10`='$lineupcurrent_role_id_10',
                `lineupcurrent_role_id_11`='$lineupcurrent_role_id_11'
            WHERE `lineupcurrent_team_id`='$get_num'
            LIMIT 1";
    $mysqli->query($sql);

    redirect('team_lineup_tactic_review.php?num=' . $get_num);

    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `name_name`,
               `player_condition`,
               `player_id`,
               `player_practice`,
               `position_name`,
               `surname_name`,
               `team_id`,
               `team_name`
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
        AND `playerposition_value`='100'
        ORDER BY `position_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `formation_id`, `formation_name`
        FROM `formation`
        ORDER BY `formation_id` ASC";
$formation_sql = $mysqli->query($sql);

$formation_array = $formation_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamemood_id`, `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamestyle_id`, `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineupcurrent_formation_id`,
               `lineupcurrent_gamemood_id`,
               `lineupcurrent_gamestyle_id`,
               `lineupcurrent_player_id_1`,
               `lineupcurrent_player_id_2`,
               `lineupcurrent_player_id_3`,
               `lineupcurrent_player_id_4`,
               `lineupcurrent_player_id_5`,
               `lineupcurrent_player_id_6`,
               `lineupcurrent_player_id_7`,
               `lineupcurrent_player_id_8`,
               `lineupcurrent_player_id_9`,
               `lineupcurrent_player_id_10`,
               `lineupcurrent_player_id_11`,
               `lineupcurrent_player_id_12`,
               `lineupcurrent_player_id_13`,
               `lineupcurrent_player_id_14`,
               `lineupcurrent_player_id_15`,
               `lineupcurrent_player_id_16`,
               `lineupcurrent_player_id_17`,
               `lineupcurrent_player_id_18`,
               `lineupcurrent_position_id_1`,
               `lineupcurrent_position_id_2`,
               `lineupcurrent_position_id_3`,
               `lineupcurrent_position_id_4`,
               `lineupcurrent_position_id_5`,
               `lineupcurrent_position_id_6`,
               `lineupcurrent_position_id_7`,
               `lineupcurrent_position_id_8`,
               `lineupcurrent_position_id_9`,
               `lineupcurrent_position_id_10`,
               `lineupcurrent_position_id_11`,
               `lineupcurrent_position_id_12`,
               `lineupcurrent_position_id_13`,
               `lineupcurrent_position_id_14`,
               `lineupcurrent_position_id_15`,
               `lineupcurrent_position_id_16`,
               `lineupcurrent_position_id_17`,
               `lineupcurrent_position_id_18`,
               `lineupcurrent_role_id_1`,
               `lineupcurrent_role_id_2`,
               `lineupcurrent_role_id_3`,
               `lineupcurrent_role_id_4`,
               `lineupcurrent_role_id_5`,
               `lineupcurrent_role_id_6`,
               `lineupcurrent_role_id_7`,
               `lineupcurrent_role_id_8`,
               `lineupcurrent_role_id_9`,
               `lineupcurrent_role_id_10`,
               `lineupcurrent_role_id_11`
        FROM `lineupcurrent`
        WHERE `lineupcurrent_team_id`='$get_num'
        LIMIT 1";
$lineup_sql = $mysqli->query($sql);

$lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('formation_array', $formation_array);
$smarty->assign('gamemood_array', $gamemood_array);
$smarty->assign('gamestyle_array', $gamestyle_array);
$smarty->assign('lineup_array', $lineup_array);

$smarty->display('main.html');