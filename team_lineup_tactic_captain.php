<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/only_my_team.html');
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
    include($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    foreach ($data as $key => $value)
    {
        $captain_id = (int) $key;
        $player_id  = (int) $value;

        $sql = "UPDATE `team`
                SET `team_captain_player_id_" . $captain_id . "`='$player_id'
                WHERE `team_id`='$get_num'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_captain.php?num=' . $get_num);
    exit;
}

$sql = "SELECT `leader`,
               `name_name`,
               `player_age`,
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
            SELECT `playerattribute_value` AS `leader`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='22'
        ) AS `t1`
        ON `playerattribute_player_id`=`player_id`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `position_id` ASC, `player_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `leader`,
               `name_name`,
               `player_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `leader`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='22'
        ) AS `t1`
        ON `playerattribute_player_id`=`player_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `leader` DESC, `player_id` ASC";
$leader_sql = $mysqli->query($sql);

$leader_array = $leader_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_captain_player_id_1`,
               `team_captain_player_id_2`,
               `team_captain_player_id_3`,
               `team_captain_player_id_4`,
               `team_captain_player_id_5`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$captain_sql = $mysqli->query($sql);

$captain_array = $captain_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');