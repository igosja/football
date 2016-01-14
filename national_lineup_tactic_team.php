<?php

include ('include/include.php');

if (isset($authorization_country_id))
{
    $get_num = $authorization_country_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
}

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$get_num'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    $smarty->display('wrong_page.html');
    
    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

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
        WHERE `lineupcurrent_country_id`='$get_num'
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
        WHERE `teaminstruction_country_id`='$get_num'
        AND `teaminstruction_status`='1'
        ORDER BY `teaminstruction_instruction_id` ASC";
$teaminstruction_sql = $mysqli->query($sql);

$teaminstruction_array = $teaminstruction_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $country_name);
$smarty->assign('gamestyle_array', $gamestyle_array);
$smarty->assign('gamemood_array', $gamemood_array);
$smarty->assign('lineup_array', $lineup_array);
$smarty->assign('instruction_array', $instruction_array);
$smarty->assign('teaminstruction_array', $teaminstruction_array);

$smarty->display('main.html');