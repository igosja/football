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

$sql = "SELECT `game_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE (`game_home_team_id`='$authorization_team_id'
        OR `game_guest_team_id`='$authorization_team_id')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

if (isset($game_array[0]['game_id']))
{
    $game_id = $game_array[0]['game_id'];
}
else
{
    $game_id = 0;
}

$sql = "SELECT COUNT(`game_id`) AS `count`
        FROM `game`
        WHERE `game_id`='$game_id'
        AND (`game_home_team_id`='$get_num'
        OR `game_guest_team_id`='$get_num')";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    $smarty->display('wrong_page.html');
    exit;
}

$sql = "SELECT COUNT(`lineupcurrent_id`) AS `count`
        FROM `lineupcurrent`
        WHERE `lineupcurrent_game_id`='$game_id'
        AND `lineupcurrent_team_id`='$get_num'";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

$count_game = $count_array[0]['count'];

if (0 == $count_game)
{
    $smarty->display('wrong_page.html');
    exit;
}

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    $role_id        = (int) $data['role'];
    $position_id    = (int) $data['position'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_role_id_" . $position_id . "`='$role_id'
            WHERE `lineupcurrent_team_id`='$get_num'
            AND `lineupcurrent_game_id`='$game_id'
            LIMIT 1";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_player.php?num=' . $get_num);
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `lineupcurrent_formation_id`
        FROM `lineupcurrent`
        WHERE `lineupcurrent_team_id`='$get_num'
        AND `lineupcurrent_game_id`='$game_id'
        LIMIT 1";
$lineup_sql = $mysqli->query($sql);

$lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('game_id', $game_id);
$smarty->assign('header_title', $team_name);
$smarty->assign('lineup_array', $lineup_array);

$smarty->display('main.html');