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

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    $gamemood_id  = (int) $data['gamemood'];
    $gamestyle_id = (int) $data['gamestyle'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_gamemood_id`='$gamemood_id',
                `lineupcurrent_gamestyle_id`='$gamestyle_id'
            WHERE `lineupcurrent_team_id`='$get_num'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "UPDATE `teaminstruction`
            SET `teaminstruction_status`='0'
            WHERE `teaminstruction_team_id`='$get_num'";
    $mysqli->query($sql);

    foreach ($data['instruction'] as $item)
    {
        $instruction_id = (int) $item;

        $sql = "SELECT `teaminstruction_id`
                FROM `teaminstruction`
                WHERE `teaminstruction_team_id`='$authorization_team_id'
                AND `teaminstruction_instruction_id`='$instruction_id'
                LIMIT 1";
        $teaminstruction_sql = $mysqli->query($sql);

        $count_teaminstruction = $teaminstruction_sql->num_rows;

        if (0 == $count_teaminstruction)
        {
            $sql = "INSERT INTO `teaminstruction`
                    SET `teaminstruction_team_id`='$authorization_team_id',
                        `teaminstruction_instruction_id`='$instruction_id'";
            $mysqli->query($sql);
        }
        else
        {
            $teaminstruction_array = $teaminstruction_sql->fetch_all(MYSQLI_ASSOC);

            $teaminstruction_id = $teaminstruction_array[0]['teaminstruction_id'];

            $sql = "UPDATE `teaminstruction`
                    SET `teaminstruction_status`='1'
                    WHERE `teaminstruction_id`='$teaminstruction_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_team.php?num=' . $get_num);
    exit;
}

$sql = "SELECT `gamestyle_description`,
               `gamestyle_id`,
               `gamestyle_name`
        FROM `gamestyle`
        ORDER BY `gamestyle_id` ASC";
$gamestyle_sql = $mysqli->query($sql);

$gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gamemood_description`,
               `gamemood_id`,
               `gamemood_name`
        FROM `gamemood`
        ORDER BY `gamemood_id` ASC";
$gamemood_sql = $mysqli->query($sql);

$gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineupcurrent_gamemood_id`,
               `lineupcurrent_gamestyle_id`
        FROM `lineupcurrent`
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
$smarty->assign('header_title', $team_name);
$smarty->assign('gamestyle_array', $gamestyle_array);
$smarty->assign('gamemood_array', $gamemood_array);
$smarty->assign('lineup_array', $lineup_array);
$smarty->assign('instruction_array', $instruction_array);
$smarty->assign('teaminstruction_array', $teaminstruction_array);

$smarty->display('main.html');