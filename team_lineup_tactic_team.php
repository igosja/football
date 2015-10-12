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

$sql = "SELECT `gamestyle_id`,
               `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamemood_id`,
               `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamemood_description`,
               `gamemood_name`,
               `gamestyle_description`,
               `gamestyle_name`,
               `lineupcurrent_gamemood_id`,
               `lineupcurrent_gamestyle_id`
        FROM `lineupcurrent`
        LEFT JOIN `gamestyle`
        ON `gamestyle_id`=`lineupcurrent_gamestyle_id`
        LEFT JOIN `gamemood`
        ON `gamemood_id`=`lineupcurrent_gamemood_id`
        WHERE `lineupcurrent_team_id`='$get_num'
        LIMIT 1";
$lineup_sql = $mysqli->query($sql);

$lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `instruction_id`,
               `instruction_name`,
               `instructionchapter_id`,
               `instructionchapter_name`
        FROM `instruction`
        LEFT JOIN `instructionchapter`
        ON `instruction_instructionchapter_id`=`instructionchapter_id`
        ORDER BY `instructionchapter_id` ASC, `instruction_id` ASC";
$instruction_sql = $mysqli->query($sql);

$instruction_array = $instruction_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `teaminstruction_instruction_id`
        FROM `teaminstruction`
        WHERE `teaminstruction_team_id`='$get_num'
        AND `teaminstruction_status`='1'
        ORDER BY `teaminstruction_instruction_id` ASC";
$teaminstruction_sql = $mysqli->query($sql);

$teaminstruction_array = $teaminstruction_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('gamestyle_array', $gamestyle_array);
$smarty->assign('gamemood_array', $gamemood_array);
$smarty->assign('lineup_array', $lineup_array);
$smarty->assign('instruction_array', $instruction_array);
$smarty->assign('teaminstruction_array', $teaminstruction_array);

$smarty->display('main.html');